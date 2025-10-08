<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hébergements Premium en Guinée et Sénégal</title>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        'primary-dark': '#4338ca',
                        secondary: '#7c3aed',
                        light: '#f3f4f6',
                        dark: '#1f2937',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* Styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #fff;
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect {
            background: #ffffff;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Effet Liquid Glass */
        .liquid-glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .liquid-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #333;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
        
        /* Header Styles */
        header {
            position: fixed;
            width: 100%;
            z-index: 50;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2), inset 0 4px 20px rgba(255, 255, 255, 0.3);
        }
        
        body.no-glass-effect header {
            background: white;
            backdrop-filter: none;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .logo img {
            height: 48px;
            width: 48px;
            object-fit: contain;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        nav {
            display: flex;
            gap: 2rem;
        }
        
        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: var(--primary);
        }
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        /* Glass Toggle Button in Header */
        .glass-toggle-header {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(31, 38, 135, 0.2);
            transition: all 0.3s ease;
            margin-left: 1rem;
        }
        
        .glass-toggle-header:hover {
            transform: scale(1.1);
        }
        
        .glass-toggle-header i {
            font-size: 1.2rem;
            color: var(--primary);
        }
        
        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        /* Barre de recherche */
        .search-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .search-box {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        @media (min-width: 768px) {
            .search-box {
                flex-direction: row;
            }
        }
        
        .search-input {
            position: relative;
            flex: 1;
        }
        
        .search-input input {
            width: 100%;
            padding: 15px 15px 15px 50px;
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 1rem;
        }
        
        body.no-glass-effect .search-input input {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }
        
        .search-input input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        body.no-glass-effect .search-input input::placeholder {
            color: rgba(0, 0, 0, 0.6);
        }
        
        .search-input svg {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }
        
        body.no-glass-effect .search-input svg {
            color: rgba(0, 0, 0, 0.6);
        }
        
        .search-btn {
            padding: 15px 25px;
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .search-btn {
            background: rgba(37, 99, 235, 0.9);
            color: white;
        }
        
        .search-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        body.no-glass-effect .search-btn:hover {
            background: rgba(37, 99, 235, 1);
        }
        
        /* Toggle Glass Effect */
        .glass-effect-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .glass-effect-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        body.no-glass-effect .glass-effect-toggle {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }
        
        .toggle-text {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .toggle-switch {
            width: 40px;
            height: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .toggle-switch {
            background: rgba(37, 99, 235, 0.5);
        }
        
        body.no-glass-effect .toggle-switch::after {
            left: 22px;
            background: white;
        }
        
        /* Layout principal */
        .main-layout {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        @media (min-width: 1024px) {
            .main-layout {
                flex-direction: row;
            }
        }
        
        /* Filtres */
        .filters {
            width: 100%;
            padding: 25px;
        }
        
        @media (min-width: 1024px) {
            .filters {
                width: 25%;
                position: sticky;
                top: 20px;
                height: fit-content;
            }
        }
        
        .filters h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        body.no-glass-effect .filters h3 {
            color: #333;
        }
        
        .toggle-filters {
            display: none;
        }
        
        @media (max-width: 1023px) {
            .toggle-filters {
                display: block;
            }
            
            .filters-content {
                display: none;
            }
            
            .filters-content.show {
                display: block;
            }
        }
        
        .filter-group {
            margin-bottom: 25px;
        }
        
        .filter-group h4 {
            font-size: 1rem;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        body.no-glass-effect .filter-group h4 {
            color: #333;
        }
        
        .filter-group select, .filter-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
        }
        
        body.no-glass-effect .filter-group select, 
        body.no-glass-effect .filter-group input {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .filter-group option {
            background: rgba(51, 51, 51, 0.9);
            color: white;
        }
        
        body.no-glass-effect .filter-group option {
            background: white;
            color: #333;
        }
        
        .price-range {
            margin-top: 10px;
        }
        
        .price-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-top: 5px;
            opacity: 0.8;
        }
        
        body.no-glass-effect .price-labels {
            color: #333;
        }
        
        .filter-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .apply-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        body.no-glass-effect .apply-btn {
            background: rgba(37, 99, 235, 0.9);
            color: white;
        }
        
        .apply-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        body.no-glass-effect .apply-btn:hover {
            background: rgba(37, 99, 235, 1);
        }
        
        .reset-btn {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        body.no-glass-effect .reset-btn {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        
        .reset-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        body.no-glass-effect .reset-btn:hover {
            background: rgba(255, 255, 255, 1);
        }
        
        /* Contenu principal */
        .content {
            width: 100%;
        }
        
        @media (min-width: 1024px) {
            .content {
                width: 75%;
            }
        }
        
        .content-header {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        
        @media (min-width: 768px) {
            .content-header {
                flex-direction: row;
                align-items: center;
            }
        }
        
        .content-header h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        body.no-glass-effect .content-header h2 {
            color: #333;
        }
        
        .content-header p {
            opacity: 0.8;
            margin-bottom: 15px;
        }
        
        body.no-glass-effect .content-header p {
            color: #555;
        }
        
        .sort-select {
            padding: 10px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
        }
        
        body.no-glass-effect .sort-select {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .sort-select option {
            background: rgba(51, 51, 51, 0.9);
            color: white;
        }
        
        body.no-glass-effect .sort-select option {
            background: white;
            color: #333;
        }
        
        /* Carte */
        .map-container {
            margin-bottom: 30px;
            padding: 20px;
        }
        
        .map-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .map-header h3 {
            font-size: 1.2rem;
        }
        
        body.no-glass-effect .map-header h3 {
            color: #333;
        }
        
        .enlarge-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            background: none;
            border: none;
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
            opacity: 0.8;
        }
        
        body.no-glass-effect .enlarge-btn {
            color: #333;
        }
        
        .enlarge-btn:hover {
            opacity: 1;
        }
        
        #map {
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
        }
        
        /* Grille d'hébergements */
        .hebergements-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }
        
        @media (min-width: 640px) {
            .hebergements-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1024px) {
            .hebergements-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        /* Carte d'hébergement */
        .hebergement-card {
            height: 100%;
            overflow: hidden;
            cursor: pointer;
        }
        
        .card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .hebergement-card:hover .card-image img {
            transform: scale(1.05);
        }
        
        .card-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(37, 99, 235, 0.9);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .card-favorite {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .card-favorite:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }
        
        .card-price {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            color: #2563eb;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .card-price span {
            font-weight: 400;
            font-size: 0.8rem;
            color: #6b7280;
        }
        
        .card-content {
            padding: 20px;
        }
        
        body.no-glass-effect .card-content {
            color: #333;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: white;
        }
        
        body.no-glass-effect .card-title {
            color: #333;
        }
        
        .card-location {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 5px;
        }
        
        body.no-glass-effect .card-location {
            color: #555;
        }
        
        .card-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(37, 99, 235, 0.2);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        body.no-glass-effect .card-rating {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
        }
        
        .card-description {
            font-size: 0.95rem;
            opacity: 0.8;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        body.no-glass-effect .card-description {
            color: #555;
        }
        
        .card-features {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        body.no-glass-effect .card-features {
            color: #555;
        }
        
        .card-feature {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .card-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .card-button {
            background: rgba(37, 99, 235, 0.9);
            color: white;
        }
        
        .card-button:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        body.no-glass-effect .card-button:hover {
            background: rgba(37, 99, 235, 1);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        
        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .pagination a {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        
        .pagination a:hover, .pagination a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        body.no-glass-effect .pagination a:hover, 
        body.no-glass-effect .pagination a.active {
            background: rgba(37, 99, 235, 0.9);
            color: white;
        }
        
        /* Modals */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modal.show {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 16px;
            padding: 0;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.no-glass-effect .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        body.no-glass-effect .modal-header h3 {
            color: #333;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        body.no-glass-effect .close-modal {
            color: #333;
        }
        
        .close-modal:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        body.no-glass-effect .close-modal:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
        /* Footer Styles */
        footer {
            background: linear-gradient(to bottom, #111827, #000);
            position: relative;
            overflow: hidden;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 4rem 0 2rem;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
        
        .footer-description {
            color: #d1d5db;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
        }
        
        .footer-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #4f46e5;
            display: inline-block;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }
        
        .footer-links a:hover {
            color: #818cf8;
        }
        
        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }
        
        .footer-newsletter input {
            width: 100%;
            padding: 0.75rem;
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 0.5rem;
            color: white;
            margin-bottom: 0.75rem;
        }
        
        .footer-newsletter .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-section {
            padding: 2rem 0;
            border-top: 1px solid #374151;
        }
        
        .footer-bottom {
            padding: 1.5rem 0;
            border-top: 1px solid #374151;
            text-align: center;
            color: #9ca3af;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .header p {
                font-size: 1rem;
            }
            
            .card-features {
                flex-direction: column;
                gap: 8px;
            }
            
            .glass-effect-toggle {
                bottom: 10px;
                right: 10px;
                padding: 8px 16px;
            }
            
            .toggle-text {
                display: none;
            }
        }
        
        /* Utilitaires */
        .hidden {
            display: none;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Styles pour les particules et vagues dans le footer */
        .particle {
            animation: float 15s infinite ease-in-out;
            will-change: transform, opacity;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg) scale(1); opacity: 0.7; }
            50% { transform: translateY(-40px) rotate(180deg) scale(1.2); opacity: 1; }
            100% { transform: translateY(-80px) rotate(360deg) scale(1); opacity: 0.1; }
        }
        
        .social-icon {
            display: inline-flex;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            align-items: center;
            justify-content: center;
            color: #ddd;
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        
        .social-icon:hover {
            color: white;
            background: #4f46e5;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .payment-method {
            background: rgba(255, 255, 255, 0.05);
            padding: 8px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 60px;
        }
        
        .payment-method:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px);
            border-color: #4f46e5;
        }
        
        .wave-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            pointer-events: none;
            overflow: hidden;
        }
        
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 100%;
        }
        
        .wave-fill {
            fill: #1f2937;
            animation: waveAnimation 15s linear infinite;
        }
        
        @keyframes waveAnimation {
            0% { transform: translateX(0); }
            50% { transform: translateX(-25%); }
            100% { transform: translateX(-50%); }
        }
    </style>




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
                    
                    fetch('/newsletter/subscribe', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => {
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
                        alert('Erreur de connexion au serveur');
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
                                            <option value="">Sélectionnez une note</option>
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
                
                fetch('/avis/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
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
                    alert('Erreur de connexion au serveur');
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
    <!-- Header -->
    <header class="fixed w-full z-50">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center bg-white">
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

                <!-- Navigation Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('voyages') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Voyages</a>
                    <a href="{{ route('colis.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Colis</a>
                    <a href="{{ route('hebergements') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Hébergements</a>
                </nav>

                <!-- Boutons CTA et Glass Toggle -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('client.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Mon compte
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium hover:bg-white/20 py-2 px-4 rounded-lg transition">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Inscription
                        </a>
                    @endauth
                    
                    <!-- Glass Effect Toggle Button in Header -->
                    <div class="glass-toggle-header" id="glassToggleHeader">
                        <i class="fas fa-glass-whiskey"></i>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div class="md:hidden mt-4">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white/10 backdrop-filter backdrop-blur-lg border-t border-white/20 mt-2">
                    <nav class="flex flex-col space-y-4 p-4">
                        <a href="{{ route('voyages') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Voyages</a>
                        <a href="{{ route('colis.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Colis</a>
                        <a href="{{ route('hebergements') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Hébergements</a>
                        @guest
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Connexion</a>
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Inscription</a>
                        @endguest
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="padding-top: 100px;">
        <div class="container">
            <!-- En-tête avec recherche -->
            <div class="header">
                <h1>Découvrez nos hébergements d'exception</h1>
                <p>Des logements premium en Guinée et au Sénégal pour des séjours inoubliables</p>
                
                <div class="search-container liquid-glass">
                    <div class="search-box">
                        <div class="search-input">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" id="searchInput" placeholder="Destination, ville, type d'hébergement...">
                        </div>
                        <button id="searchBtn" class="search-btn">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Filtres et résultats -->
            <div class="main-layout">
                <!-- Filtres -->
                <div class="filters glass-card">
                    <div class="filters-header">
                        <h3>Filtres <button class="toggle-filters" id="toggleFilters">☰</button></h3>
                    </div>
                    
                    <div class="filters-content" id="filtersContent">
                        <div class="filter-group">
                            <h4>Pays</h4>
                            <select id="filterPays">
                                <option value="all">Tous les pays</option>
                                <option value="Guinée">Guinée</option>
                                <option value="Sénégal">Sénégal</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <h4>Ville</h4>
                            <select id="filterVille">
                                <option value="all">Toutes les villes</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville }}">{{ $ville }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <h4>Type</h4>
                            <select id="filterType">
                                <option value="all">Tous types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <h4>Prix max/nuit</h4>
                            <input type="range" id="priceRange" min="0" max="500000" step="5000" value="500000">
                            <div class="price-labels">
                                <span>0 FCFA</span>
                                <span id="maxPriceText">500 000 FCFA</span>
                            </div>
                        </div>
                        
                        <div class="filter-buttons">
                            <button id="applyFilters" class="filter-btn apply-btn">Appliquer</button>
                            <button id="resetFilters" class="filter-btn reset-btn">Réinitialiser</button>
                        </div>
                    </div>
                </div>
                
                <!-- Contenu principal -->
                <div class="content">
                    <!-- En-tête résultats -->
                    <div class="content-header glass-card" style="padding: 20px;">
                        <div>
                            <h2>Nos hébergements premium</h2>
                            <p id="resultsCount">{{ count($hebergements) }} propriétés disponibles</p>
                        </div>
                        <div>
                            <select class="sort-select">
                                <option>Trier par: Recommandations</option>
                                <option>Prix croissant</option>
                                <option>Prix décroissant</option>
                                <option>Meilleures notes</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Carte -->
                    <div class="map-container glass-card">
                        <div class="map-header">
                            <h3>Localisation des hébergements</h3>
                            <button class="enlarge-btn">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path>
                                </svg>
                                Agrandir
                            </button>
                        </div>
                        <div id="map"></div>
                    </div>
                    
                    <!-- Liste des hébergements -->
                    <div id="hebergementsList" class="hebergements-grid">
                        @if(count($hebergements) > 0)
                            @foreach($hebergements as $id => $hebergement)
                                @if($hebergement['estDisponible'])
                                    <div class="hebergement-card glass-card" 
                                         data-id="{{ $id }}"
                                         data-ville="{{ $hebergement['ville'] ?? '' }}"
                                         data-pays="{{ $hebergement['pays'] ?? '' }}"
                                         data-type="{{ $hebergement['typeLogement'] ?? '' }}"
                                         data-prix="{{ $hebergement['prixNuit'] ?? 0 }}">
                                        <div class="card-image">
                                            @php
                                                $imageUrl = 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600&q=80';
                                                if (!empty($hebergement['imagesUrls'])) {
                                                    $imageUrl = is_array($hebergement['imagesUrls']) ? 
                                                        ($hebergement['imagesUrls'][0] ?? $imageUrl) : 
                                                        $hebergement['imagesUrls'];
                                                }
                                            @endphp
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $hebergement['titre'] ?? 'Hébergement' }}">
                                            <div class="card-favorite">
                                                <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                            @php
                                                $isNew = false; // Initialisation par défaut
                                                if (isset($hebergement['dateCreation']) && 
                                                    now()->diffInDays(\Carbon\Carbon::parse($hebergement['dateCreation'])) < 7) {
                                                    $isNew = true;
                                                }
                                            @endphp
                                            @if($isNew)
                                                <div class="card-badge">NOUVEAU</div>
                                            @endif
                                            <div class="card-price">
                                                {{ number_format($hebergement['prixNuit'] ?? 0, 0, ',', ' ') }} FCFA<span>/nuit</span>
                                            </div>
                                        </div>
                                        
                                        <div class="card-content">
                                            <div class="card-header">
                                                <div>
                                                    <h3 class="card-title">{{ $hebergement['titre'] ?? 'Sans titre' }}</h3>
                                                    <div class="card-location">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        {{ $hebergement['ville'] ?? '' }}, {{ $hebergement['pays'] ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="card-rating">
                                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    {{ $hebergement['rating'] ?? '4.5' }}
                                                </div>
                                            </div>
                                            
                                            <p class="card-description">{{ $hebergement['description'] ?? '' }}</p>
                                            
                                            <div class="card-features">
                                                @if(isset($hebergement['capacite']))
                                                <div class="card-feature">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    {{ $hebergement['capacite'] }} personnes
                                                </div>
                                                @endif
                                                
                                                @if(isset($hebergement['nombreChambres']))
                                                <div class="card-feature">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                    {{ $hebergement['nombreChambres'] }} chambres
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <button class="card-button view-details-btn" data-id="{{ $id }}">Voir disponibilités</button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="glass-card text-center" style="padding: 40px; grid-column: 1 / -1;">
                                <svg class="h-16 w-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <h3 class="text-xl font-medium mb-2">Aucun hébergement disponible</h3>
                                <p class="opacity-80 mb-4">Aucun hébergement ne correspond à vos critères de recherche pour le moment.</p>
                                <button id="resetSearch" class="text-blue-300 hover:text-blue-100 font-medium">
                                    Réinitialiser la recherche
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination">
                        <a href="#" class="px-3 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <span class="px-2">...</span>
                        <a href="#">10</a>
                        <a href="#">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Bouton de toggle pour l'effet glass -->
    <div class="glass-effect-toggle" id="glassEffectToggle">
        <span class="toggle-text">Effet Glass</span>
        <div class="toggle-switch"></div>
    </div>
    
    <!-- Modal de détails -->
    <div id="detailsModal" class="modal">
        <div class="modal-content liquid-glass">
            <div class="modal-header">
                <h3>Détails de l'hébergement</h3>
                <button class="close-modal" id="closeDetailsModal">×</button>
            </div>
            <div id="modalContent" style="padding: 20px;">
                <!-- Le contenu sera chargé dynamiquement par JavaScript -->
            </div>
        </div>
    </div>

    <!-- Modal de réservation -->
    <div id="reservationModal" class="modal">
        <div class="modal-content liquid-glass" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Réserver cet hébergement</h3>
                <button class="close-modal" id="closeModal">×</button>
            </div>
            
            <form id="reservationForm" style="padding: 20px;">
                @csrf
                <input type="hidden" id="hebergementId" name="hebergement_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="arrivee" class="block text-sm font-medium mb-1">Arrivée</label>
                        <input type="date" id="arrivee" name="arrivee" required 
                               class="w-full border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-10 text-white">
                    </div>
                    <div>
                        <label for="depart" class="block text-sm font-medium mb-1">Départ</label>
                        <input type="date" id="depart" name="depart" required 
                               class="w-full border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-10 text-white">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium mb-1">Nom complet</label>
                    <input type="text" id="nom" name="nom" required 
                           class="w-full border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-10 text-white">
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-10 text-white">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Téléphone</label>
                    <div class="flex gap-2">
                        <select id="indicatif" name="indicatif" class="w-1/4 border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-10 text-white">
                            <option value="+221">+221 (SN)</option>
                            <option value="+224">+224 (GN)</option>
                            <option value="+223">+223 (ML)</option>
                            <option value="+226">+226 (BF)</option>
                        </select>
                        <input type="tel" id="telephone" name="telephone" required 
                               class="flex-1 border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-10 text-white">
                    </div>
                </div>
                
                <div class="bg-white bg-opacity-10 p-4 rounded-lg mb-5">
                    <h4 class="font-medium mb-2">Récapitulatif</h4>
                    <div id="reservationSummary" class="text-sm">
                        Sélectionnez des dates pour voir le détail
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelReservation" class="px-5 py-2.5 bg-white bg-opacity-10 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition font-medium">
                        Annuler
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-white bg-opacity-20 text-white rounded-lg hover:bg-white hover:bg-opacity-30 transition font-medium">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
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
                    <div class="footer-logo" style="background: white; padding: 10px;">
                        <span class="footer-logo-text" style="
                             background: linear-gradient(90deg, #333333, #555555, #777777);
                             -webkit-background-clip: text;
                             -webkit-text-fill-color: transparent;
                             font-weight: bold;
                             font-size: 1.25rem;
                                                ">
                            ARI DIONI
                        </span>
                        <img src="{{ asset('images/logo.png') }}" alt="Ari Dioni" class="h-12 w-12 object-contain">
                    </div>
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
                        Demander un devis
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















    
<script>
    // Données des hébergements
    let hebergementsData = <?php echo isset($hebergementsJson) ? $hebergementsJson : '[]'; ?>;
    let map;
    let markers = [];
    let detailMap;

    // Toggle de l'effet glass
    const glassEffectToggle = document.getElementById('glassEffectToggle');
    if (glassEffectToggle) {
        glassEffectToggle.addEventListener('click', function() {
            document.body.classList.toggle('no-glass-effect');
            const isGlassDisabled = document.body.classList.contains('no-glass-effect');
            localStorage.setItem('glassEffectDisabled', isGlassDisabled);
        });
        
        const glassEffectDisabled = localStorage.getItem('glassEffectDisabled');
        if (glassEffectDisabled === 'true') {
            document.body.classList.add('no-glass-effect');
        }
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 14.7167, lng: -17.4677 },
            zoom: 7,
            mapTypeId: "roadmap",
            styles: [
                {
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#444444"}]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{"color": "#f2f2f2"}]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{"saturation": -100}, {"lightness": 45}]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{"visibility": "simplified"}]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"color": "#d4f1f9"}, {"visibility": "on"}]
                }
            ]
        });
        
        addMarkersToMap();
    }

    function addMarkersToMap() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
        
        if (!hebergementsData || typeof hebergementsData !== 'object') {
            console.log('Aucune donnée d\'hébergement disponible');
            return;
        }
        
        Object.entries(hebergementsData).forEach(([id, hebergement]) => {
            try {
                if (hebergement && hebergement.coordonnees) {
                    const lat = parseFloat(hebergement.coordonnees.lat) || 0;
                    const lng = parseFloat(hebergement.coordonnees.lng) || 0;
                    
                    if (lat !== 0 && lng !== 0) {
                        const marker = new google.maps.Marker({
                            position: { lat, lng },
                            map: map,
                            title: hebergement.titre || 'Hébergement sans nom',
                            icon: {
                                url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                            }
                        });
                        
                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                                <div class="p-2">
                                    <h3 class="font-bold text-lg">${hebergement.titre || ''}</h3>
                                    <p class="text-sm text-gray-600">${hebergement.ville || ''}, ${hebergement.pays || ''}</p>
                                    <p class="text-blue-600 font-medium mt-1">
                                        ${hebergement.prixNuit ? new Intl.NumberFormat('fr-FR').format(hebergement.prixNuit) + ' FCFA/nuit' : 'Prix non disponible'}
                                    </p>
                                    <button class="mt-2 text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded view-details-btn" data-id="${id}">
                                        Voir détails
                                    </button>
                                </div>
                            `
                        });
                        
                        marker.addListener("click", () => {
                            infoWindow.open(map, marker);
                        });
                        
                        markers.push(marker);
                    }
                }
            } catch (error) {
                console.error('Erreur avec l\'hébergement:', error);
            }
        });
    }

    function initDetailMap(lat, lng, title) {
        const detailMapElement = document.getElementById('detailMap');
        if (!detailMapElement) return;
        
        detailMap = new google.maps.Map(detailMapElement, {
            center: { lat, lng },
            zoom: 15,
            mapTypeId: "roadmap",
            styles: [
                {
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#444444"}]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{"color": "#f2f2f2"}]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{"saturation": -100}, {"lightness": 45}]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{"visibility": "simplified"}]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"color": "#4f8ef7"}, {"visibility": "on"}]
                }
            ]
        });
        
        new google.maps.Marker({
            position: { lat, lng },
            map: detailMap,
            title: title,
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png"
            }
        });
    }

    // Soumission du formulaire de réservation
    const reservationForm = document.getElementById('reservationForm');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Traitement...';
            submitBtn.disabled = true;
            
            const reservationSummary = document.getElementById('reservationSummary');
            const originalSummary = reservationSummary.innerHTML;
            reservationSummary.innerHTML = '<div class="text-center">Traitement en cours...</div>';
            
            fetch("/hebergements/reserver", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Erreur réseau');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Redirection vers la page du ticket
                    window.location.href = data.redirectUrl;
                } else {
                    throw new Error(data.message || 'Erreur lors de la réservation');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                
                if (error.message.includes('network') || error.message.includes('Network')) {
                    alert('Erreur réseau. Veuillez vérifier votre connexion.');
                } else {
                    alert('Erreur: ' + error.message);
                }
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                reservationSummary.innerHTML = originalSummary;
            });
        });
    }

    function updateReservationSummary() {
        const arriveeInput = document.getElementById('arrivee');
        const departInput = document.getElementById('depart');
        const hebergementIdInput = document.getElementById('hebergementId');
        const reservationSummary = document.getElementById('reservationSummary');
        
        if (!arriveeInput || !departInput || !hebergementIdInput || !reservationSummary) {
            return;
        }
        
        const arrivee = new Date(arriveeInput.value);
        const depart = new Date(departInput.value);
        const hebergementId = hebergementIdInput.value;
        
        if (arrivee && depart && hebergementId && hebergementsData[hebergementId]) {
            const hebergement = hebergementsData[hebergementId];
            const diffTime = Math.abs(depart - arrivee);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const totalPrice = diffDays * hebergement.prixNuit;
            
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const arriveeFormatted = arrivee.toLocaleDateString('fr-FR', options);
            const departFormatted = depart.toLocaleDateString('fr-FR', options);
            
            reservationSummary.innerHTML = `
                <p>Du ${arriveeFormatted} au ${departFormatted}</p>
                <p>${diffDays} nuit(s) à ${new Intl.NumberFormat('fr-FR').format(hebergement.prixNuit)} FCFA/nuit</p>
                <p class="font-semibold mt-1">Total: ${new Intl.NumberFormat('fr-FR').format(totalPrice)} FCFA</p>
            `;
        }
    }

    function updatePriceText() {
        const priceRange = document.getElementById('priceRange');
        const maxPriceText = document.getElementById('maxPriceText');
        if (priceRange && maxPriceText) {
            maxPriceText.textContent = new Intl.NumberFormat('fr-FR').format(priceRange.value) + ' FCFA';
        }
    }

    function showHebergementDetails(id) {
        const hebergement = hebergementsData[id];
        if (!hebergement) {
            alert('Détails non disponibles pour cet hébergement');
            return;
        }

        const images = Array.isArray(hebergement.imagesUrls) ? hebergement.imagesUrls : [hebergement.imagesUrls];
        const firstImage = images[0] || 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600&q=80';
        const otherImages = images.slice(1, 5);
        
        let equipementsHTML = '';
        if (hebergement.equipements && hebergement.equipements.length > 0) {
            equipementsHTML = `
                <div class="glass-card mb-6" style="padding: 20px;">
                    <h2 class="text-xl font-bold mb-4">Équipements</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        ${hebergement.equipements.map(equipement => `
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>${equipement}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        let reglesHTML = '';
        if (hebergement.regles && hebergement.regles.length > 0) {
            reglesHTML = `
                <div class="glass-card mb-6" style="padding: 20px;">
                    <h2 class="text-xl font-bold mb-4">Règles de la maison</h2>
                    <div>
                        ${hebergement.regles.join('<br>')}
                    </div>
                </div>
            `;
        }

        let mapHTML = '';
        if (hebergement.coordonnees && hebergement.coordonnees.lat && hebergement.coordonnees.lng) {
            const lat = parseFloat(hebergement.coordonnees.lat);
            const lng = parseFloat(hebergement.coordonnees.lng);
            
            if (lat !== 0 && lng !== 0) {
                mapHTML = `
                    <div class="glass-card mb-6" style="padding: 20px;">
                        <h2 class="text-xl font-bold mb-4">Localisation</h2>
                        <div id="detailMap" class="h-64 rounded-lg"></div>
                        <p class="text-sm mt-2">
                            <svg class="h-4 w-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            ${hebergement.adresseComplete || hebergement.localisation || 'Adresse non spécifiée'}
                        </p>
                    </div>
                `;
            }
        }

        const modalContent = `
            <div class="mb-6">
                <h1 class="text-3xl font-bold">${hebergement.titre || 'Sans titre'}</h1>
                <div class="flex flex-col sm:flex-row sm:items-center mt-2 gap-2 sm:gap-4">
                    <div class="flex items-center px-3 py-1 rounded-full" style="background: rgba(37, 99, 235, 0.2);">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="ml-1 font-medium">${hebergement.rating || '4.5'}</span>
                        <span class="ml-2">(${Math.round((hebergement.rating || 4.5) * 20)} avis)</span>
                    </div>
                    <span>
                        <svg class="h-5 w-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        ${hebergement.ville || ''}, ${hebergement.pays || ''}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
                <div class="lg:col-span-2 row-span-2">
                    <img src="${firstImage}" alt="${hebergement.titre || 'Hébergement'}" class="w-full h-80 object-cover rounded-xl">
                </div>
                ${otherImages.map((img, i) => `
                    <div class="${i === 3 ? 'lg:col-span-2' : ''}">
                        <img src="${img}" alt="${hebergement.titre || 'Hébergement'}" class="w-full h-full object-cover rounded-xl">
                    </div>
                `).join('')}
            </div>
            
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-2/3">
                    <div class="glass-card mb-6" style="padding: 20px;">
                        <h2 class="text-xl font-bold mb-4">À propos de cet hébergement</h2>
                        <div>
                            ${hebergement.description || 'Description non disponible'}
                        </div>
                    </div>
                    
                    ${equipementsHTML}
                    ${reglesHTML}
                    ${mapHTML}
                </div>
                
                <div class="lg:w-1/3">
                    <div class="glass-card" style="padding: 20px; position: sticky; top: 20px;">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-2xl font-bold text-blue-400">${new Intl.NumberFormat('fr-FR').format(hebergement.prixNuit || 0)} FCFA</span>
                                <span class="opacity-80">/nuit</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="ml-1">${hebergement.rating || '4.5'}</span>
                                <span class="ml-1 opacity-80">(${Math.round((hebergement.rating || 4.5) * 20)} avis)</span>
                            </div>
                        </div>
                        
                        <button class="w-full py-3 rounded-lg font-medium reserve-btn" style="background: rgba(255, 255, 255, 0.2);" data-id="${id}">
                            Réserver maintenant
                        </button>
                        
                        <div class="mt-4 text-sm text-center opacity-80">
                            Aucun frais de réservation
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('modalContent').innerHTML = modalContent;
        document.getElementById('detailsModal').classList.add('show');

        if (hebergement.coordonnees && hebergement.coordonnees.lat && hebergement.coordonnees.lng) {
            const lat = parseFloat(hebergement.coordonnees.lat);
            const lng = parseFloat(hebergement.coordonnees.lng);
            
            if (lat !== 0 && lng !== 0) {
                setTimeout(() => {
                    initDetailMap(lat, lng, hebergement.titre || 'Hébergement');
                }, 100);
            }
        }

        document.querySelectorAll('.reserve-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const hebergementId = this.getAttribute('data-id');
                document.getElementById('hebergementId').value = hebergementId;
                document.getElementById('detailsModal').classList.remove('show');
                document.getElementById('reservationModal').classList.add('show');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePriceText();
        
        const filtersContent = document.getElementById('filtersContent');
        if (window.innerWidth < 1024) {
            filtersContent.classList.add('hidden');
        }
        
        const toggleFiltersBtn = document.getElementById('toggleFilters');
        if (toggleFiltersBtn) {
            toggleFiltersBtn.addEventListener('click', function() {
                filtersContent.classList.toggle('show');
            });
        }
        
        const applyFiltersBtn = document.getElementById('applyFilters');
        const resetFiltersBtn = document.getElementById('resetFilters');
        const resetSearchBtn = document.getElementById('resetSearch');
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        function filterHebergements() {
            const pays = document.getElementById('filterPays')?.value || 'all';
            const ville = document.getElementById('filterVille')?.value || 'all';
            const type = document.getElementById('filterType')?.value || 'all';
            const maxPrice = document.getElementById('priceRange')?.value || 500000;
            const searchText = searchInput?.value.toLowerCase() || '';
            
            const cards = document.querySelectorAll('.hebergement-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const cardVille = card.getAttribute('data-ville') || '';
                const cardType = card.getAttribute('data-type') || '';
                const cardPrix = parseFloat(card.getAttribute('data-prix') || 0);
                const cardPays = card.getAttribute('data-pays') || '';
                const cardTitle = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
                const cardDescription = card.querySelector('.card-description')?.textContent.toLowerCase() || '';
                const cardLocation = `${cardVille} ${cardPays}`.toLowerCase();
                
                let show = true;
                
                if (pays !== 'all' && cardPays !== pays) show = false;
                if (ville !== 'all' && cardVille !== ville) show = false;
                if (type !== 'all' && cardType !== type) show = false;
                if (cardPrix > parseFloat(maxPrice)) show = false;
                if (searchText && !cardTitle.includes(searchText) && 
                    !cardDescription.includes(searchText) && !cardLocation.includes(searchText)) show = false;
                
                card.style.display = show ? 'block' : 'none';
                if (show) visibleCount++;
            });
            
            const resultsCount = document.getElementById('resultsCount');
            if (resultsCount) {
                resultsCount.textContent = `${visibleCount} propriété${visibleCount !== 1 ? 's' : ''} disponible${visibleCount !== 1 ? 's' : ''}`;
            }
        }
        
        if (applyFiltersBtn) applyFiltersBtn.addEventListener('click', filterHebergements);
        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', filterHebergements);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') filterHebergements();
            });
        }
        
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function() {
                document.getElementById('filterPays').value = 'all';
                document.getElementById('filterVille').value = 'all';
                document.getElementById('filterType').value = 'all';
                document.getElementById('priceRange').value = 500000;
                if (searchInput) searchInput.value = '';
                updatePriceText();
                filterHebergements();
            });
        }
        
        if (resetSearchBtn) {
            resetSearchBtn.addEventListener('click', function() {
                document.getElementById('filterPays').value = 'all';
                document.getElementById('filterVille').value = 'all';
                document.getElementById('filterType').value = 'all';
                document.getElementById('priceRange').value = 500000;
                if (searchInput) searchInput.value = '';
                updatePriceText();
                filterHebergements();
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('view-details-btn')) {
                const hebergementId = e.target.getAttribute('data-id');
                showHebergementDetails(hebergementId);
            }
        });

        const closeDetailsModalBtn = document.getElementById('closeDetailsModal');
        const detailsModal = document.getElementById('detailsModal');
        const closeModalBtn = document.getElementById('closeModal');
        const cancelReservationBtn = document.getElementById('cancelReservation');
        const reservationModal = document.getElementById('reservationModal');
        const arriveeInput = document.getElementById('arrivee');
        const departInput = document.getElementById('depart');
        
        if (closeDetailsModalBtn && detailsModal) {
            closeDetailsModalBtn.addEventListener('click', () => detailsModal.classList.remove('show'));
            detailsModal.addEventListener('click', (e) => {
                if (e.target === detailsModal) detailsModal.classList.remove('show');
            });
        }
        
        if (closeModalBtn && reservationModal) {
            closeModalBtn.addEventListener('click', () => reservationModal.classList.remove('show'));
            reservationModal.addEventListener('click', (e) => {
                if (e.target === reservationModal) reservationModal.classList.remove('show');
            });
        }
        
        if (cancelReservationBtn) {
            cancelReservationBtn.addEventListener('click', () => reservationModal.classList.remove('show'));
        }
        
        if (arriveeInput && departInput) {
            arriveeInput.addEventListener('change', updateReservationSummary);
            departInput.addEventListener('change', updateReservationSummary);
        }
    });

    window.initMap = initMap;
</script>

<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCs8qQbxU6XAt3e2LUGTbpCcFtNHjUIzls&callback=initMap">
</script>

</body>
</html>