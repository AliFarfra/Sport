@extends('layouts.app')

@section('content')
<div class="container my-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Cours</h1>
        <a href="{{ route('cours.create') }}" class="btn btn-primary">Create New Course</a>
    </div>

    @if ($cours->isEmpty())
        <p>No courses found.</p>
    @else
        <div class="row">
            @foreach ($cours as $course)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('cours.show', $course) }}">{{ $course->nom }}</a></h5>
                            <p class="card-text">Price: {{ $course->prix }} €</p>
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('cours.destroy', $course) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?');">Delete</button>
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