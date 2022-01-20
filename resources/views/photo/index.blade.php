@extends('layouts.app')

@section('page_title', $galleries->name)

@section('content')
    <a href="{{ route('photo.create', $galleries->id) }}" class="btn btn-success mb-3"><i
            class="fas fa-plus-circle fa-fw"></i> Foto</a>
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

    @forelse ($galleries->galleries->chunk(3) as $photo)
        <div class="row">
            @foreach ($photo as $item)
                <div class="col-4">
                    <div class="card border-secondary shadow">
                        <div class="product-wrap">
                            <img src="{{ asset('photo/' . $item->url_gallery) }}" class="card-img-top img-fluid"
                                alt="foto" id="photo">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <div class="d-flex">
                                    <a href="{{ asset('photo/' . $item->url_gallery) }}"
                                        class="btn btn-outline-info me-1" target="_blank">
                                        <i class="fas fa-images fa-fw"></i>
                                    </a>
                                    <a href="{{ route('photo.show', ['gallery' => $galleries->id, 'photo' => $item->id]) }}"
                                        class="btn btn-outline-primary me-1">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('photo.edit', ['gallery' => $galleries->id, 'photo' => $item->id]) }}"
                                        class="btn btn-outline-warning me-1">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                    <a href="#" onclick="return confirm('Apakah anda yakin ingin menghapus foto ini ??');">
                                        <form
                                            action="{{ route('photo.destroy', ['gallery' => $galleries->id, 'photo' => $item->id]) }}"
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
                        <div class="card-body">
                            <div class="card-text">
                                {!! Str::limit(strip_tags($item->description), 50) !!}
                            </div>
                        </div>
                        <div class="card-footer bg-transparent py-1">
                            <span><strong>Author: {{ $item->user->name }}</strong></span>
                            <br>
                            <small class="text-mutes">Updated at :{{ $item->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center">Belum ada foto</p>
    @endforelse
@endsection

@push('script')
    <script>
        var elem = document.getElementById("photo");

        function openFullscreen() {
            elem.classList.add('active');
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE11 */
                elem.msRequestFullscreen();
            }
        }
    </script>
@endpush
