<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $database;
    protected $paydunyaConfig;

    public function __construct()
    {
        try {
            $firebase = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS', 'firebase-credentials.json')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL', 'https://araidioni-default-rtdb.firebaseio.com/'));

            $this->database = $firebase->createDatabase();
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
        }

        // CONFIGURATION CORRIGÉE
        $this->paydunyaConfig = [
            'merchant_id' => env('PAYDUNYA_MERCHANT_ID'),
            'public_key' => env('PAYDUNYA_PUBLIC_KEY'),
            'private_key' => env('PAYDUNYA_PRIVATE_KEY'),
            'token' => env('PAYDUNYA_TOKEN'),
            'base_url' => env('PAYDUNYA_BASE_URL', 'https://api.paydunya.com'),
            'success_url' => url(env('PAYDUNYA_SUCCESS_URL', '/payment/success')),
            'cancel_url' => url(env('PAYDUNYA_CANCEL_URL', '/payment/cancel')),
            'mode' => env('PAYDUNYA_MODE', 'test')
        ];
    }

/**
 * Initialiser un paiement - VERSION RÉELLE PAYDUNYA
 */
public function initPayment(Request $request)
{
    try {
        Log::info('=== PAYMENT INITIATION START ===');

        // Validation
        $validated = $request->validate([
            'reservation_id' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'customer_name' => 'required|string'
        ]);

        // Vérifier que la réservation n'a pas déjà été payée
        $reservationRef = $this->database->getReference('reservations/' . $validated['reservation_id']);
        $reservationSnapshot = $reservationRef->getSnapshot();

        if (!$reservationSnapshot->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Réservation non trouvée'
            ], 404);
        }

        $reservation = $reservationSnapshot->getValue();

        // ✅ EMPÊCHER LA DOUBLE RÉSERVATION
        if (isset($reservation['payment_status']) && $reservation['payment_status'] === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Cette réservation a déjà été payée'
            ], 400);
        }

        // Marquer la réservation comme "en attente de paiement"
        $reservationRef->update([
            'payment_status' => 'pending',
            'payment_attempt_at' => now()->timestamp
        ]);

        // Générer ID de paiement
        $paymentId = 'PAY_' . Str::upper(Str::random(16));

        // ==================== APPEL RÉEL À L'API PAYDUNYA ====================
        $paydunyaResponse = $this->createPaydunyaInvoice([
            'payment_id' => $paymentId,
            'reservation_id' => $validated['reservation_id'],
            'amount' => $validated['amount'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone']
        ]);

        if (!$paydunyaResponse['success']) {
            // En cas d'erreur PayDunya, marquer la réservation comme échouée
            $reservationRef->update([
                'payment_status' => 'failed',
                'payment_error' => $paydunyaResponse['error']
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur PayDunya: ' . $paydunyaResponse['error']
            ], 500);
        }

        // Sauvegarder le paiement en attente
        $paymentData = [
            'payment_id' => $paymentId,
            'reservation_id' => $validated['reservation_id'],
            'amount' => $validated['amount'],
            'currency' => 'XOF',
            'status' => 'pending',
            'created_at' => now()->timestamp,
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_name' => $validated['customer_name'],
            'paydunya_invoice_url' => $paydunyaResponse['invoice_url'],
            'paydunya_token' => $paydunyaResponse['token'],
            'test_mode' => false // ✅ MODE RÉEL
        ];

        $this->database->getReference('payments/' . $paymentId)->set($paymentData);

        Log::info('Payment initiated with PayDunya: ' . $paymentId);

        return response()->json([
            'success' => true,
            'payment_url' => $paydunyaResponse['invoice_url'], // ✅ URL RÉELLE DE PAYDUNYA
            'payment_id' => $paymentId,
            'message' => 'Redirection vers PayDunya...',
            'test_mode' => false
        ]);

    } catch (\Exception $e) {
        Log::error('Payment initiation error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Créer une facture PayDunya
     */
    private function createPaydunyaInvoice($paymentData)
    {
        try {
            $payload = [
                "invoice" => [
                    "items" => [
                        [
                            "name" => "Réservation de voyage Araï Dioni",
                            "quantity" => 1,
                            "unit_price" => $paymentData['amount'],
                            "total_price" => $paymentData['amount'],
                            "description" => "Réservation #" . $paymentData['reservation_id']
                        ]
                    ],
                    "taxes" => [
                        [
                            "name" => "TVA",
                            "amount" => 0
                        ]
                    ],
                    "total_amount" => $paymentData['amount'],
                    "description" => "Paiement de votre réservation de voyage",
                    "currency" => "XOF"
                ],
                "store" => [
                    "name" => "Araï Dioni",
                    "tagline" => "Votre partenaire de transport fiable",
                    "phone_number" => "+221338000000",
                    "postal_address" => "Dakar, Sénégal",
                    "website_url" => url('/'),
                    "logo_url" => url('/images/logo.png')
                ],
                "custom_data" => [
                    "reservation_id" => $paymentData['reservation_id'],
                    "payment_id" => $paymentData['payment_id'],
                    "customer_name" => $paymentData['customer_name']
                ],
                "actions" => [
                    "cancel_url" => url('/payment/cancel?payment_id=' . $paymentData['payment_id']),
                    "return_url" => url('/payment/success?payment_id=' . $paymentData['payment_id']),
                    "callback_url" => url('/payment/webhook')
                ]
            ];

            Log::info('PayDunya Request Payload:', $payload);

            $response = Http::withHeaders([
                'PAYDUNYA-MASTER-KEY' => $this->paydunyaConfig['master_key'],
                'PAYDUNYA-PRIVATE-KEY' => $this->paydunyaConfig['private_key'],
                'PAYDUNYA-TOKEN' => $this->paydunyaConfig['token'],
                'Content-Type' => 'application/json'
            ])->post($this->paydunyaConfig['base_url'] . '/checkout-invoice/create', $payload);

            Log::info('PayDunya Response:', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['response_code'] === '00') {
                    return [
                        'success' => true,
                        'invoice_url' => $data['response_text'], // URL de redirection
                        'token' => $data['token']
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => $data['response_text'] ?? 'Erreur inconnue de PayDunya'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'error' => 'Erreur HTTP: ' . $response->status()
                ];
            }

        } catch (\Exception $e) {
            Log::error('PayDunya API Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

/**
 * Tester la connexion à PayDunya
 */
public function testPaydunyaConnection()
{
    try {
        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->paydunyaConfig['master_key'],
            'PAYDUNYA-PRIVATE-KEY' => $this->paydunyaConfig['private_key'],
            'PAYDUNYA-TOKEN' => $this->paydunyaConfig['token'],
        ])->get($this->paydunyaConfig['base_url'] . '/checkout-invoice');

        return response()->json([
            'success' => $response->successful(),
            'status' => $response->status(),
            'response' => $response->json()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
    /**
     * Callback de succès - VERSION RENFORCÉE
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $paymentId = $request->input('payment_id');
            $testMode = $request->input('test_mode', false);

            Log::info('Payment success callback', $request->all());

            if (!$paymentId) {
                return redirect('/')->with('error', 'ID de paiement manquant');
            }

            // Récupérer le paiement
            $paymentRef = $this->database->getReference('payments/' . $paymentId);
            $paymentSnapshot = $paymentRef->getSnapshot();

            if (!$paymentSnapshot->exists()) {
                return redirect('/')->with('error', 'Paiement non trouvé');
            }

            $paymentData = $paymentSnapshot->getValue();
            $reservationId = $paymentData['reservation_id'];

            // Vérifier que le paiement n'a pas déjà été traité
            if ($paymentData['status'] === 'completed') {
                return redirect("/ticket/{$reservationId}")
                    ->with('warning', 'Ce paiement a déjà été traité.');
            }

            // Mettre à jour le statut du paiement
            $paymentRef->update([
                'status' => 'completed',
                'completed_at' => now()->timestamp,
                'paydunia_status' => 'success',
                'verified_via' => 'callback'
            ]);

            // Mettre à jour la réservation
            $reservationRef = $this->database->getReference('reservations/' . $reservationId);
            $reservationRef->update([
                'payment_status' => 'paid',
                'payment_id' => $paymentId,
                'paid_at' => now()->timestamp
            ]);

            Log::info('Payment completed: ' . $paymentId);

            return redirect("/ticket/{$reservationId}")
                ->with('success', 'Paiement effectué avec succès! Votre réservation est confirmée.');

        } catch (\Exception $e) {
            Log::error('Payment success callback error: ' . $e->getMessage());
            return redirect('/')
                ->with('error', 'Erreur lors du traitement du paiement.');
        }
    }

    /**
     * Callback d'annulation - VERSION RENFORCÉE
     */
    public function paymentCancel(Request $request)
    {
        try {
            $paymentId = $request->input('payment_id');
            $testMode = $request->input('test_mode', false);

            Log::info('Payment cancel callback', $request->all());

            if ($paymentId) {
                // Marquer le paiement comme annulé
                $this->database->getReference('payments/' . $paymentId)->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now()->timestamp,
                    'paydunia_status' => 'cancelled'
                ]);

                // Si c'est un vrai paiement (pas test), libérer la réservation
                if (!$testMode) {
                    $paymentData = $this->database->getReference('payments/' . $paymentId)->getSnapshot()->getValue();
                    if ($paymentData && isset($paymentData['reservation_id'])) {
                        $this->database->getReference('reservations/' . $paymentData['reservation_id'])->update([
                            'payment_status' => 'cancelled'
                        ]);
                    }
                }
            }

            return redirect('/reservations')
                ->with('warning', 'Paiement annulé. Vous pouvez réessayer.');

        } catch (\Exception $e) {
            Log::error('Payment cancel callback error: ' . $e->getMessage());
            return redirect('/reservations')
                ->with('error', 'Erreur lors de l\'annulation.');
        }
    }


    /**
     * Webhook Paydunia (IPN)
     */
    public function paymentWebhook(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('=== PAYDUNIA WEBHOOK RECEIVED ===', $payload);

            $paymentId = $payload['order_id'] ?? $payload['payment_id'] ?? null;
            $status = $payload['status'] ?? null;
            $transactionId = $payload['transaction_id'] ?? null;

            if (!$paymentId || !$status) {
                Log::warning('Invalid webhook payload', $payload);
                return response()->json(['error' => 'Données manquantes'], 400);
            }

            $paymentRef = $this->database->getReference('payments/' . $paymentId);
            $paymentSnapshot = $paymentRef->getSnapshot();

            if (!$paymentSnapshot->exists()) {
                Log::warning('Payment not found in webhook: ' . $paymentId);
                return response()->json(['error' => 'Paiement non trouvé'], 404);
            }

            $paymentData = $paymentSnapshot->getValue();
            $updates = [
                'paydunia_status' => $status,
                'webhook_received_at' => now()->timestamp,
                'paydunia_transaction_id' => $transactionId,
                'verified_via' => 'webhook',
                'updated_at' => now()->timestamp,
                'webhook_payload' => $payload
            ];

            // Mapper les statuts Paydunia vers nos statuts
            $statusMapping = [
                'success' => 'completed',
                'completed' => 'completed',
                'failed' => 'failed',
                'cancelled' => 'cancelled',
                'pending' => 'pending',
                'expired' => 'expired'
            ];

            $updates['status'] = $statusMapping[$status] ?? $status;

            $paymentRef->update($updates);

            // Si le paiement est réussi, mettre à jour la réservation
            if ($status === 'success' || $status === 'completed') {
                $reservationId = $paymentData['reservation_id'] ?? null;
                if ($reservationId) {
                    $this->database->getReference('reservations/' . $reservationId)->update([
                        'payment_status' => 'paid',
                        'payment_id' => $paymentId,
                        'updated_at' => now()->timestamp
                    ]);
                    Log::info('Reservation updated to paid via webhook: ' . $reservationId);
                }
            }

            Log::info("Webhook processed successfully for payment {$paymentId}: {$status}");

            return response()->json([
                'success' => true,
                'message' => 'Webhook processed',
                'payment_id' => $paymentId,
                'status' => $status
            ]);

        } catch (\Exception $e) {
            Log::error('Payment webhook error: ' . $e->getMessage());
            Log::error('Webhook payload: ' . json_encode($request->all()));
            return response()->json(['error' => 'Erreur de traitement'], 500);
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkPaymentStatus($paymentId)
    {
        try {
            Log::info('Checking payment status: ' . $paymentId);

            $paymentRef = $this->database->getReference('payments/' . $paymentId);
            $paymentSnapshot = $paymentRef->getSnapshot();

            if (!$paymentSnapshot->exists()) {
                Log::warning('Payment not found for status check: ' . $paymentId);
                return response()->json([
                    'success' => false,
                    'message' => 'Paiement non trouvé'
                ], 404);
            }

            $paymentData = $paymentSnapshot->getValue();

            // Nettoyer les données sensibles pour la réponse
            unset($paymentData['paydunia_request']);
            unset($paymentData['paydunia_response']);
            unset($paymentData['webhook_payload']);

            Log::info('Payment status retrieved: ' . $paymentId . ' - ' . ($paymentData['status'] ?? 'unknown'));

            return response()->json([
                'success' => true,
                'payment' => $paymentData
            ]);

        } catch (\Exception $e) {
            Log::error('Check payment status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification du statut: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Méthode pour lister tous les paiements (pour admin)
     */
    public function listPayments(Request $request)
    {
        try {
            $paymentsRef = $this->database->getReference('payments');
            $snapshot = $paymentsRef->getSnapshot();

            $payments = [];
            if ($snapshot->exists()) {
                $allPayments = $snapshot->getValue();
                foreach ($allPayments as $paymentId => $payment) {
                    if (is_array($payment)) {
                        $payment['id'] = $paymentId;
                        $payments[] = $payment;
                    }
                }
            }

            // Trier par date de création (plus récent d'abord)
            usort($payments, function($a, $b) {
                return ($b['created_at'] ?? 0) - ($a['created_at'] ?? 0);
            });

            return response()->json([
                'success' => true,
                'payments' => $payments,
                'count' => count($payments)
            ]);

        } catch (\Exception $e) {
            Log::error('List payments error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des paiements'
            ], 500);
        }
    }

    /**
     * Méthode de test pour simuler un webhook Paydunia
     */
    public function simulateWebhook(Request $request)
    {
        if (env('APP_ENV') !== 'local') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        try {
            $paymentId = $request->input('payment_id');
            $status = $request->input('status', 'success');

            $webhookPayload = [
                'order_id' => $paymentId,
                'status' => $status,
                'transaction_id' => 'TEST_TXN_' . Str::random(10),
                'amount' => $request->input('amount', 10000),
                'currency' => $request->input('currency', 'XOF'),
                'timestamp' => now()->timestamp
            ];

            Log::info('Simulating webhook:', $webhookPayload);

            // Appeler le webhook interne
            $response = Http::post(url('/payment/webhook'), $webhookPayload);

            return response()->json([
                'success' => true,
                'message' => 'Webhook simulé',
                'payload' => $webhookPayload,
                'response' => $response->json()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur simulation: ' . $e->getMessage()
            ], 500);
        }
    }
}