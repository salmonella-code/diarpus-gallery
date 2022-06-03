@extends('layouts.app')

@section('page_title', $video->field->name)

@section('content')
<div class="d-flex mb-3">
    <a href="{{ route('video.index', $video->field->slug) }}" class="btn btn-sm btn-success me-3">
        <i class="fas fa-arrow-alt-circle-left fa-fw align-middle"></i> <span class="align-middle">Kembali</span>
    </a>

    <a href="{{ route('video.edit', ['field'=>$gallery, 'video'=>$video->id]) }}" class="btn btn-sm btn-warning me-3"><i class="fas fa-edit fa-fw align-middle"></i></a>

    <a href="#" onclick="return confirm('Apakah anda yakin ingin menghapus video ini ??');">
        <form action="{{ route('video.destroy', ['field' => $gallery, 'video' => $video->id]) }}" method="post">
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
        <div class="row row-cols-1 row-cols-sm-2 justify-content-between">
            @foreach ($video->files as $key => $item )
            <video class="col mb-3" controls="controls" preload="metadata">
                <source src="{{ asset('field/'.$gallery.'/video/'.$item->folder.'/'.$item->name) }}" type="video/mp4">
            </video>  
            @endforeach
        </div>
        <h5><strong>{{ $video->name }}</strong></h5>
        <div class="card-text">
            {!! $video->description !!}
        </div>
    </div>
    <div class="card-footer bg-transparent py-1 d-flex flex-column">
        <span><strong>Author: {{ $video->user->name }}</strong></span>
        <small class="text-mutes">Updated at :{{ $video->activity->format('d M Y') }}</small>
    </div>
</div>
@endsection
