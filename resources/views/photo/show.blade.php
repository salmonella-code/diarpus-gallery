@extends('layouts.app')

@section('page_title', $photo->field->name)

@section('content')
<div class="d-flex mb-3">
    <a href="{{ route('photo.index', $photo->field->slug) }}" class="btn btn-sm btn-success me-3">
        <i class="fas fa-arrow-alt-circle-left fa-fw align-middle"></i> <span class="align-middle">Kembali</span>
    </a>

    <a href="{{ route('photo.edit', ['field'=>$gallery, 'photo'=>$photo->id]) }}" class="btn btn-sm btn-warning me-3"><i class="fas fa-edit fa-fw align-middle"></i></a>

    <a href="#" onclick="return confirm('Apakah anda yakin ingin menghapus foto ini ??');">
        <form action="{{ route('photo.destroy', ['field' => $gallery, 'photo' => $photo->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash fa-fw"></i>
            </button>
        </form>
    </a>
</div>
<div class="card border-secondary shadow">
    <div class="card-body pb-0">

        <div id="carouselExampleControls" class="carousel carousel-dark slide shadow-sm mb-3" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($photo->files as $key => $media )
                <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                    <div class="product-wrap-lg">
                        <img src="{{ asset('field/'.$gallery.'/photo/'.$media->folder.'/'.$media->name) }}" class="card-img-top img-fluid" alt="{{ $media->name }}" id="photo">
                    </div>
                </div>
                @endforeach

            </div>
            <button class="carousel-control-prev rounded-start" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next rounded-end" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <h5><strong>{{ $photo->name }}</strong></h5>
        <div class="card-text">
            {!! $photo->description !!}
        </div>
    </div>
    <div class="card-footer bg-transparent py-1 d-flex flex-column">
        <span><strong>Author: {{ $photo->user->name }}</strong></span>
        <small class="text-mutes">Updated at :{{ $photo->activity->format('d M Y') }}</small>
    </div>
</div>
@endsection
