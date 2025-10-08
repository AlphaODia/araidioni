@extends('layouts.client.app')

@section('title', 'Suivi de Colis')

@section('content')
<div class="min-h-screen bg-gray-50 py-12" style="padding-top: 100px;">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
         
            <h1 class="text-2xl font-bold text-blue-700 mb-6">Suivi de colis</h1>
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('colis.search') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="tracking_number" class="block text-sm font-medium text-gray-700">
                        Numéro de suivi
                    </label>
                    <input type="text" id="tracking_number" name="tracking_number" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Entrez votre numéro de suivi" required>
                </div>
                
                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Suivre mon colis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection