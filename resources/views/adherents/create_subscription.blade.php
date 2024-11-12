@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Add Subscription for {{ $adherent->nom }} {{ $adherent->prenom }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (is_null($adherent->user))
        <div class="alert alert-danger">
            This adherent does not have an associated user. Please create a user first.
        </div>
        <a href="{{ route('adherents.index') }}" class="btn btn-secondary">Back to Adherents</a>
    @else
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subscriptions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="adherent_id" value="{{ $adherent->id }}">
            <input type="hidden" name="user_id" value="{{ $adherent->user->id }}">

            <div class="mb-3">
                <label for="pack_id" class="form-label">Select Pack</label>
                <select name="pack_id" id="pack_id" class="form-select" required>
                    <option value="">Choose a pack...</option>
                    @foreach ($packs as $pack)
                        <option value="{{ $pack->id }}">{{ $pack->nom }}</option>
                    @endforeach
                </select>
                @error('pack_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Select Courses</label>
                @foreach ($cours as $cour)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="cours_id[]" id="cours_{{ $cour->id }}" value="{{ $cour->id }}">
                        <label class="form-check-label" for="cours_{{ $cour->id }}">
                            {{ $cour->nom }}
                        </label>
                    </div>
                @endforeach
                @error('cours_id.*')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Select one or more courses.
                </small>
            </div>

            <button type="submit" class="btn btn-primary">Add Subscription</button>
            <a href="{{ route('adherents.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    @endif
</div>
@endsection