@extends('layouts.app')

@section('page_title', $galleries->name)

@section('content')
    <a href="{{ route('video.create', $galleries->id) }}" class="btn btn-sm btn-success mb-3"><i class="fas fa-plus-circle fa-fw align-middle"></i> Video</a>

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection