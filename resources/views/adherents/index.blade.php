@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Adherents</h1>
        <a href="{{ route('adherents.create') }}" class="btn btn-primary">Create New Adherent</a>
    </div>

    @if ($adherents->isEmpty())
        <p>No adherents found.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>CIN</th>
                    <th>Packs</th>
                    <th>Cours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adherents as $adherent)
                    <tr>
                        <td>{{ $adherent->id }}</td>
                        <td>{{ $adherent->nom }}</td>
                        <td>{{ $adherent->prenom }}</td>
                        <td>{{ $adherent->date_naissance->format('d/m/Y') }}</td>
                        <td>{{ $adherent->cin }}</td>
                        <td>
                            @if($adherent->subscriptions->isEmpty())
                                No packs
                            @else
                                {{-- Get the first pack only --}}
                                <ul>
                                    <li>{{ $adherent->subscriptions->first()->pack->nom }}</li>
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if($adherent->subscriptions->isEmpty())
                                No cours
                            @else
                                {{-- Display all courses --}}
                                <ul>
                                    @foreach ($adherent->subscriptions as $subscription)
                                        <li>{{ optional($subscription->cours)->nom ?? 'No course' }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.createSubscription', $adherent->user->id) }}" class="btn btn-secondary btn-sm">
                                Add Subscription
                            </a>
                            <form action="{{ route('adherents.destroy', $adherent) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this adherent?');">Delete</button>
                            </form>
                            <a href="{{ route('adherents.createPayment', $adherent->user->id) }}" class="btn btn-primary btn-sm">Add Payment</a>                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection