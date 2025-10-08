<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi de Colis - AriDioni Logistique</title>
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
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #7c3aed;
            --light: #f3f4f6;
            --dark: #1f2937;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #1f2937;
            min-height: 100vh;
            transition: all 0.5s ease;
        }
        
        body.no-glass-effect {
            background: #f3f4f6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Effet Liquid Glass */
        .liquid-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2), 
                        inset 0 4px 20px rgba(255, 255, 255, 0.3);
        }
        
        .liquid-glass-dark {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
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
        
        /* Main Content Styles */
        .min-h-screen {
            min-height: 100vh;
        }
        
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }
        
        .from-blue-600 {
            --tw-gradient-from: #2563eb;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(37, 99, 235, 0));
        }
        
        .to-blue-800 {
            --tw-gradient-to: #1e40af;
        }
        
        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }
        
        .md\:text-5xl {
            font-size: 3rem;
            line-height: 1;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .text-white {
            color: white;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }
        
        .text-blue-100 {
            color: #dbeafe;
        }
        
        .max-w-3xl {
            max-width: 48rem;
        }
        
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Liquid Glass Toggle Button */
        .fixed {
            position: fixed;
        }
        
        .top-20 {
            top: 5rem;
        }
        
        .right-4 {
            right: 1rem;
        }
        
        .z-50 {
            z-index: 50;
        }
        
        .p-3 {
            padding: 0.75rem;
        }
        
        .rounded-full {
            border-radius: 9999px;
        }
        
        .bg-white {
            background-color: white;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        .duration-300 {
            transition-duration: 300ms;
        }
        
        .h-6 {
            height: 1.5rem;
        }
        
        .w-6 {
            width: 1.5rem;
        }
        
        .text-blue-600 {
            color: #2563eb;
        }
        
        .hidden {
            display: none;
        }
        
        /* Progress Steps */
        .mb-12 {
            margin-bottom: 3rem;
        }
        
        .flex {
            display: flex;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .relative {
            position: relative;
        }
        
        .absolute {
            position: absolute;
        }
        
        .top-1\/2 {
            top: 50%;
        }
        
        .h-1 {
            height: 0.25rem;
        }
        
        .bg-gray-200 {
            background-color: #e5e7eb;
        }
        
        .w-full {
            width: 100%;
        }
        
        .-z-10 {
            z-index: -10;
        }
        
        .bg-blue-600 {
            background-color: #2563eb;
        }
        
        .w-1\/3 {
            width: 33.333333%;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .w-10 {
            width: 2.5rem;
        }
        
        .h-10 {
            height: 2.5rem;
        }
        
        .rounded-full {
            border-radius: 9999px;
        }
        
        .text-white {
            color: white;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-center {
            justify-content: center;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        .text-blue-600 {
            color: #2563eb;
        }
        
        /* Form Styles */
        .bg-white {
            background-color: white;
        }
        
        .rounded-xl {
            border-radius: 0.75rem;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .overflow-hidden {
            overflow: hidden;
        }
        
        .p-8 {
            padding: 2rem;
        }
        
        .border-b {
            border-bottom-width: 1px;
        }
        
        .border-gray-200 {
            border-color: #e5e7eb;
        }
        
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        
        .text-gray-800 {
            color: #1f2937;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .grid {
            display: grid;
        }
        
        .md\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .gap-8 {
            gap: 2rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
        
        .block {
            display: block;
        }
        
        .text-gray-700 {
            color: #374151;
        }
        
        .w-full {
            width: 100%;
        }
        
        .border {
            border-width: 1px;
        }
        
        .border-gray-300 {
            border-color: #d1d5db;
        }
        
        .rounded-md {
            border-radius: 0.375rem;
        }
        
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .focus\:ring-blue-500:focus {
            --tw-ring-color: #3b82f6;
            box-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        }
        
        .focus\:border-blue-500:focus {
            border-color: #3b82f6;
        }
        
        .mt-1 {
            margin-top: 0.25rem;
        }
        
        .text-red-600 {
            color: #dc2626;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .mt-8 {
            margin-top: 2rem;
        }
        
        .justify-end {
            justify-content: flex-end;
        }
        
        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8;
        }
        
        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .transition-colors {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        .hidden {
            display: none;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .text-blue-600 {
            color: #2563eb;
        }
        
        .hover\:text-blue-800:hover {
            color: #1e40af;
        }
        
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
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
        
        /* Styles pour l'effet Liquid Glass */
        .liquid-glass-enabled {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .liquid-glass-container.liquid-glass-enabled .step.active div {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .liquid-glass-container.liquid-glass-enabled .step.active span {
            color: white !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled input,
        .liquid-glass-container.liquid-glass-enabled select,
        .liquid-glass-container.liquid-glass-enabled textarea {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled input::placeholder,
        .liquid-glass-container.liquid-glass-enabled textarea::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled label {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled h2,
        .liquid-glass-container.liquid-glass-enabled h3 {
            color: white !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled .bg-gray-50 {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .liquid-glass-container.liquid-glass-enabled .bg-blue-50 {
            background: rgba(59, 130, 246, 0.2) !important;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        
        .liquid-glass-container.liquid-glass-enabled .text-gray-600,
        .liquid-glass-container.liquid-glass-enabled .text-gray-700 {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .liquid-glass-container.liquid-glass-enabled .border-gray-200,
        .liquid-glass-container.liquid-glass-enabled .border-gray-300 {
            border-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .md\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .footer-logo {
                justify-content: center;
            }
            
            .footer-social {
                justify-content: center;
            }
            
            .footer-contact-item {
                justify-content: center;
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
                        <!-- Bouton "Mon compte" avec effet Liquid Glass -->
                        <div class="liquid-glass" style="border-radius: 0.5rem; padding: 0.5rem 1.5rem;">
                            <a href="{{ route('client.dashboard') }}" class="text-white font-medium transition">
                                Mon compte
                            </a>
                        </div>
                    @else
                        <!-- Bouton "Inscription" avec effet Liquid Glass -->
                        <div class="liquid-glass" style="border-radius: 0.5rem; padding: 0.5rem 1.5rem;">
                            <a href="{{ route('register') }}" class="text-white font-medium transition">
                                Inscription
                            </a>
                        </div>
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
                            <!-- Bouton "Inscription" avec effet Liquid Glass pour mobile -->
                            <div class="liquid-glass" style="border-radius: 0.5rem; padding: 0.5rem 1rem; text-align: center;">
                                <a href="{{ route('register') }}" class="text-white font-medium transition">
                                    Inscription
                                </a>
                            </div>
                        @endguest
                        @auth
                            <!-- Bouton "Mon compte" avec effet Liquid Glass pour mobile -->
                            <div class="liquid-glass" style="border-radius: 0.5rem; padding: 0.5rem 1rem; text-align: center;">
                                <a href="{{ route('client.dashboard') }}" class="text-white font-medium transition">
                                    Mon compte
                                </a>
                            </div>
                        @endauth
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="padding-top: 100px;">
        <div class="min-h-screen bg-gray-50" id="main-container">
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16" id="hero-section">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Envoi de Colis Professionnel</h1>
                    <p class="text-xl text-blue-100 max-w-3xl mx-auto">Envoyez vos colis entre la Guinée et le Sénégal en toute sécurité avec notre service de suivi en temps réel</p>
                </div>
            </div>

            <!-- Liquid Glass Toggle Button -->
            <div class="fixed top-20 right-4 z-50">
                <button id="liquid-glass-toggle" class="p-3 rounded-full bg-white shadow-lg hover:shadow-xl transition-all duration-300">
                    <svg id="glass-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    <svg id="no-glass-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="container mx-auto px-4 py-12">
                <!-- Progress Steps -->
                <div class="mb-12">
                    <div class="flex justify-between relative">
                        <div class="absolute top-1/2 h-1 bg-gray-200 w-full -z-10"></div>
                        <div class="absolute top-1/2 h-1 bg-blue-600 w-1/3 -z-10" id="progress-bar"></div>
                        
                        @foreach(['Informations', 'Options', 'Paiement', 'Confirmation'] as $index => $step)
                        <div class="step flex flex-col items-center {{ $index === 0 ? 'active' : '' }}">
                            <div class="w-10 h-10 rounded-full {{ $index === 0 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center mb-2">
                                <span>{{ $index + 1 }}</span>
                            </div>
                            <span class="text-sm font-medium {{ $index === 0 ? 'text-blue-600' : 'text-gray-600' }}">{{ $step }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Sections -->
                <form id="colis-form" method="POST" action="{{ route('colis.store') }}" class="bg-white rounded-xl shadow-lg overflow-hidden liquid-glass-container">
                    @csrf
                    
                    <!-- Step 1: Sender & Receiver Info -->
                    <div class="p-8 border-b border-gray-200" id="step-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informations sur l'expédition</h2>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Sender Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    Expéditeur
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="sender_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet*</label>
                                        <input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" 
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        @error('sender_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="sender_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse*</label>
                                        <input type="text" id="sender_address" name="sender_address" value="{{ old('sender_address') }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        @error('sender_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="sender_city" class="block text-sm font-medium text-gray-700 mb-1">Ville*</label>
                                            <select id="sender_city" name="sender_city" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="">Sélectionner</option>
                                                <option value="Conakry" {{ old('sender_city') == 'Conakry' ? 'selected' : '' }}>Conakry</option>
                                                <option value="Labé" {{ old('sender_city') == 'Labé' ? 'selected' : '' }}>Labé</option>
                                                <option value="Kankan" {{ old('sender_city') == 'Kankan' ? 'selected' : '' }}>Kankan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="sender_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
                                            <input type="tel" id="sender_phone" name="sender_phone" value="{{ old('sender_phone') }}"
                                                   class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="sender_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" id="sender_email" name="sender_email" value="{{ old('sender_email') }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Receiver Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-user-tag text-sm"></i>
                                    </div>
                                    Destinataire
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet*</label>
                                        <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        @error('recipient_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="recipient_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse*</label>
                                        <input type="text" id="recipient_address" name="recipient_address" value="{{ old('recipient_address') }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        @error('recipient_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="recipient_city" class="block text-sm font-medium text-gray-700 mb-1">Ville*</label>
                                            <select id="recipient_city" name="recipient_city" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                <option value="">Sélectionner</option>
                                                <option value="Dakar" {{ old('recipient_city') == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                                                <option value="Thiès" {{ old('recipient_city') == 'Thiès' ? 'selected' : '' }}>Thiès</option>
                                                <option value="Saint-Louis" {{ old('recipient_city') == 'Saint-Louis' ? 'selected' : '' }}>Saint-Louis</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
                                            <input type="tel" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone') }}"
                                                   class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="recipient_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" id="recipient_email" name="recipient_email" value="{{ old('recipient_email') }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors next-step">
                                Suivant <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Package Details -->
                    <div class="p-8 border-b border-gray-200 hidden" id="step-2">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Détails du colis</h2>
                        
                        <div class="grid md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-box-open text-sm"></i>
                                    </div>
                                    Caractéristiques
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="package_type" class="block text-sm font-medium text-gray-700 mb-1">Type de colis*</label>
                                        <select id="package_type" name="package_type" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="">Sélectionner</option>
                                            <option value="Document" {{ old('package_type') == 'Document' ? 'selected' : '' }}>Document</option>
                                            <option value="Paquet" {{ old('package_type') == 'Paquet' ? 'selected' : '' }}>Paquet</option>
                                            <option value="Carton" {{ old('package_type') == 'Carton' ? 'selected' : '' }}>Carton</option>
                                            <option value="Palette" {{ old('package_type') == 'Palette' ? 'selected' : '' }}>Palette</option>
                                        </select>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)*</label>
                                            <input type="number" step="0.1" id="weight" name="weight" value="{{ old('weight') }}"
                                                   class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('weight')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Dimensions (cm)</label>
                                            <div class="flex gap-2">
                                                <input type="number" placeholder="L" name="length" value="{{ old('length') }}"
                                                       class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                <input type="number" placeholder="l" name="width" value="{{ old('width') }}"
                                                       class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                                <input type="number" placeholder="H" name="height" value="{{ old('height') }}"
                                                       class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="declared_value" class="block text-sm font-medium text-gray-700 mb-1">Valeur déclarée (GNF)</label>
                                        <input type="number" id="declared_value" name="declared_value" value="{{ old('declared_value') }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description du contenu*</label>
                                        <textarea id="description" name="description" 
                                                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" rows="3" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-calendar-alt text-sm"></i>
                                    </div>
                                    Options d'expédition
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-1">Date d'enlèvement*</label>
                                        <input type="date" id="pickup_date" name="pickup_date" value="{{ old('pickup_date', date('Y-m-d')) }}"
                                               class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Service*</label>
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <input type="radio" id="standard" name="service_type" value="standard" 
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500" 
                                                       {{ old('service_type', 'standard') == 'standard' ? 'checked' : '' }}>
                                                <label for="standard" class="ml-2 block text-sm text-gray-700">
                                                    Standard (3-5 jours) - 250 000 GNF
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" id="express" name="service_type" value="express"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                       {{ old('service_type') == 'express' ? 'checked' : '' }}>
                                                <label for="express" class="ml-2 block text-sm text-gray-700">
                                                    Express (1-2 jours) - 400 000 GNF
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Options supplémentaires</label>
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="insurance" name="insurance" value="1"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                       {{ old('insurance') ? 'checked' : '' }}>
                                                <label for="insurance" class="ml-2 block text-sm text-gray-700">
                                                    Assurance (+2% de la valeur déclarée)
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="fragile" name="fragile" value="1"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                       {{ old('fragile') ? 'checked' : '' }}>
                                                <label for="fragile" class="ml-2 block text-sm text-gray-700">
                                                    Colis fragile (+50 000 GNF)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-between">
                            <button type="button" class="text-blue-600 hover:text-blue-800 px-4 py-2 rounded-md transition-colors prev-step">
                                <i class="fas fa-arrow-left mr-2"></i> Retour
                            </button>
                            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors next-step">
                                Suivant <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Payment -->
                    <div class="p-8 border-b border-gray-200 hidden" id="step-3">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Paiement</h2>
                        
                        <div class="grid md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Récapitulatif</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Expédition Standard</span>
                                        <span class="font-medium">250 000 GNF</span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Assurance</span>
                                        <span class="font-medium" id="insurance-cost">0 GNF</span>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Frais de manutention</span>
                                        <span class="font-medium">25 000 GNF</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2 mt-2">
                                        <div class="flex justify-between">
                                            <span class="font-semibold">Total</span>
                                            <span class="font-bold text-blue-600" id="total-cost">275 000 GNF</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                                    <h4 class="font-semibold text-blue-800 mb-2">Numéro de suivi</h4>
                                    <p class="text-blue-600 font-mono bg-white p-2 rounded" id="tracking-number-preview">AD{{ strtoupper(uniqid()) }}</p>
                                    <p class="text-sm text-gray-600 mt-2">Vous recevrez ce numéro par email après confirmation du paiement.</p>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Méthode de paiement</h3>
                                
                                <div class="space-y-4">
                                    <div class="border border-gray-300 rounded-lg p-4 hover:border-blue-500 transition-colors">
                                        <div class="flex items-center">
                                            <input type="radio" id="orange-money" name="payment_method" value="orange_money" 
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                                            <label for="orange-money" class="ml-2 block text-sm text-gray-700 flex items-center">
                                                <img src="https://www.orange-money.com/static/img/logo-orange-money.png" alt="Orange Money" class="h-6 ml-2">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border border-gray-300 rounded-lg p-4 hover:border-blue-500 transition-colors">
                                        <div class="flex items-center">
                                            <input type="radio" id="wave" name="payment_method" value="wave"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                            <label for="wave" class="ml-2 block text-sm text-gray-700 flex items-center">
                                                <img src="https://www.wave.com/wp-content/uploads/2021/09/wave-logo.svg" alt="Wave" class="h-6 ml-2">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border border-gray-300 rounded-lg p-4 hover:border-blue-500 transition-colors">
                                        <div class="flex items-center">
                                            <input type="radio" id="bank-transfer" name="payment_method" value="bank_transfer"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                            <label for="bank-transfer" class="ml-2 block text-sm text-gray-700">
                                                Virement bancaire
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="border border-gray-300 rounded-lg p-4 hover:border-blue-500 transition-colors">
                                        <div class="flex items-center">
                                            <input type="radio" id="cash" name="payment_method" value="cash"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                            <label for="cash" class="ml-2 block text-sm text-gray-700">
                                                Paiement en agence
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-between">
                            <button type="button" class="text-blue-600 hover:text-blue-800 px-4 py-2 rounded-md transition-colors prev-step">
                                <i class="fas fa-arrow-left mr-2"></i> Retour
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors">
                                Payer maintenant <i class="fas fa-lock ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Step 4: Confirmation (Hidden initially) -->
                <div class="p-8 text-center hidden" id="step-4">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check text-3xl"></i>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Commande confirmée !</h2>
                        <p class="text-gray-600 mb-6">Votre envoi de colis a été enregistré avec succès.</p>
                        
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold text-blue-800 mb-2">Numéro de suivi</h4>
                            <p class="text-blue-600 font-mono text-lg bg-white p-2 rounded" id="final-tracking-number">AD{{ strtoupper(uniqid()) }}</p>
                            <p class="text-sm text-gray-600 mt-2">Vous recevrez une confirmation par email avec les détails.</p>
                        </div>
                        
                        <div class="flex justify-center gap-4">
                            <a href="#" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-50 transition-colors">
                                <i class="fas fa-print mr-2"></i> Imprimer
                            </a>
                            <a href="{{ route('colis.track') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors">
                                <i class="fas fa-box-open mr-2"></i> Suivre mon colis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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

<!-- JavaScript for multi-step form and Liquid Glass effect -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = document.querySelectorAll('.step');
        const formSteps = document.querySelectorAll('[id^="step-"]');
        const progressBar = document.getElementById('progress-bar');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const form = document.getElementById('colis-form');
        const toggleButton = document.getElementById('liquid-glass-toggle');
        const glassIcon = document.getElementById('glass-icon');
        const noGlassIcon = document.getElementById('no-glass-icon');
        const mainContainer = document.getElementById('main-container');
        const heroSection = document.getElementById('hero-section');
        const liquidGlassContainers = document.querySelectorAll('.liquid-glass-container');
        let currentStep = 1;
        let liquidGlassEnabled = false;
        
        // Toggle Liquid Glass effect
        toggleButton.addEventListener('click', function() {
            liquidGlassEnabled = !liquidGlassEnabled;
            
            if (liquidGlassEnabled) {
                // Activer l'effet Liquid Glass
                mainContainer.classList.add('liquid-glass-enabled');
                heroSection.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                liquidGlassContainers.forEach(container => {
                    container.classList.add('liquid-glass-enabled');
                });
                glassIcon.classList.add('hidden');
                noGlassIcon.classList.remove('hidden');
            } else {
                // Désactiver l'effet Liquid Glass
                mainContainer.classList.remove('liquid-glass-enabled');
                heroSection.style.background = '';
                liquidGlassContainers.forEach(container => {
                    container.classList.remove('liquid-glass-enabled');
                });
                glassIcon.classList.remove('hidden');
                noGlassIcon.classList.add('hidden');
            }
        });
        
        // Calculate costs
        function calculateCosts() {
            const serviceType = document.querySelector('input[name="service_type"]:checked').value;
            const declaredValue = parseFloat(document.getElementById('declared_value').value) || 0;
            const insuranceChecked = document.getElementById('insurance').checked;
            const fragileChecked = document.getElementById('fragile').checked;
            
            let baseCost = serviceType === 'express' ? 400000 : 250000;
            let insuranceCost = insuranceChecked ? declaredValue * 0.02 : 0;
            let fragileCost = fragileChecked ? 50000 : 0;
            let handlingCost = 25000;
            
            document.getElementById('insurance-cost').textContent = insuranceCost.toLocaleString('fr-FR') + ' GNF';
            
            const totalCost = baseCost + insuranceCost + fragileCost + handlingCost;
            document.getElementById('total-cost').textContent = totalCost.toLocaleString('fr-FR') + ' GNF';
        }
        
        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    currentStep++;
                    updateForm();
                    
                    // Update tracking number preview
                    if (currentStep === 3) {
                        document.getElementById('final-tracking-number').textContent = 
                            document.getElementById('tracking-number-preview').textContent;
                    }
                    
                    // Calculate costs when reaching payment step
                    if (currentStep === 3) {
                        calculateCosts();
                    }
                }
            });
        });
        
        // Previous button click handler
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentStep--;
                updateForm();
            });
        });
        
        // Form submission handler
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...';
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                currentStep++;
                updateForm();
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }, 1500);
        });
        
        // Validate current step before proceeding
        function validateStep(step) {
            let isValid = true;
            
            // Validate step 1
            if (step === 1) {
                const requiredFields = [
                    'sender_name', 'sender_address', 'sender_city', 'sender_phone',
                    'recipient_name', 'recipient_address', 'recipient_city', 'recipient_phone'
                ];
                
                requiredFields.forEach(field => {
                    const element = document.querySelector(`[name="${field}"]`);
                    if (!element.value.trim()) {
                        element.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        element.classList.remove('border-red-500');
                    }
                });
            }
            
            // Validate step 2
            if (step === 2) {
                const requiredFields = ['package_type', 'weight', 'description', 'pickup_date'];
                
                requiredFields.forEach(field => {
                    const element = document.querySelector(`[name="${field}"]`);
                    if (!element.value.trim()) {
                        element.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        element.classList.remove('border-red-500');
                    }
                });
            }
            
            if (!isValid) {
                alert('Veuillez remplir tous les champs obligatoires marqués d\'un astérisque (*)');
            }
            
            return isValid;
        }
        
        // Update form display based on current step
        function updateForm() {
            // Hide all steps
            formSteps.forEach(step => {
                step.classList.add('hidden');
            });
            
            // Show current step
            document.getElementById(`step-${currentStep}`).classList.remove('hidden');
            
            // Show confirmation step if form is completed
            if (currentStep > 3) {
                document.getElementById('step-4').classList.remove('hidden');
            }
            
            // Update progress bar
            progressBar.style.width = `${((currentStep - 1) / 3) * 100}%`;
            
            // Update step indicators
            steps.forEach((step, index) => {
                if (index < currentStep) {
                    step.classList.add('active');
                    step.querySelector('div').classList.remove('bg-gray-200', 'text-gray-600');
                    step.querySelector('div').classList.add('bg-blue-600', 'text-white');
                    step.querySelector('span').classList.remove('text-gray-600');
                    step.querySelector('span').classList.add('text-blue-600');
                } else {
                    step.classList.remove('active');
                    step.querySelector('div').classList.add('bg-gray-200', 'text-gray-600');
                    step.querySelector('div').classList.remove('bg-blue-600', 'text-white');
                    step.querySelector('span').classList.add('text-gray-600');
                    step.querySelector('span').classList.remove('text-blue-600');
                }
            });
        }
        
        // Event listeners for cost calculation
        document.getElementById('insurance').addEventListener('change', calculateCosts);
        document.getElementById('fragile').addEventListener('change', calculateCosts);
        document.getElementById('declared_value').addEventListener('input', calculateCosts);
        document.querySelectorAll('input[name="service_type"]').forEach(radio => {
            radio.addEventListener('change', calculateCosts);
        });
    });
</script>

</body>
</html>