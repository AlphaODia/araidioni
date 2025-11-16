@extends('layouts.client.app')

@section('title', 'Suivi de Colis')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-12">
             <h1 class="hero-title text-4xl md:text-5xl font-bold mb-4"></h1>
            <h1 class="hero-title text-4xl md:text-5xl font-bold mb-4"></h1>
            
    <div class="container mx-auto px-4">

        <!-- En-tête simple et élégant -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-6 border border-slate-200">
                <i class="fas fa-box text-blue-600 text-2xl"></i>
            </div>

            <h1 class="text-3xl font-bold text-slate-800 mb-3">Suivi de Colis</h1>
            <p class="text-slate-600 text-lg">Suivez l'état de votre colis en temps réel</p>
        </div>

        <!-- Carte principale bien visible -->
        <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
            <form action="{{ route('colis.track') }}" method="GET" class="space-y-6">
                @csrf
                
                <!-- Champ de saisie bien contrasté -->
                <div>
                    <label for="tracking_number" class="block text-sm font-semibold text-black mb-3">
                         Numéro de suivi
                    </label>
                    <div class="relative">
                        <input type="text" id="tracking_number" name="tracking_number" 
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl py-4 px-6 text-black placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg font-medium"
                            placeholder="Ex: TRK123456789"
                            required
                            autocomplete="off">
    
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-slate-400"></i>
                         </div>
                    </div>

                    <p class="text-slate-500 text-xs mt-2">
                        Entrez le numéro de suivi reçu par email
                    </p>
                </div>
                
                <!-- Bouton principal bien contrasté -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <div class="flex items-center justify-center space-x-2">
                            <i class="fas fa-search"></i>
                            <span class="text-lg">Suivre mon colis</span>
                        </div>
                    </button>
                </div>
            </form>

            <!-- Informations utiles discrètes -->
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; text-align: center;">
        
                     <!-- Bloc 1 -->
                    <div style="text-align: center;">
                    <div style="width: 40px; height: 40px; background-color: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem auto;">
                    <i class="fas fa-clock" style="color: #16a34a;"></i>
                </div>
                <p style="color: #000000; font-size: 0.8rem; font-weight: 500;">Temps réel</p>
            </div>

        <!-- Bloc 2 -->
        <div style="text-align: center;">
            <div style="width: 40px; height: 40px; background-color: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem auto;">
                <i class="fas fa-shield-alt" style="color: #2563eb;"></i>
            </div>
            <p style="color: #000000; font-size: 0.8rem; font-weight: 500;">Sécurisé</p>
        </div>

        <!-- Bloc 3 -->
        <div style="text-align: center;">
            <div style="width: 40px; height: 40px; background-color: #ede9fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem auto;">
                <i class="fas fa-globe" style="color: #7e22ce;"></i>
            </div>
            <p style="color: #000000; font-size: 0.8rem; font-weight: 500;">Global</p>
        </div>

                </div>
            </div>

        </div>

<!-- Section d'aide discrète -->
<div style="max-width: 28rem; margin: 2rem auto 0 auto;">
    <div style="background-color: #f1f5f9; border-radius: 1rem; padding: 1.5rem; border: 1px solid #cbd5e1;">
        
        <h3 style="color: #000000; font-weight: 600; margin-bottom: 0.75rem; display: flex; align-items: center; font-size: 1.1rem;">
            <i class="fas fa-question-circle" style="color: #2563eb; margin-right: 0.5rem;"></i>
            Besoin d'aide ?
        </h3>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem; color: #000000;">
            
            <p style="display: flex; align-items: center; font-size: 0.9rem;">
                <i class="fas fa-envelope" style="color: #64748b; margin-right: 0.5rem;"></i>
                contact@aridioni.com
            </p>
            
            <p style="display: flex; align-items: center; font-size: 0.9rem;">
                <i class="fas fa-phone" style="color: #64748b; margin-right: 0.5rem;"></i>
                +221 77 844 93 33
            </p>
            
        </div>
    </div>
</div>

    </div>
</div>

<style>
    /* Styles simples et efficaces */
    .bg-slate-50 {
        background-color: #f8fafc;
    }
    
    .border-slate-200 {
        border-color: #e2e8f0;
    }
    
    .border-slate-300 {
        border-color: #cbd5e1;
    }
    
    /* Animation subtile au focus */
    input:focus {
        transform: translateY(-1px);
    }
    
    /* Support pour la réduction des mouvements */
    @media (prefers-reduced-motion: reduce) {
        .transform, .transition-all {
            transition: none !important;
            transform: none !important;
        }
    }
</style>
@endsection