@extends('layouts.app')

@section('title', 'Avis des clients')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Avis de nos clients</h2>
    
    @if(empty($avis))
        <div class="alert alert-info">
            Aucun avis pour le moment.
        </div>
    @else
        <div class="row">
            @foreach($avis as $id => $avisItem)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $avisItem['nom'] }}</h5>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= ($avisItem['rating'] ?? 5) ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Service: {{ ucfirst($avisItem['service_type']) }}
                        </h6>
                        <p class="card-text">{{ $avisItem['message'] }}</p>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($avisItem['created_at'])->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection