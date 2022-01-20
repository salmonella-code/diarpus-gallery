@extends('layouts.app')

@section('page_title', $photo->field->name)

@section('content')
<div class="d-flex mb-3">
    <a href="{{ route('photo.index', $photo->field->id) }}" class="btn btn-sm btn-success me-3">
        <i class="fas fa-arrow-alt-circle-left fa-fw align-middle"></i> <span class="align-middle">Kembali</span>
    </a>

    <a href="{{ route('photo.edit', ['gallery'=>$gallery, 'photo'=>$photo->id]) }}" class="btn btn-sm btn-warning me-3"><i class="fas fa-edit fa-fw align-middle"></i></a>

    <a href="#" onclick="return confirm('Apakah anda yakin ingin menghapus foto ini ??');">
        <form
            action="{{ route('photo.destroy', ['gallery' => $gallery, 'photo' => $photo->id]) }}"
            method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash fa-fw"></i>
            </button>
        </form>
    </a>
</div>
    <div class="card border-secondary shadow">
        <div class="product-wrap-lg">
            <img src="{{ asset('photo/' . $photo->url_gallery) }}" class="card-img-top img-fluid" alt="foto"
                id="photo">
            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                <div class="d-flex">
                    <a href="{{ asset('photo/' . $photo->url_gallery) }}" class="btn btn-outline-info me-1"
                        target="_blank"><i class="fas fa-images fa-fw"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-text">
                {!! $photo->description !!}
            </div>
        </div>
        <div class="card-footer bg-transparent py-1">
            <span><strong>Author: {{ $photo->user->name }}</strong></span>
            <br>
            <small class="text-mutes">Updated at :{{ $photo->created_at->format('d M Y') }}</small>
        </div>
    </div>
@endsection
