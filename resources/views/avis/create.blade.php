@extends('layouts.app')

@section('title', 'Donner votre avis')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Donnez votre avis sur nos services</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('avis.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom complet *</label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}" 
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" 
                                       class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" 
                                       name="telephone" 
                                       value="{{ old('telephone') }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="service_type" class="form-label">Type de service *</label>
                                <select class="form-select @error('service_type') is-invalid @enderror" 
                                        id="service_type" 
                                        name="service_type" 
                                        required>
                                    <option value="">Choisir un service</option>
                                    <option value="voyage" {{ old('service_type') == 'voyage' ? 'selected' : '' }}>Voyage</option>
                                    <option value="colis" {{ old('service_type') == 'colis' ? 'selected' : '' }}>Colis</option>
                                    <option value="hebergement" {{ old('service_type') == 'hebergement' ? 'selected' : '' }}>Hébergement</option>
                                    <option value="transfert" {{ old('service_type') == 'transfert' ? 'selected' : '' }}>Transfert d'argent</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Note (sur 5)</label>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="rating" 
                                               id="rating{{ $i }}" 
                                               value="{{ $i }}"
                                               {{ old('rating') == $i ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rating{{ $i }}">
                                            {{ $i }} étoile{{ $i > 1 ? 's' : '' }}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Votre message *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="5" 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Soumettre mon avis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection