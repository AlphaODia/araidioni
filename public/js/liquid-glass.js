// Configuration et état global pour Liquid Glass - Version corrigée
const LIQUID_GLASS_CONFIG = {
    enabledKey: 'liquidGlassEnabled',
    defaultEnabled: true
};

// État de l'application
const LIQUID_GLASS_STATE = {
    enabled: LIQUID_GLASS_CONFIG.defaultEnabled
};

// Initialisation de l'effet Liquid Glass
document.addEventListener('DOMContentLoaded', function() {
    initializeLiquidGlass();
    initializeGlassToggle();
});

// Initialiser l'effet Liquid Glass
function initializeLiquidGlass() {
    const body = document.getElementById('main-body');
    
    // Vérifier si l'effet est désactivé sur cette page
    const isLiquidGlassDisabled = body && body.classList.contains('no-liquid-glass');
    
    if (isLiquidGlassDisabled) {
        console.log('Liquid Glass désactivé sur cette page');
        return;
    }
    
    // Vérifier la préférence sauvegardée
    const savedPreference = localStorage.getItem(LIQUID_GLASS_CONFIG.enabledKey);
    
    if (savedPreference !== null) {
        LIQUID_GLASS_STATE.enabled = savedPreference === 'true';
    } else {
        // Sauvegarder la préférence par défaut
        localStorage.setItem(LIQUID_GLASS_CONFIG.enabledKey, LIQUID_GLASS_STATE.enabled.toString());
    }
    
    applyLiquidGlassEffect(LIQUID_GLASS_STATE.enabled);
}

// Initialiser le bouton de toggle
function initializeGlassToggle() {
    const glassToggle = document.getElementById('glassToggleHeader');
    const body = document.getElementById('main-body');
    
    // Vérifier si l'effet est désactivé sur cette page
    const isLiquidGlassDisabled = body && body.classList.contains('no-liquid-glass');
    
    if (isLiquidGlassDisabled) {
        console.log('Bouton Liquid Glass désactivé sur cette page');
        if (glassToggle) {
            glassToggle.style.display = 'none';
        }
        return;
    }
    
    if (glassToggle) {
        glassToggle.addEventListener('click', toggleLiquidGlass);
        updateToggleButton();
    }
}

// Basculer l'effet Liquid Glass
function toggleLiquidGlass() {
    LIQUID_GLASS_STATE.enabled = !LIQUID_GLASS_STATE.enabled;
    
    // Sauvegarder la préférence
    localStorage.setItem(LIQUID_GLASS_CONFIG.enabledKey, LIQUID_GLASS_STATE.enabled.toString());
    
    applyLiquidGlassEffect(LIQUID_GLASS_STATE.enabled);
    updateToggleButton();
}

// Appliquer l'effet Liquid Glass - VERSION CORRIGÉE
function applyLiquidGlassEffect(enabled) {
    const body = document.getElementById('main-body') || document.body;
    
    if (enabled) {
        // Activer l'effet Liquid Glass
        body.classList.add('liquid-glass-enabled');
        body.classList.remove('no-glass-effect', 'bg-gray-50');
        
        // Appliquer l'effet aux conteneurs principaux
        const containers = document.querySelectorAll('.bg-white, .bg-gray-50, .min-h-screen, .liquid-glass');
        containers.forEach(container => {
            if (!container.classList.contains('liquid-glass-container')) {
                container.classList.add('liquid-glass-container');
            }
        });
        
        // FORCER la mise à jour des couleurs de texte
        setTimeout(forceTextColorUpdate, 100);
        
    } else {
        // Désactiver l'effet Liquid Glass
        body.classList.remove('liquid-glass-enabled');
        body.classList.add('no-glass-effect');
        
        // Rétablir les styles par défaut
        const glassElements = document.querySelectorAll('.liquid-glass, .liquid-glass-container');
        glassElements.forEach(element => {
            element.classList.remove('liquid-glass', 'liquid-glass-container');
        });
        
        // Restaurer les couleurs de texte originales
        restoreOriginalTextColors();
    }
    
    // Mettre à jour les styles spécifiques pour les deux pages
    updateHomePageStyles(enabled);
    updateColisPageStyles(enabled);
}

// FORCER la mise à jour des couleurs de texte
function forceTextColorUpdate() {
    const textElements = document.querySelectorAll(`
        .text-gray-800, .text-slate-800,
        .text-gray-700, .text-slate-700, 
        .text-gray-600, .text-slate-600,
        .feature-title, .feature-description,
        .testimonial-name, .testimonial-text,
        .section-title, .hero-title, .hero-subtitle,
        .trip-route, .trip-info, .trip-meta-item,
        .price-from, .price-amount,
        .form-label
    `);
    
    textElements.forEach(element => {
        element.style.color = 'white !important';
        element.style.textShadow = '0 2px 4px rgba(0, 0, 0, 0.3) !important';
    });
}

// Restaurer les couleurs de texte originales
function restoreOriginalTextColors() {
    const textElements = document.querySelectorAll(`
        .text-gray-800, .text-slate-800,
        .text-gray-700, .text-slate-700, 
        .text-gray-600, .text-slate-600
    `);
    
    textElements.forEach(element => {
        element.style.color = '';
        element.style.textShadow = '';
    });
}

// Mettre à jour les styles spécifiques pour la page d'accueil
function updateHomePageStyles(enabled) {
    const homePage = document.querySelector('.hero');
    
    if (homePage) {
        if (enabled) {
            // Styles pour home avec effet glass
            homePage.classList.add('liquid-glass-enabled');
            
            // S'assurer que les textes sont visibles
            const homeTexts = homePage.querySelectorAll(`
                .hero-title, .hero-subtitle, .section-title,
                .feature-title, .feature-description,
                .testimonial-name, .testimonial-text
            `);
            
            homeTexts.forEach(text => {
                text.classList.add('text-white');
                text.classList.remove('text-gray-800', 'text-slate-800');
            });
            
        } else {
            // Styles pour home sans effet glass
            homePage.classList.remove('liquid-glass-enabled');
            
            // Restaurer les couleurs originales
            const homeTexts = homePage.querySelectorAll(`
                .hero-title, .hero-subtitle, .section-title,
                .feature-title, .feature-description,
                .testimonial-name, .testimonial-text
            `);
            
            homeTexts.forEach(text => {
                text.classList.remove('text-white');
            });
        }
    }
}

// Mettre à jour les styles spécifiques pour la page colis
function updateColisPageStyles(enabled) {
    const colisPage = document.querySelector('.min-h-screen.bg-gradient-to-br');
    
    if (colisPage) {
        if (enabled) {
            // Styles pour colis avec effet glass
            colisPage.classList.remove('bg-gradient-to-br', 'from-slate-50', 'to-blue-50');
            colisPage.classList.add('liquid-glass-enabled');
            
            // S'assurer que les textes sont visibles
            const colisTexts = colisPage.querySelectorAll(`
                .text-slate-800, .text-slate-700, .text-slate-600
            `);
            
            colisTexts.forEach(text => {
                text.classList.add('text-white');
                text.classList.remove('text-slate-800', 'text-slate-700', 'text-slate-600');
            });
            
        } else {
            // Styles pour colis sans effet glass
            colisPage.classList.add('bg-gradient-to-br', 'from-slate-50', 'to-blue-50');
            colisPage.classList.remove('liquid-glass-enabled');
            
            // Restaurer les couleurs originales
            const colisTexts = colisPage.querySelectorAll('.text-white');
            colisTexts.forEach(text => {
                text.classList.remove('text-white');
            });
        }
    }
}

// Mettre à jour l'apparence du bouton de toggle
function updateToggleButton() {
    const glassToggle = document.getElementById('glassToggleHeader');
    
    if (glassToggle) {
        if (LIQUID_GLASS_STATE.enabled) {
            glassToggle.innerHTML = '<i class="fas fa-times"></i>';
            glassToggle.title = 'Désactiver l\'effet Glass';
            glassToggle.setAttribute('aria-label', 'Désactiver l\'effet verre dépoli');
        } else {
            glassToggle.innerHTML = '<i class="fas fa-glass-whiskey"></i>';
            glassToggle.title = 'Activer l\'effet Glass';
            glassToggle.setAttribute('aria-label', 'Activer l\'effet verre dépoli');
        }
        
        // Ajouter une animation de feedback
        glassToggle.classList.add('glass-toggle-animate');
        setTimeout(() => {
            glassToggle.classList.remove('glass-toggle-animate');
        }, 300);
    }
}

// Fonction pour forcer l'activation/désactivation
function setLiquidGlassEnabled(enabled) {
    LIQUID_GLASS_STATE.enabled = enabled;
    localStorage.setItem(LIQUID_GLASS_CONFIG.enabledKey, enabled.toString());
    applyLiquidGlassEffect(enabled);
    updateToggleButton();
}

// Détecter les changements de page
function handlePageChange() {
    setTimeout(() => {
        initializeLiquidGlass();
        initializeGlassToggle();
    }, 100);
}

// Écouter les événements de changement de route
if (typeof window !== 'undefined') {
    window.addEventListener('load', initializeLiquidGlass);
    window.addEventListener('popstate', handlePageChange);
    
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && !link.href.includes('#')) {
            setTimeout(handlePageChange, 500);
        }
    });
}

// Fonction utilitaire pour vérifier si une page doit avoir l'effet glass
function shouldApplyGlassEffect() {
    const body = document.getElementById('main-body') || document.body;
    return !body.classList.contains('no-liquid-glass');
}

// Exposer les fonctions globalement
window.LiquidGlass = {
    toggle: toggleLiquidGlass,
    setEnabled: setLiquidGlassEnabled,
    isEnabled: () => LIQUID_GLASS_STATE.enabled,
    refresh: () => applyLiquidGlassEffect(LIQUID_GLASS_STATE.enabled),
    shouldApply: shouldApplyGlassEffect
};

// Styles CSS dynamiques pour l'animation du bouton
const style = document.createElement('style');
style.textContent = `
    .glass-toggle-animate {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
    
    .liquid-glass-container {
        transition: all 0.5s ease;
    }
    
    /* Amélioration de l'accessibilité */
    #glassToggleHeader:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
    
    /* État réduit de mouvement */
    @media (prefers-reduced-motion: reduce) {
        .glass-toggle-animate,
        .liquid-glass-container {
            transition: none;
        }
    }
`;
document.head.appendChild(style);

console.log('Liquid Glass Manager initialisé - Version corrigée');