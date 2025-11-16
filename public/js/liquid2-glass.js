// Liquid Glass Effect Toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('glassToggleHeader');
    const body = document.getElementById('main-body');
    const mainContent = document.getElementById('main-content');
    
    // Vérifier si l'effet est désactivé sur cette page
    const isLiquidGlassDisabled = body.classList.contains('no-liquid-glass');
    
    if (isLiquidGlassDisabled) {
        return; // Ne pas initialiser l'effet sur cette page
    }
    
    let liquidGlassEnabled = localStorage.getItem('liquidGlassEnabled') === 'true';
    
    // Appliquer l'état initial
    applyLiquidGlassEffect(liquidGlassEnabled);
    
    // Gérer le clic sur le bouton toggle
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            liquidGlassEnabled = !liquidGlassEnabled;
            applyLiquidGlassEffect(liquidGlassEnabled);
            localStorage.setItem('liquidGlassEnabled', liquidGlassEnabled.toString());
        });
    }
    
    function applyLiquidGlassEffect(enabled) {
        if (enabled) {
            body.classList.add('liquid-glass-enabled');
            body.classList.remove('bg-gray-50');
            
            // Appliquer l'effet aux conteneurs principaux
            const containers = document.querySelectorAll('.bg-white, .bg-gray-50, .min-h-screen');
            containers.forEach(container => {
                container.classList.add('liquid-glass-container');
            });
            
            // Mettre à jour l'icône du bouton
            const icon = toggleButton.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-times';
            }
        } else {
            body.classList.remove('liquid-glass-enabled');
            body.classList.add('bg-gray-50');
            
            // Retirer l'effet des conteneurs
            const containers = document.querySelectorAll('.liquid-glass-container');
            containers.forEach(container => {
                container.classList.remove('liquid-glass-container');
            });
            
            // Mettre à jour l'icône du bouton
            const icon = toggleButton.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-glass-whiskey';
            }
        }
    }
});