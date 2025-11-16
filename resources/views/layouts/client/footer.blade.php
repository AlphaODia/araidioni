<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ari Dioni - Footer Moderne</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        
        // Configuration pour activer/désactiver l'effet Liquid Glass
        const LIQUID_GLASS_ENABLED = true;

        // Gestion de la newsletter
        document.addEventListener('DOMContentLoaded', function() {
            // Newsletter
            const newsletterForm = document.querySelector('.newsletter-input').closest('div');
            if (newsletterForm) {
                const newsletterInput = newsletterForm.querySelector('input[type="email"]');
                const newsletterBtn = newsletterForm.querySelector('button');
                
                newsletterBtn.addEventListener('click', function() {
                    const email = newsletterInput.value.trim();
                    
                    if (!email) {
                        alert('Veuillez entrer votre adresse email');
                        return;
                    }
                    
                    if (!validateEmail(email)) {
                        alert('Veuillez entrer une adresse email valide');
                        return;
                    }
                    
                    // Désactiver le bouton pendant le traitement
                    newsletterBtn.disabled = true;
                    newsletterBtn.textContent = 'Traitement...';
                    
                    // CORRECTION: Utilisation correcte du token CSRF
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    
                    // CORRECTION: Utilisation de la route correcte
                    fetch("{{ route('newsletter.subscribe') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => {
                        if (response.status === 422) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Erreur de validation');
                            });
                        }
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Inscription réussie ! Merci de vous être abonné à notre newsletter.');
                            newsletterInput.value = '';
                        } else {
                            alert(data.message || 'Erreur lors de l\'inscription');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'Erreur de connexion au serveur');
                    })
                    .finally(() => {
                        newsletterBtn.disabled = false;
                        newsletterBtn.textContent = "S'abonner";
                    });
                });
            }
            
            // Demande de devis (avis)
            const quoteBtn = document.querySelector('.quote-btn');
            if (quoteBtn) {
                quoteBtn.addEventListener('click', function() {
                    openAvisModal();
                });
            }
            
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
            
            function openAvisModal() {
                const modalClass = LIQUID_GLASS_ENABLED ? 'liquid-glass-modal' : 'bg-white text-gray-800';
                const inputClass = LIQUID_GLASS_ENABLED ? 'liquid-glass-input' : 'w-full px-3 py-2 border rounded-lg';
                
                const modalHTML = `
                    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                        <div class="${modalClass} p-8 w-full max-w-md relative overflow-hidden rounded-2xl">
                            ${LIQUID_GLASS_ENABLED ? `
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-600/10 z-0"></div>
                            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-white/10 to-transparent pointer-events-none"></div>
                            ` : ''}
                            
                            <div class="relative z-10">
                                <h3 class="text-2xl font-semibold mb-6 text-center ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-800'}">Demander un devis / Donner votre avis</h3>
                                
                                <form id="avisForm" class="space-y-5">
                                    <div>
                                        <label class="block mb-2 font-medium ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-700'}">Nom complet*</label>
                                        <input type="text" name="nom" required 
                                               class="${inputClass} ${LIQUID_GLASS_ENABLED ? '' : 'border-gray-300'}"
                                               placeholder="Votre nom complet">
                                    </div>
                                    
                                    <div>
                                        <label class="block mb-2 font-medium ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-700'}">Email*</label>
                                        <input type="email" name="email" required 
                                               class="${inputClass} ${LIQUID_GLASS_ENABLED ? '' : 'border-gray-300'}"
                                               placeholder="votre@email.com">
                                    </div>
                                    
                                    <div>
                                        <label class="block mb-2 font-medium ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-700'}">Téléphone</label>
                                        <input type="tel" name="telephone" 
                                               class="${inputClass} ${LIQUID_GLASS_ENABLED ? '' : 'border-gray-300'}"
                                               placeholder="+221 XX XXX XX XX">
                                    </div>
                                    
                                    <div>
                                        <label class="block mb-2 font-medium ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-700'}">Type de service*</label>
                                        <select name="service_type" required 
                                                class="${inputClass} ${LIQUID_GLASS_ENABLED ? '' : 'border-gray-300'}">
                                            <option value="">Sélectionnez un service</option>
                                            <option value="voyage">Voyage</option>
                                            <option value="colis">Envoi de colis</option>
                                            <option value="hebergement">Hébergement</option>
                                            <option value="transfert">Transfert d'argent</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block mb-2 font-medium ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-700'}">Message*</label>
                                        <textarea name="message" required rows="4"
                                                  class="${inputClass} ${LIQUID_GLASS_ENABLED ? '' : 'border-gray-300'}"
                                                  placeholder="Décrivez votre demande..."></textarea>
                                    </div>
                                    
                                    <div>
                                        <label class="block mb-2 font-medium ${LIQUID_GLASS_ENABLED ? 'text-white' : 'text-gray-700'}">Note (optionnelle)</label>
                                        <select name="rating" 
                                                class="${inputClass} ${LIQUID_GLASS_ENABLED ? '' : 'border-gray-300'}">
                                            <option value="5">⭐️⭐️⭐️⭐️⭐️ Excellente</option>
                                            <option value="4">⭐️⭐️⭐️⭐️ Très bonne</option>
                                            <option value="3">⭐️⭐️⭐️ Moyenne</option>
                                            <option value="2">⭐️⭐️ Passable</option>
                                            <option value="1">⭐️ Médiocre</option>
                                        </select>
                                    </div>
                                    
                                    <div class="flex justify-end gap-4 pt-4">
                                        <button type="button" onclick="closeModal()" 
                                                class="${LIQUID_GLASS_ENABLED ? 'liquid-glass-btn' : 'px-4 py-2 text-gray-600 border border-gray-300 rounded-lg'}">
                                            Annuler
                                        </button>
                                        <button type="submit" 
                                                class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all">
                                            Envoyer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
                
                const modal = document.createElement('div');
                modal.innerHTML = modalHTML;
                document.body.appendChild(modal);
                
                // Gérer la soumission du formulaire
                modal.querySelector('#avisForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitAvisForm(this);
                });
                
                // Fonction pour fermer le modal
                window.closeModal = function() {
                    document.body.removeChild(modal);
                };
            }
            
function submitAvisForm(form) {
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    // CORRECTION: Utilisation correcte du token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // CORRECTION: Utilisation de la route correcte
    fetch("{{ route('avis.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.status === 422) {
            return response.json().then(data => {
                // AFFICHER LES ERREURS DÉTAILLÉES
                if (data.errors) {
                    const errorMessages = Object.values(data.errors).flat().join('\n');
                    alert('Erreurs de validation:\n' + errorMessages);
                } else {
                    alert(data.message || 'Veuillez corriger les erreurs du formulaire');
                }
                throw new Error('Validation failed');
            });
        }
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.json();
    })
    .then(result => {
        if (result.success) {
            alert('Merci pour votre avis ! Nous vous contacterons rapidement.');
            window.closeModal();
        } else {
            alert(result.message || 'Erreur lors de l\'envoi');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message !== 'Validation failed') {
            alert('Erreur de connexion au serveur');
        }
    });
}
        });
    </script>
    <style>
        /* Effet Glass pour le footer */
        .glass-footer {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -10px 35px rgba(0, 0, 0, 0.1),
                        inset 0 4px 20px rgba(255, 255, 255, 0.05);
        }
        
        /* Effet Liquid Glass pour la modal */
        .liquid-glass-modal {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37),
                        inset 0 4px 20px rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Fallback pour navigateurs non supportés */
        @supports not (backdrop-filter: blur(20px)) {
            .liquid-glass-modal {
                background: rgba(15, 23, 42, 0.95);
            }
        }

        .liquid-glass-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .liquid-glass-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
            outline: none;
        }

        .liquid-glass-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .liquid-glass-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .liquid-glass-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Particules animées améliorées */
        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
            opacity: 0.6;
            z-index: 0;
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0) rotate(0deg) scale(1); 
                opacity: 0.4;
            }
            33% { 
                transform: translateY(-30px) rotate(120deg) scale(1.2); 
                opacity: 0.7;
            }
            66% { 
                transform: translateY(-60px) rotate(240deg) scale(0.8); 
                opacity: 0.5;
            }
        }
        
        /* Icônes sociales avec effet glass */
        .social-icon {
            display: inline-flex;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            color: #ddd;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .social-icon:hover {
            color: white;
            background: rgba(79, 70, 229, 0.7);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }
        
        /* Liens avec effet de soulignement animé */
        .footer-link {
            display: inline-flex;
            align-items: center;
            color: #d1d5db;
            transition: all 0.3s ease;
            padding: 6px 0;
            position: relative;
        }
        
        .footer-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            transition: width 0.3s ease;
        }
        
        .footer-link:hover::before {
            width: 100%;
        }
        
        .footer-link:hover {
            color: #818cf8;
            transform: translateX(5px);
        }
        
        .footer-link:hover i {
            opacity: 1;
            margin-left: 8px;
        }
        
        /* Méthodes de paiement avec effet glass */
        .payment-method {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 10px;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 70px;
        }
        
        .payment-method:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
            border-color: rgba(79, 70, 229, 0.5);
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* Vague animée améliorée */
        .wave-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            overflow: hidden;
            line-height: 0;
            z-index: 1;
        }
        
        .wave-fill {
            fill: rgba(15, 23, 42, 0.95);
        }
        
        /* Section newsletter */
        .newsletter-input {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .newsletter-input:focus {
            outline: none;
            border-color: rgba(79, 70, 229, 0.5);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }
        
        .newsletter-btn {
            background: linear-gradient(to right, rgba(79, 70, 229, 0.7), rgba(124, 58, 237, 0.7));
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .newsletter-btn:hover {
            background: linear-gradient(to right, rgba(79, 70, 229, 0.9), rgba(124, 58, 237, 0.9));
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Section de contact */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            color: #d1d5db;
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            color: #818cf8;
            transform: translateX(5px);
        }
        
        .contact-item i {
            color: #818cf8;
            width: 20px;
            text-align: center;
        }
        
        /* Bouton de devis */
        .quote-btn {
            background: linear-gradient(to right, rgba(79, 70, 229, 0.7), rgba(124, 58, 237, 0.7));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .quote-btn:hover {
            background: linear-gradient(to right, rgba(79, 70, 229, 0.9), rgba(124, 58, 237, 0.9));
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .wave-container {
                height: 60px;
            }
            
            .liquid-glass-modal {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Votre contenu de page ici -->
    
    <footer class="glass-footer relative overflow-hidden">
        <!-- Effet de particules amélioré -->
        <div class="absolute inset-0 overflow-hidden opacity-40">
            <div class="particle" style="top: 10%; left: 5%; width: 8px; height: 8px; background: #4f46e5; animation-delay: 0s; animation-duration: 20s;"></div>
            <div class="particle" style="top: 70%; left: 80%; width: 12px; height: 12px; background: #7c3aed; animation-delay: 3s; animation-duration: 18s;"></div>
            <div class="particle" style="top: 25%; left: 65%; width: 6px; height: 6px; background: #818cf8; animation-delay: 5s; animation-duration: 22s;"></div>
            <div class="particle" style="top: 85%; left: 25%; width: 10px; height: 10px; background: #4f46e5; animation-delay: 2s; animation-duration: 17s;"></div>
            <div class="particle" style="top: 50%; left: 50%; width: 7px; height: 7px; background: #7c3aed; animation-delay: 4s; animation-duration: 25s;"></div>
            <div class="particle" style="top: 35%; left: 15%; width: 9px; height: 9px; background: #818cf8; animation-delay: 1s; animation-duration: 19s;"></div>
        </div>

        <div class="container mx-auto px-4 py-16 relative z-10">
            <!-- Contenu principal en 4 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Colonne Logo + Description -->
                <div>
            <a href="{{ route('home') }}" class="flex items-center bg-white rounded-lg p-2">
                <span class="ml-3 text-xl font-bold" style="
                     background: linear-gradient(90deg, #333333, #666666, #999999);
                     -webkit-background-clip: text;
                     -webkit-text-fill-color: transparent;
                     font-weight: bold;
                     font-size: 1.5rem;
                     ">
                     ARAI DIONI
                </span>
                <img src="{{ asset('images/logo.png') }}" alt="Ari Dioni" class="h-10">
            </a>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Réinventons ensemble votre expérience de voyage et de logistique en Afrique de l'Ouest.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://web.facebook.com/profile.php?id=61581020729640" class="social-icon" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a> 
                        <a href="#" class="social-icon" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://x.com/AraiDioni" class="social-icon" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a> 
                        <a href="https://www.linkedin.com/feed/?trk=onboarding-landing" class="social-icon" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Colonne Liens rapides -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 pb-2 relative inline-block border-b-2 border-indigo-500">Navigation</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="footer-link"><span>Accueil</span><i class="fas fa-chevron-right text-xs ml-2 opacity-0 transition-all"></i></a></li>
                        <li><a href="{{ route('voyages') }}" class="footer-link"><span>Voyages</span><i class="fas fa-chevron-right text-xs ml-2 opacity-0 transition-all"></i></a></li>
                        <li><a href="{{ route('colis.index') }}" class="footer-link"><span>Envoi de colis</span><i class="fas fa-chevron-right text-xs ml-2 opacity-0 transition-all"></i></a></li>
                        <li><a href="{{ route('hebergements') }}" class="footer-link"><span>Hébergements</span><i class="fas fa-chevron-right text-xs ml-2 opacity-0 transition-all"></i></a></li>
                        <li><a href="{{ route('about') }}" class="footer-link"><span>À propos</span><i class="fas fa-chevron-right text-xs ml-2 opacity-0 transition-all"></i></a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link"><span>Contact</span><i class="fas fa-chevron-right text-xs ml-2 opacity-0 transition-all"></i></a></li>
                    </ul>
                </div>

                <!-- Colonne Contact -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 pb-2 relative inline-block border-b-2 border-indigo-500">Nous contacter</h3>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Medina, Dakar, Sénégal</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <a href="tel:+2217784449333">+221 77 844 93 33</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:contact@aridioni.com">contactaridioni@gmail.com</a>
                    </div>

                    <!-- Bouton CTA -->
                    <button class="quote-btn w-full mt-6 text-white font-medium py-3 px-4 rounded-lg">
                        Demander un devis / Avis
                    </button>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-6 pb-2 relative inline-block border-b-2 border-indigo-500">Newsletter</h3>
                    <div class="mb-4">
                        <input type="email" placeholder="Votre email" class="newsletter-input w-full px-4 py-3 rounded-lg mb-3">
                        <button class="newsletter-btn w-full text-white font-medium py-3 px-4 rounded-lg">S'abonner</button>
                    </div>
                    <p class="text-gray-500 text-sm">
                        Nous ne partagerons jamais votre email.
                    </p>
                </div>
            </div>

            <!-- Section moyens de paiement -->
            <div class="py-8 border-t border-gray-800">
                <h3 class="text-lg font-semibold text-center mb-8 text-white">Moyens de paiement acceptés</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="payment-method">
                        <img src="{{ asset('images/payments/orange-money.png') }}" alt="Orange Money" class="h-8" loading="lazy">
                    </div>
                    <div class="payment-method">
                        <img src="{{ asset('images/payments/momo.png') }}" alt="MTN Mobile Money" class="h-8" loading="lazy">
                    </div>
                    <div class="payment-method">
                        <img src="{{ asset('images/payments/visa.png') }}" alt="Visa" class="h-8" loading="lazy">
                    </div>
                    <div class="payment-method">
                        <img src="{{ asset('images/payments/mastercard.png') }}" alt="Mastercard" class="h-8" loading="lazy">
                    </div>
                    <div class="payment-method">
                        <img src="{{ asset('images/payments/cash.png') }}" alt="Espèces" class="h-8" loading="lazy">
                    </div>
                    <div class="payment-method">
                        <img src="{{ asset('images/payments/paypal.png') }}" alt="PayPal" class="h-8" loading="lazy">
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center pt-8 border-t border-gray-800">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Ari Dioni. Tous droits réservés.
                </p>
            </div>
        </div>

        <!-- Effet de vague amélioré -->
        <div class="wave-container">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="wave-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="wave-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="wave-fill"></path>
            </svg>
        </div>
    </footer>
</body>
</html>