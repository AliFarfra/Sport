@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Create New Administrateur</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('administrateurs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom') }}" required>
        </div>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de Début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required>
        </div>
        <div class="mb-3">
            <label for="matricule" class="form-label">Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" value="{{ old('matricule') }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type" required>
                <option value="">Select Type</option>
                <option value="secretaire">Secrétaire</option>
                <option value="coach">Coach</option>
                <option value="femme_de_menage">Femme de Ménage</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Administrateur</button>
        <a href="{{ route('administrateurs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection