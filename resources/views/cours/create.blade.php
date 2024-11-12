@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Course</h1>
    <form action="{{ route('cours.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Course Name</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prix">Price</label>
            <input type="number" class="form-control" id="prix" name="prix" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Course</button>
        <a href="{{ route('cours.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection