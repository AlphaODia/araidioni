<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <h5>Arai Dioni</h5>
                <p>Votre plateforme complète pour les voyages, transferts d'argent, envoi de colis et hébergements.</p>
            </div>
            <div class="col-md-2">
                <h5>Liens rapides</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-white">Accueil</a></li>
                    <li><a href="{{ route('about') }}" class="text-white">À propos</a></li>
                    <li><a href="{{ route('contact') }}" class="text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Services</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('voyages') }}" class="text-white">Voyages</a></li>
                    <li><a href="{{ route('transferts') }}" class="text-white">Transferts d'argent</a></li>
                    <li><a href="{{ route('colis') }}" class="text-white">Envoi de colis</a></li>
                    <li><a href="{{ route('hebergements') }}" class="text-white">Hébergements</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Contact</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-phone me-2"></i> +225 20 30 40 50</li>
                    <li><i class="fas fa-envelope me-2"></i> contact@arai-dioni.ci</li>
                    <li><i class="fas fa-map-marker-alt me-2"></i> Abidjan, Côte d'Ivoire</li>
                </ul>
                <div class="d-flex mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} Arai Dioni. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white me-3">Politique de confidentialité</a>
                <a href="#" class="text-white">Conditions d'utilisation</a>
            </div>
        </div>
    </div>
</footer>