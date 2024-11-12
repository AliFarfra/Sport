@extends('layouts.app')

@section('content')
<div class="container  my-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Packs</h1>
        <a href="{{ route('packs.create') }}" class="btn btn-primary">Create New Packs</a>
    </div>

    @if ($packs->isEmpty())
        <p>No packs found.</p>
    @else
        <div class="row">
            @foreach ($packs as $pack)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('packs.show', $pack) }}">{{ $pack->nom }}</a></h5>
                            <p class="card-text">{{ $pack->description }}</p>
                            <p class="card-text">Price: {{ $pack->prix }} €</p>
                            <p class="card-text">Duration: {{ $pack->nombre_jours }} days</p>
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('packs.destroy', $pack) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pack?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection