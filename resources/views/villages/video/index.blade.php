@extends('layouts.app')

@section('page_title', strtolower($gallery->name))

@section('content')
    <a href="{{ route('village.video.create', $gallery->slug) }}" class="btn btn-success mb-3"><i
            class="fas fa-plus-circle fa-fw"></i> video</a>
    @include('layouts.partials.alert')

    @forelse ($gallery->videos->chunk(3) as $video)
        <div class="row">
            @foreach ($video as $item)
                <div class="col-12 col-sm-4">
                    <div class="card border-secondary shadow">
                        <div class="product-wrap">
                            <video width="400" controls="controls" preload="metadata" class="video-boder-radius">
                                @if(!$item->files->isEmpty())
                                    <source src="{{ asset('village/'.$gallery->slug.'/video/'.$item->files[0]->folder.'/'.$item->files[0]->name) }}" type="video/mp4">
                                @endif
                            </video>                              
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <div class="d-flex">
                                    <a href="{{ route('village.video.download', ['village' => $gallery->slug, 'video' => $item->id]) }}"
                                        class="btn btn-outline-info me-1" target="_blank">
                                        <i class="fas fa-download fa-fw"></i>
                                    </a>
                                    <a href="{{ route('village.video.show', ['village' => $gallery->slug, 'video' => $item->id]) }}"
                                        class="btn btn-outline-primary me-1">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('village.video.edit', ['village' => $gallery->slug, 'video' => $item->id]) }}"
                                        class="btn btn-outline-warning me-1">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                    <a href="#" onclick="return confirm('Apakah anda yakin ingin menghapus video ini ??');">
                                        <form
                                            action="{{ route('village.video.destroy', ['village' => $gallery->slug, 'video' => $item->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </button>
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header py-2">
                            <h5><strong>{{ $item->name }}</strong></h5>
                        </div>
                        <div class="card-footer bg-transparent py-1">
                            <span><strong>Author: {{ $item->user->name }}</strong></span>
                            <br>
                            <small class="text-mutes">Updated at :{{ $item->activity->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center">Belum ada video</p>
    @endforelse
@endsection
