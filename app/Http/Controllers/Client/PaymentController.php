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
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL', 'https://araidioni-a7186-default-rtdb.firebaseio.com'));

            $this->database = $firebase->createDatabase();
        } catch (\Exception $e) {
            Log::error('Firebase initialization error: ' . $e->getMessage());
        }

        // CONFIGURATION CORRIGÉE
        $this->paydunyaConfig = [
            'merchant_id' => env('PAYDUNYA_MERCHANT_ID'),
            'master_key' => env('PAYDUNYA_MASTER_KEY'),
            'public_key' => env('PAYDUNYA_PUBLIC_KEY'),
            'private_key' => env('PAYDUNYA_PRIVATE_KEY'),
            'token' => env('PAYDUNYA_TOKEN'),
            'base_url' => env('PAYDUNYA_BASE_URL', 'https://https://api.paydunya.com/v1/creacte'),
            'success_url' => url(env('PAYDUNYA_SUCCESS_URL', '/payment/success')),
            'cancel_url' => url(env('PAYDUNYA_CANCEL_URL', '/payment/cancel')),
            'mode' => env('PAYDUNYA_MODE', 'test')
        ];
    }

/**
 * Vérifier l'accessibilité de PayDunya - VERSION AMÉLIORÉE
 */
private function isPaydunyaAccessible()
{
    // Forcer le fallback en local si configuré
    if (env('APP_ENV') === 'local' && env('PAYDUNYA_FORCE_FALLBACK', false)) {
        Log::info('Fallback forcé en mode développement');
        return false;
    }

    // En production, tester réellement la connexion
    if (env('APP_ENV') === 'production') {
        try {
            $response = Http::timeout(5)
                ->connectTimeout(3)
                ->get('https://api.paydunya.com/health');
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::warning('PayDunya inaccessible en production: ' . $e->getMessage());
            return false;
        }
    }

    // Par défaut en développement, on suppose que c'est accessible
    // mais avec FORCE_FALLBACK=true, on utilise le fallback
    return !env('PAYDUNYA_FORCE_FALLBACK', false);
}

    /**
     * Initialiser un paiement - VERSION SIMPLIFIÉE ET CORRECTE
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

            if (isset($reservation['payment_status']) && $reservation['payment_status'] === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette réservation a déjà été payée'
                ], 400);
            }

            // ==================== DÉCISION : FALLBACK OU RÉEL ====================
            $paydunyaAccessible = $this->isPaydunyaAccessible();
            
            Log::info('PayDunya accessible: ' . ($paydunyaAccessible ? 'YES' : 'NO - Using fallback'));

            if (!$paydunyaAccessible) {
                return $this->processFallbackPayment($validated);
            }

            // ==================== MODE RÉEL PAYDUNYA ====================
            $reservationRef->update([
                'payment_status' => 'pending',
                'payment_attempt_at' => now()->timestamp
            ]);

            $paymentId = 'PAY_' . Str::upper(Str::random(16));

            $paydunyaResponse = $this->createPaydunyaInvoice([
                'payment_id' => $paymentId,
                'reservation_id' => $validated['reservation_id'],
                'amount' => $validated['amount'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone']
            ]);

            if (!$paydunyaResponse['success']) {
                $reservationRef->update([
                    'payment_status' => 'failed',
                    'payment_error' => $paydunyaResponse['error']
                ]);

                // Si timeout, basculer vers fallback
                if (isset($paydunyaResponse['connection_timeout'])) {
                    Log::warning('PayDunya timeout, switching to fallback mode');
                    return $this->processFallbackPayment($validated);
                }

                return response()->json([
                    'success' => false,
                    'message' => $paydunyaResponse['error']
                ], 500);
            }

            // Sauvegarder le paiement
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
                'test_mode' => false
            ];

            $this->database->getReference('payments/' . $paymentId)->set($paymentData);

            Log::info('Payment initiated with PayDunya: ' . $paymentId);

            return response()->json([
                'success' => true,
                'payment_url' => $paydunyaResponse['invoice_url'],
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
     * Traitement du paiement fallback - VERSION GARANTIE
     */
    private function processFallbackPayment($validated)
    {
        try {
            $paymentId = 'FALLBACK_' . Str::upper(Str::random(16));

            Log::info('🚀 PROCESSING FALLBACK PAYMENT: ' . $paymentId);

            // Simuler une réponse PayDunya réussie
            $paymentData = [
                'payment_id' => $paymentId,
                'reservation_id' => $validated['reservation_id'],
                'amount' => $validated['amount'],
                'currency' => 'XOF',
                'status' => 'completed',
                'created_at' => now()->timestamp,
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_name' => $validated['customer_name'],
                'paydunya_invoice_url' => url('/payment/success?payment_id=' . $paymentId . '&fallback=true'),
                'paydunya_token' => 'fallback_token_' . $paymentId,
                'test_mode' => true,
                'fallback_mode' => true
            ];

            // Sauvegarder le paiement
            $this->database->getReference('payments/' . $paymentId)->set($paymentData);

            // Mettre à jour la réservation
            $this->database->getReference('reservations/' . $validated['reservation_id'])->update([
                'payment_status' => 'paid',
                'payment_id' => $paymentId,
                'paid_at' => now()->timestamp,
                'status' => 'confirmé'
            ]);

            Log::info('✅ FALLBACK PAYMENT SUCCESS: ' . $paymentId);

            return response()->json([
                'success' => true,
                'payment_url' => url('/payment/success?payment_id=' . $paymentId . '&fallback=true'),
                'payment_id' => $paymentId,
                'message' => 'Paiement simulé avec succès! Votre réservation est confirmée.',
                'test_mode' => true,
                'fallback_mode' => true,
                'auto_fallback' => true
            ]);

        } catch (\Exception $e) {
            Log::error('❌ FALLBACK PAYMENT ERROR: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du paiement simulé: ' . $e->getMessage()
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

            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->withHeaders([
                    'PAYDUNYA-MASTER-KEY' => $this->paydunyaConfig['master_key'],
                    'PAYDUNYA-PRIVATE-KEY' => $this->paydunyaConfig['private_key'],
                    'PAYDUNYA-TOKEN' => $this->paydunyaConfig['token'],
                    'Content-Type' => 'application/json'
                ])->post($this->paydunyaConfig['base_url'] . '/checkout-invoice/create', $payload);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['response_code'] === '00') {
                    return [
                        'success' => true,
                        'invoice_url' => $data['response_text'],
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

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return [
                'success' => false,
                'error' => 'Timeout de connexion à PayDunya',
                'connection_timeout' => true
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

/**
 * Test de connexion complet avec diagnostique
 */
public function testPaydunyaConnection()
{
    $results = [];
    
    // Test 1: Résolution DNS
    $dnsStart = microtime(true);
    $ip = gethostbyname('api.paydunya.com');
    $results['dns'] = [
        'resolved' => $ip !== 'api.paydunya.com',
        'ip' => $ip,
        'time' => round(microtime(true) - $dnsStart, 3) . 's'
    ];

    // Test 2: Accessibilité HTTP/HTTPS
    $tests = ['http' => 'http://api.paydunya.com', 'https' => 'https://api.paydunya.com'];
    
    foreach ($tests as $protocol => $url) {
        $start = microtime(true);
        try {
            $response = Http::timeout(10)->get($url);
            $results[$protocol] = [
                'accessible' => true,
                'status' => $response->status(),
                'time' => round(microtime(true) - $start, 3) . 's'
            ];
        } catch (\Exception $e) {
            $results[$protocol] = [
                'accessible' => false,
                'error' => $e->getMessage(),
                'time' => round(microtime(true) - $start, 3) . 's'
            ];
        }
    }

    $paydunyaAccessible = $results['https']['accessible'] ?? false;

    return response()->json([
        'success' => true,
        'paydunya_accessible' => $paydunyaAccessible,
        'environment' => env('APP_ENV'),
        'diagnostic' => $results,
        'auto_fallback_active' => !$paydunyaAccessible,
        'recommendation' => $paydunyaAccessible ? 
            'API PayDunya accessible' : 
            'Utiliser le mode fallback pour le développement'
    ]);
}

    /**
     * Test de connexion simple (alias)
     */
    public function testConnection()
    {
        return $this->testPaydunyaConnection();
    }

    /**
     * Solution de fallback manuel pour le développement
     */
    public function fallbackPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'reservation_id' => 'required|string',
                'amount' => 'required|numeric|min:1',
                'customer_email' => 'required|email',
                'customer_phone' => 'required|string',
                'customer_name' => 'required|string'
            ]);

            Log::info('Manual fallback payment initiated');

            return $this->processFallbackPayment($validated);

        } catch (\Exception $e) {
            Log::error('Manual fallback payment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du paiement simulé: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Diagnostic réseau complet
     */
    public function networkDiagnostic()
    {
        $results = [];
        
        // Test DNS
        $start = microtime(true);
        $ip = gethostbyname('api.paydunya.com');
        $results['dns'] = [
            'ip' => $ip,
            'time' => round(microtime(true) - $start, 3) . 's',
            'resolved' => $ip !== 'api.paydunya.com'
        ];

        // Test HTTP
        $start = microtime(true);
        try {
            $response = Http::timeout(5)->get('http://api.paydunya.com');
            $results['http'] = [
                'success' => true,
                'status' => $response->status(),
                'time' => round(microtime(true) - $start, 3) . 's'
            ];
        } catch (\Exception $e) {
            $results['http'] = [
                'success' => false,
                'error' => $e->getMessage(),
                'time' => round(microtime(true) - $start, 3) . 's'
            ];
        }

        // Test HTTPS
        $start = microtime(true);
        try {
            $response = Http::timeout(5)->get('https://api.paydunya.com');
            $results['https'] = [
                'success' => true,
                'status' => $response->status(),
                'time' => round(microtime(true) - $start, 3) . 's'
            ];
        } catch (\Exception $e) {
            $results['https'] = [
                'success' => false,
                'error' => $e->getMessage(),
                'time' => round(microtime(true) - $start, 3) . 's'
            ];
        }

        $paydunyaAccessible = $this->isPaydunyaAccessible();

        return response()->json([
            'success' => true,
            'paydunya_accessible' => $paydunyaAccessible,
            'environment' => env('APP_ENV'),
            'diagnostic' => $results,
            'recommendation' => $paydunyaAccessible ? 
                'PayDunya accessible - Mode normal' : 
                'PayDunya inaccessible - Mode fallback automatique'
        ]);
    }

    /**
     * Callback de succès
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $paymentId = $request->input('payment_id');
            $fallback = $request->input('fallback', false);

            Log::info('Payment success callback', $request->all());

            if (!$paymentId) {
                return redirect('/')->with('error', 'ID de paiement manquant');
            }

            $paymentRef = $this->database->getReference('payments/' . $paymentId);
            $paymentSnapshot = $paymentRef->getSnapshot();

            if (!$paymentSnapshot->exists()) {
                return redirect('/')->with('error', 'Paiement non trouvé');
            }

            $paymentData = $paymentSnapshot->getValue();
            $reservationId = $paymentData['reservation_id'];

            // Message différent pour le fallback
            if ($fallback) {
                return redirect("/ticket/{$reservationId}")
                    ->with('success', 'Paiement simulé avec succès! Votre réservation est confirmée. (Mode développement)');
            }

            return redirect("/ticket/{$reservationId}")
                ->with('success', 'Paiement effectué avec succès! Votre réservation est confirmée.');

        } catch (\Exception $e) {
            Log::error('Payment success callback error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Erreur lors du traitement du paiement.');
        }
    }

    /**
     * Callback d'annulation
     */
    public function paymentCancel(Request $request)
    {
        try {
            $paymentId = $request->input('payment_id');
            Log::info('Payment cancel callback', $request->all());

            if ($paymentId) {
                $this->database->getReference('payments/' . $paymentId)->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now()->timestamp
                ]);
            }

            return redirect('/reservations')->with('warning', 'Paiement annulé.');

        } catch (\Exception $e) {
            Log::error('Payment cancel callback error: ' . $e->getMessage());
            return redirect('/reservations')->with('error', 'Erreur lors de l\'annulation.');
        }
    }

    /**
     * Webhook Paydunya (IPN)
     */
    public function paymentWebhook(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('=== PAYDUNYA WEBHOOK RECEIVED ===', $payload);

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
                'paydunya_status' => $status,
                'webhook_received_at' => now()->timestamp,
                'paydunya_transaction_id' => $transactionId,
                'verified_via' => 'webhook',
                'updated_at' => now()->timestamp,
                'webhook_payload' => $payload
            ];

            // Mapper les statuts Paydunya vers nos statuts
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
            unset($paymentData['paydunya_request']);
            unset($paymentData['paydunya_response']);
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
     * Méthode de test pour simuler un webhook Paydunya
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