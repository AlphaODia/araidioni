// payment.js - Gestion des callbacks Paydunia

class PaymentManager {
    constructor() {
        this.init();
    }

    init() {
        this.handlePaymentCallback();
        this.checkPendingPayments();
    }

    /**
     * Gérer les callbacks de paiement
     */
    handlePaymentCallback() {
        const urlParams = new URLSearchParams(window.location.search);
        const paymentId = urlParams.get('payment_id');
        const status = urlParams.get('status');

        if (paymentId) {
            if (status === 'success' || window.location.pathname.includes('/payment/success')) {
                this.showSuccessMessage(paymentId);
            } else if (status === 'cancel' || window.location.pathname.includes('/payment/cancel')) {
                this.showCancelMessage(paymentId);
            }
        }
    }

    /**
     * Afficher le message de succès
     */
    async showSuccessMessage(paymentId) {
        try {
            const payment = await this.checkPaymentStatus(paymentId);
            
            if (payment && payment.status === 'completed') {
                this.displaySuccessAlert(`
                    ✅ Paiement réussi !
                    Votre réservation a été confirmée.
                    ${payment.reservation_id ? `ID Réservation: ${payment.reservation_id}` : ''}
                `);

                // Rediriger vers le ticket après 3 secondes
                setTimeout(() => {
                    if (payment.reservation_id) {
                        window.location.href = `/ticket/${payment.reservation_id}`;
                    } else {
                        window.location.href = '/mes-reservations';
                    }
                }, 3000);
            } else {
                this.displayWarningAlert('Paiement en cours de traitement...');
            }
        } catch (error) {
            console.error('Erreur vérification paiement:', error);
            this.displayInfoAlert('Paiement en cours de validation...');
        }
    }

    /**
     * Afficher le message d'annulation
     */
    showCancelMessage(paymentId) {
        this.displayWarningAlert(`
            ❌ Paiement annulé
            Vous pouvez réessayer ultérieurement.
            ${paymentId ? `ID Paiement: ${paymentId}` : ''}
        `);

        // Rediriger vers les réservations après 3 secondes
        setTimeout(() => {
            window.location.href = '/reservations';
        }, 3000);
    }

    /**
     * Vérifier le statut d'un paiement
     */
    async checkPaymentStatus(paymentId) {
        const response = await fetch(`/payment/status/${paymentId}`);
        const result = await response.json();
        return result.success ? result.payment : null;
    }

    /**
     * Vérifier les paiements en attente au chargement
     */
    checkPendingPayments() {
        const pendingPaymentId = localStorage.getItem('pending_payment_id');
        if (pendingPaymentId) {
            this.monitorPaymentStatus(pendingPaymentId);
        }
    }

    /**
     * Surveiller le statut d'un paiement
     */
    async monitorPaymentStatus(paymentId) {
        try {
            const payment = await this.checkPaymentStatus(paymentId);
            
            if (payment && payment.status === 'completed') {
                localStorage.removeItem('pending_payment_id');
                this.showSuccessMessage(paymentId);
            } else if (payment && payment.status === 'failed') {
                localStorage.removeItem('pending_payment_id');
                this.displayErrorAlert('Le paiement a échoué. Veuillez réessayer.');
            }
        } catch (error) {
            console.error('Erreur monitoring paiement:', error);
        }
    }

    // Méthodes d'affichage des alertes
    displaySuccessAlert(message) {
        this.showAlert(message, 'success');
    }

    displayWarningAlert(message) {
        this.showAlert(message, 'warning');
    }

    displayErrorAlert(message) {
        this.showAlert(message, 'error');
    }

    displayInfoAlert(message) {
        this.showAlert(message, 'info');
    }

    showAlert(message, type = 'info') {
        // Utilise ton système d'alertes existant ou crée une alerte simple
        alert(message);
        
        // Pour une meilleure UX, tu peux utiliser Toast ou SweetAlert
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: message,
                timer: 5000,
                showConfirmButton: true
            });
        }
    }
}

// Initialiser le gestionnaire de paiement
document.addEventListener('DOMContentLoaded', function() {
    window.paymentManager = new PaymentManager();
});