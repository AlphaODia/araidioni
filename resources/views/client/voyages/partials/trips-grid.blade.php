<h2 class="section-title">Trajets disponibles</h2>

<div class="trips-grid" id="tripsContainer">
    <!-- Les trajets seront chargés dynamiquement ici -->
</div>

<!-- Template pour une carte de voyage -->
<template id="tripCardTemplate">
    <div class="trip-card liquid-glass">
        <div class="trip-image">
            <img src="" alt="" loading="lazy">
            <div class="trip-badge"></div>
        </div>
        <div class="trip-details">
            <h3 class="trip-route"></h3>
            <div class="trip-info">
                <i class="far fa-calendar-alt"></i>
                <span></span>
            </div>
            <div class="trip-meta">
                <div class="trip-meta-item">
                    <i class="far fa-clock"></i>
                    <span></span>
                </div>
                <div class="trip-meta-item">
                    <i class="fas fa-chair"></i>
                    <span></span>
                </div>
            </div>
            <div class="trip-price">
                <div>
                    <div class="price-from">À partir de</div>
                    <div class="price-amount"></div>
                </div>
                <button class="btn btn-primary">
                    Choisir un siège
                </button>
            </div>
        </div>
    </div>
</template>