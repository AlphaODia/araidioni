<form class="search-form liquid-glass" id="searchForm" method="GET">
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Départ</label>
            <input type="text" name="depart" class="search-input" placeholder="Ex: Dakar" required>
        </div>
        <div class="form-group">
            <label class="form-label">Destination</label>
            <input type="text" name="destination" class="search-input" placeholder="Ex: Conakry" required>
        </div>
        <div class="form-group">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="search-input" required>
        </div>
        <div class="form-group">
            <label class="form-label">Type de véhicule</label>
            <select name="vehicle_type" class="search-select" required>
                <option value="">Sélectionnez un type</option>
                <option value="bus">Bus</option>
                <option value="minicar">Mini-car</option>
                <option value="taxi">Taxi VIP</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn-search">Rechercher</button>
</form>