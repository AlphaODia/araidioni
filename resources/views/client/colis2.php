<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Colis - Effet Liquid Glass</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --glass-color-1: #667eea;
            --glass-color-2: #764ba2;
            --glass-border-color: rgba(255, 255, 255, 0.2);
            --glass-bg-color: #F5F5F5;
            --glass-text-color: #2C3E50;
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.5s ease;
        }

        body.liquid-glass-enabled {
            background: linear-gradient(to bottom, var(--glass-color-1), var(--glass-color-2));
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Effet Liquid Glass */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border-color);
            border-radius: 15px;
            box-shadow: var(--glass-shadow);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .glass-button {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .glass-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Styles normaux (sans effet glass) */
        .normal-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .normal-button {
            background: #0E67E2;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .normal-button:hover {
            background: #0a54b3;
        }

        /* En-tête et navigation */
        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 0 0 15px 15px;
        }

        .liquid-glass-enabled .app-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border-color);
        }

        .normal-header {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .app-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .liquid-glass-enabled .app-title {
            color: white;
        }

        .normal-title {
            color: var(--glass-text-color);
        }

        .glass-toggle {
            cursor: pointer;
            font-size: 1.5rem;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .liquid-glass-enabled .glass-toggle {
            color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .normal-toggle {
            color: var(--glass-text-color);
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        .liquid-glass-enabled th {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .normal-th {
            background: #EFF6FF;
            color: #0E67E2;
        }

        .liquid-glass-enabled tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .normal-tr {
            border-bottom: 1px solid #E5E7EB;
        }

        .liquid-glass-enabled td {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Badges de statut */
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pending {
            background: rgba(255, 193, 7, 0.2);
            color: #FFC107;
        }

        .shipped {
            background: rgba(13, 110, 253, 0.2);
            color: #0D6EFD;
        }

        .delivered {
            background: rgba(25, 135, 84, 0.2);
            color: #198754;
        }

        /* Formulaire */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .liquid-glass-enabled .form-label {
            color: rgba(255, 255, 255, 0.8);
        }

        .form-input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .liquid-glass-enabled .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .liquid-glass-enabled .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .normal-input {
            border: 1px solid #D1D5DB;
            background: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            th, td {
                padding: 8px 10px;
            }
            
            .app-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body class="liquid-glass-enabled">
    <header class="app-header">
        <h1 class="app-title">Vos Colis</h1>
        <div class="glass-toggle" id="glassToggle">
            <i class="fas fa-filter"></i>
        </div>
    </header>

    <div class="container">
        <!-- Formulaire de recherche -->
        <div class="glass-card" id="searchCard">
            <h2 class="form-label">Rechercher un colis</h2>
            <form action="#" method="GET" class="flex gap-4 items-end" style="display: flex; gap: 1rem; align-items: end;">
                <div class="form-group" style="flex: 1;">
                    <label for="search" class="form-label">Numéro de suivi</label>
                    <input type="text" name="tracking_number" id="search" 
                           class="form-input"
                           placeholder="Entrez le numéro de suivi">
                </div>
                <div>
                    <button type="submit" class="glass-button" id="searchButton">
                        <i class="fas fa-search mr-2"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tableau des colis -->
        <div class="glass-card" id="tableCard">
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th class="liquid-glass-enabled">N° Suivi</th>
                            <th class="liquid-glass-enabled">Expéditeur</th>
                            <th class="liquid-glass-enabled">Destinataire</th>
                            <th class="liquid-glass-enabled">Statut</th>
                            <th class="liquid-glass-enabled">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TR01-1742142016573</td>
                            <td>Jean Dupont</td>
                            <td>Marie Martin</td>
                            <td>
                                <span class="status-badge shipped">shipped</span>
                            </td>
                            <td>
                                <a href="#" style="color: #0EA5E9;">Voir</a>
                            </td>
                        </tr>
                        <tr>
                            <td>TR01-1742142016574</td>
                            <td>Paul Lefevre</td>
                            <td>Sophie Lambert</td>
                            <td>
                                <span class="status-badge pending">pending_payment</span>
                            </td>
                            <td>
                                <a href="#" style="color: #0EA5E9;">Voir</a>
                            </td>
                        </tr>
                        <tr>
                            <td>TR01-1742142016575</td>
                            <td>Lucie Bernard</td>
                            <td>Thomas Petit</td>
                            <td>
                                <span class="status-badge delivered">delivered</span>
                            </td>
                            <td>
                                <a href="#" style="color: #0EA5E9;">Voir</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bouton nouveau colis -->
        <div>
            <button class="glass-button" id="newPackageButton">
                <i class="fas fa-plus mr-2"></i> Nouveau Colis
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const glassToggle = document.getElementById('glassToggle');
            const body = document.body;
            let liquidGlassEnabled = true;
            
            // Éléments à modifier
            const searchCard = document.getElementById('searchCard');
            const tableCard = document.getElementById('tableCard');
            const searchButton = document.getElementById('searchButton');
            const newPackageButton = document.getElementById('newPackageButton');
            const appHeader = document.querySelector('.app-header');
            const appTitle = document.querySelector('.app-title');
            const formLabels = document.querySelectorAll('.form-label');
            const formInputs = document.querySelectorAll('.form-input');
            const tableHeaders = document.querySelectorAll('th');
            
            glassToggle.addEventListener('click', function() {
                liquidGlassEnabled = !liquidGlassEnabled;
                
                if (liquidGlassEnabled) {
                    // Activer l'effet Liquid Glass
                    body.classList.add('liquid-glass-enabled');
                    body.classList.remove('normal-glass-disabled');
                    
                    searchCard.classList.add('glass-card');
                    searchCard.classList.remove('normal-card');
                    
                    tableCard.classList.add('glass-card');
                    tableCard.classList.remove('normal-card');
                    
                    searchButton.classList.add('glass-button');
                    searchButton.classList.remove('normal-button');
                    
                    newPackageButton.classList.add('glass-button');
                    newPackageButton.classList.remove('normal-button');
                    
                    appHeader.classList.add('liquid-glass-enabled');
                    appHeader.classList.remove('normal-header');
                    
                    appTitle.classList.add('liquid-glass-enabled');
                    appTitle.classList.remove('normal-title');
                    
                    glassToggle.classList.add('liquid-glass-enabled');
                    glassToggle.classList.remove('normal-toggle');
                    
                    formLabels.forEach(label => {
                        label.classList.add('liquid-glass-enabled');
                    });
                    
                    formInputs.forEach(input => {
                        input.classList.add('liquid-glass-enabled');
                        input.classList.remove('normal-input');
                    });
                    
                    tableHeaders.forEach(header => {
                        header.classList.add('liquid-glass-enabled');
                        header.classList.remove('normal-th');
                    });
                    
                    // Changer l'icône
                    glassToggle.innerHTML = '<i class="fas fa-filter"></i>';
                    
                } else {
                    // Désactiver l'effet Liquid Glass
                    body.classList.remove('liquid-glass-enabled');
                    
                    searchCard.classList.remove('glass-card');
                    searchCard.classList.add('normal-card');
                    
                    tableCard.classList.remove('glass-card');
                    tableCard.classList.add('normal-card');
                    
                    searchButton.classList.remove('glass-button');
                    searchButton.classList.add('normal-button');
                    
                    newPackageButton.classList.remove('glass-button');
                    newPackageButton.classList.add('normal-button');
                    
                    appHeader.classList.remove('liquid-glass-enabled');
                    appHeader.classList.add('normal-header');
                    
                    appTitle.classList.remove('liquid-glass-enabled');
                    appTitle.classList.add('normal-title');
                    
                    glassToggle.classList.remove('liquid-glass-enabled');
                    glassToggle.classList.add('normal-toggle');
                    
                    formLabels.forEach(label => {
                        label.classList.remove('liquid-glass-enabled');
                    });
                    
                    formInputs.forEach(input => {
                        input.classList.remove('liquid-glass-enabled');
                        input.classList.add('normal-input');
                    });
                    
                    tableHeaders.forEach(header => {
                        header.classList.remove('liquid-glass-enabled');
                        header.classList.add('normal-th');
                    });
                    
                    // Changer l'icône
                    glassToggle.innerHTML = '<i class="fas fa-filter-none"></i>';
                }
            });
        });
    </script>
</body>
</html>