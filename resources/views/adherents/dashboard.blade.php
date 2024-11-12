@extends('layouts.app')

@section('content')
    <h1>Adherent Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Available Packs</h2>
    <div class="row">
        @if($packs->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning">No packs available.</div>
            </div>
        @else
            @foreach($packs as $pack)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pack->nom }}</h5>
                            <p class="card-text">Prix: {{ $pack->prix }} €</p>
                            <p class="card-text">Nombre de Jours: {{ $pack->nombre_jours }}</p>
                            <a href="{{ route('packs.show', $pack) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection