<!-- Seat Selection Modal -->
<div class="modal" id="seatModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Sélection des sièges</h2>
            <button class="modal-close" onclick="closeSeatSelection()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="seat-layout">
                <div class="seat-legend">
                    <div class="legend-item">
                        <div class="legend-color legend-available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-reserved"></div>
                        <span>Réservé</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-selected"></div>
                        <span>Votre choix</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-driver"></div>
                        <span>Conducteur</span>
                    </div>
                </div>
                
                <div id="busLayout" class="bus-layout" style="display: none;">
                    <!-- Driver seat -->
                    <div class="seat seat-driver">D</div>
                    <div class="aisle"></div>
                    <div class="aisle"></div>
                    <div class="aisle"></div>
                    <div class="aisle"></div>
                    
                    <!-- Rows 1-12: 4 seats per row (2+2 with aisle) -->
                    <!-- Generated with JavaScript for brevity -->
                </div>
                
                <div id="minicarLayout" class="minicar-layout" style="display: none;">
                    <!-- Driver seat -->
                    <div class="seat seat-driver">D</div>
                    <div class="aisle"></div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '1')">1</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '2')">2</div>
                    
                    <!-- Row 1 -->
                    <div class="seat seat-available" onclick="toggleSeat(this, '3')">3</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '4')">4</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '5')">5</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '6')">6</div>
                    
                    <!-- Row 2 -->
                    <div class="seat seat-available" onclick="toggleSeat(this, '7')">7</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '8')">8</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '9')">9</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '10')">10</div>
                    
                    <!-- Row 3 -->
                    <div class="seat seat-available" onclick="toggleSeat(this, '11')">11</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '12')">12</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '13')">13</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '14')">14</div>
                </div>
                
                <div id="taxiLayout" class="taxi-layout" style="display: none;">
                    <!-- Driver seat -->
                    <div class="seat seat-driver">D</div>
                    <div class="aisle"></div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '1')">1</div>
                    
                    <!-- Row 1 -->
                    <div class="seat seat-available" onclick="toggleSeat(this, '2')">2</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '3')">3</div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '4')">4</div>
                    
                    <!-- Row 2 -->
                    <div class="seat seat-available" onclick="toggleSeat(this, '5')">5</div>
                    <div class="aisle"></div>
                    <div class="seat seat-available" onclick="toggleSeat(this, '6')">6</div>
                </div>
            </div>
            
            <div class="selected-seats" id="selectedSeats">
                Aucun siège sélectionné
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeSeatSelection()">Annuler</button>
                <button class="btn btn-primary" onclick="confirmReservation()">Confirmer la réservation</button>
            </div>
        </div>
    </div>
</div>