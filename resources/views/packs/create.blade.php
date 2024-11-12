@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Pack</h1>

    <form action="{{ route('packs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" name="prix" id="prix" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="nombre_jours">Nombre de Jours</label>
            <input type="number" name="nombre_jours" id="nombre_jours" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection