@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Administrateurs</h1>
        <a href="{{ route('administrateurs.create') }}" class="btn btn-primary">Create New Administrateur</a>
    </div>

    @if ($administrateurs->isEmpty())
        <p>No administrateurs found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Début</th>
                    <th>Matricule</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($administrateurs as $administrateur)
                    <tr>
                        <td>{{ $administrateur->id }}</td>
                        <td>{{ $administrateur->nom }}</td>
                        <td>{{ $administrateur->prenom }}</td>
                        <td>{{ $administrateur->date_debut->format('d/m/Y') }}</td>
                        <td>{{ $administrateur->matricule }}</td>
                        <td>{{ $administrateur->type }}</td>
                        <td>
                            <form action="{{ route('administrateurs.destroy', $administrateur) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this administrateur?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection