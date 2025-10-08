<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Réservation Hébergement - {{ $ticketData['reservation_id'] }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #e6f7ff 0%, #d1eeff 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            color: #333;
        }
        
        .ticket-card {
            max-width: 700px;
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(74, 144, 226, 0.2);
        }
        
        .ticket-header {
            background: linear-gradient(90deg, #4a90e2 0%, #63b3ed 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .logo-text {
            background: linear-gradient(90deg, #333333, #666666, #999999);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            font-size: 1.3rem;
        }
        
        .logo-img {
            height: 35px;
        }
        
        .reference-number {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 13px;
        }
        
        .ticket-body {
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 15px;
        }
        
        .ticket-title {
            text-align: center;
            margin-bottom: 15px;
            color: #4a90e2;
            font-size: 18px;
            font-weight: 700;
            grid-column: 1 / -1;
        }
        
        .info-sections {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .info-section {
            padding: 12px;
            border-radius: 8px;
            background: #f8fbff;
            box-shadow: 0 2px 8px rgba(74, 144, 226, 0.1);
        }
        
        .info-title {
            font-size: 14px;
            color: #4a90e2;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e6f7ff;
            padding-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .info-title i {
            margin-right: 8px;
            color: #63b3ed;
            font-size: 14px;
        }
        
        .info-detail {
            margin-bottom: 8px;
            display: flex;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4a90e2;
            min-width: 120px;
            font-size: 13px;
        }
        
        .detail-value {
            color: #495057;
            font-weight: 500;
            font-size: 13px;
        }
        
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px;
            background: #f8fbff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(74, 144, 226, 0.1);
            height: fit-content;
        }
        
        #qrcode {
            margin: 8px 0;
            padding: 8px;
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .qr-title {
            font-size: 14px;
            color: #4a90e2;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: center;
        }
        
        .qr-note {
            font-size: 11px;
            color: #6c757d;
            margin-top: 6px;
            max-width: 150px;
            text-align: center;
        }
        
        .ticket-footer {
            background: #f8fbff;
            padding: 15px;
            text-align: center;
            border-top: 1px dashed #d1eeff;
        }
        
        .scan-instruction {
            background: #fff3cd;
            color: #856404;
            padding: 8px 12px;
            border-radius: 6px;
            margin: 8px 0;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }
        
        .print-btn {
            background: linear-gradient(90deg, #4a90e2 0%, #63b3ed 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 3px 8px rgba(74, 144, 226, 0.2);
            margin-top: 8px;
        }
        
        .print-btn i {
            margin-right: 6px;
        }
        
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(74, 144, 226, 0.3);
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 6px;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .price-tag {
            background: linear-gradient(90deg, #4a90e2 0%, #63b3ed 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            display: inline-block;
        }
        
        /* Styles d'impression optimisés */
        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
            }
            
            .ticket-card {
                box-shadow: none;
                max-width: 100%;
                margin: 0;
                border-radius: 0;
            }
            
            .print-btn {
                display: none;
            }
            
            .ticket-header {
                padding: 10px 15px;
            }
            
            .ticket-body {
                padding: 15px;
            }
            
            .ticket-footer {
                padding: 10px;
            }
            
            /* Réduire encore les marges pour l'impression */
            * {
                margin: 0;
                padding: 0;
            }
            
            .info-section {
                padding: 8px;
                margin-bottom: 5px;
            }
            
            .info-detail {
                margin-bottom: 5px;
            }
        }
        
        @media (max-width: 768px) {
            .ticket-body {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .ticket-header {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }
            
            .logo-container {
                margin-bottom: 8px;
            }
            
            .qr-section {
                order: -1;
            }
        }
    </style>
</head>
<body>
    <div class="ticket-card">
        <div class="ticket-header">
            <div class="logo-container">
                <span class="logo-text">ARAI DIONI</span>
                <img src="{{ asset('images/logo.png') }}" alt="Arai Dioni" class="logo-img">
            </div>
            <div class="reference-number">Réf: {{ $ticketData['reservation_id'] }}</div>
        </div>
        
        <div class="ticket-body">
            <h2 class="ticket-title">
                <i class="fas fa-bed"></i> TICKET DE RÉSERVATION HÉBERGEMENT
            </h2>
            
            <div class="info-sections">
                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-user"></i> Informations Personnelles</h3>
                    <div class="info-detail">
                        <span class="detail-label">Nom:</span>
                        <span class="detail-value">{{ $ticketData['client_nom'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $ticketData['client_email'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Téléphone:</span>
                        <span class="detail-value">{{ $ticketData['client_telephone'] }}</span>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-hotel"></i> Hébergement</h3>
                    <div class="info-detail">
                        <span class="detail-label">Nom:</span>
                        <span class="detail-value">{{ $ticketData['hebergement_nom'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Localisation:</span>
                        <span class="detail-value">{{ $ticketData['hebergement_localisation'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Ville:</span>
                        <span class="detail-value">{{ $ticketData['ville'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Pays:</span>
                        <span class="detail-value">{{ $ticketData['pays'] }}</span>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-calendar-alt"></i> Dates de séjour</h3>
                    <div class="info-detail">
                        <span class="detail-label">Arrivée:</span>
                        <span class="detail-value">{{ $ticketData['date_arrivee'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Départ:</span>
                        <span class="detail-value">{{ $ticketData['date_depart'] }}</span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Nuits:</span>
                        <span class="detail-value">{{ $ticketData['nuits'] }} nuit(s)</span>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3 class="info-title"><i class="fas fa-receipt"></i> Paiement</h3>
                    <div class="info-detail">
                        <span class="detail-label">Prix total:</span>
                        <span class="detail-value">
                            <span class="price-tag">{{ number_format($ticketData['prix_total'], 0, ',', ' ') }} CFA</span>
                        </span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Statut:</span>
                        <span class="detail-value">
                            {{ ucfirst($ticketData['statut']) }}
                            <span class="status-badge {{ $ticketData['statut'] === 'confirme' ? 'status-confirmed' : 'status-pending' }}">
                                {{ $ticketData['statut'] === 'confirme' ? 'CONFIRMÉ' : 'EN ATTENTE' }}
                            </span>
                        </span>
                    </div>
                    <div class="info-detail">
                        <span class="detail-label">Réservé le:</span>
                        <span class="detail-value">{{ $ticketData['date_reservation'] }}</span>
                    </div>
                </div>
            </div>
            
            <div class="qr-section">
                <div class="qr-title"><i class="fas fa-qrcode"></i> CODE QR</div>
                <div id="qrcode"></div>
                <p class="qr-note">Scanner pour vérifier la réservation</p>
            </div>
        </div>
        
        <div class="ticket-footer">
            <div class="scan-instruction">
                <i class="fas fa-info-circle"></i>
                Présentez ce code QR à votre arrivée
            </div>
            <br>
            <button class="print-btn" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer le ticket
            </button>
        </div>
    </div>

    <script>
        // Générer le QR code avec les données du ticket
        document.addEventListener("DOMContentLoaded", function() {
            // Données à encoder dans le QR code
            const qrData = JSON.stringify({
                reservationId: "{{ $ticketData['reservation_id'] }}",
                client: "{{ $ticketData['client_nom'] }}",
                email: "{{ $ticketData['client_email'] }}",
                hebergement: "{{ $ticketData['hebergement_nom'] }}",
                localisation: "{{ $ticketData['hebergement_localisation'] }}",
                arrivee: "{{ $ticketData['date_arrivee'] }}",
                depart: "{{ $ticketData['date_depart'] }}",
                nuits: "{{ $ticketData['nuits'] }}",
                prixTotal: "{{ number_format($ticketData['prix_total'], 0, ',', ' ') }} CFA",
                status: "{{ $ticketData['statut'] }}"
            });
            
            // Créer le QR code
            const qrcode = new QRCode(document.getElementById("qrcode"), {
                text: qrData,
                width: 120,
                height: 120,
                colorDark: "#4a90e2",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>
</body>
</html>