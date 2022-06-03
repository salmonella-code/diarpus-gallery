@extends('layouts.app')

@push('css')
    {{-- datepicker --}}
    <link rel="stylesheet" href="{{ asset('vendors/datepickers/bootstrap-datepicker.min.css') }}">
    {{-- //datepicker --}}

    {{-- filepond --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    {{-- //filepond --}}
@endpush

@section('page_title', strtolower($photo->activeVillage->name))

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('village.photo.update', ['village' => $gallery, 'photo' => $photo->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group mb-3">
                    <label for="name" class="text-capitalize">nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama" value="{{ old('name', $photo->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>"{{ $message }}"</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="text-capitalize">keterangan<span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description"
                        placeholder="Masukkan keterangan">{{ old('description', $photo->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            "{{ $message }}"
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="date" class="text-capitalize">tanggal<span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('date') is-invalid @enderror" id="date" name="date" placeholder="Masukkan tanggal" value="{{ old('date', $photo->activity->format('d-m-Y')) }}">
                    @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>"{{ $message }}"</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="path" class="text-capitalize">Foto<span class="text-danger">*</span></label><br>
                    <span class="text-muted"><i>Format yang didukung: jpeg, jpg, png</i></span>
                    <div class="container">
                        <div class="row row-cols-sm-2 mb-3 justify-content-sm-start justify-content-between">
                            @forelse ($photo->files as $file)
                            <div class="wrapper px-0 mx-sm-3 mx-0 mb-3 data-photo-id-{{ $file->id }}">
                                <div class="thumb-wrap mb-1">
                                    <img src="{{ asset('village/'.$gallery.'/photo/'.$file->folder.'/'.$file->name) }}" alt="{{ $file->name }}">
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="button" class="deletePhoto btn btn-outline-danger" data-id="{{ $file->id }}">Hapus</button>
                                </div>
                            </div>
                            @empty
                                <span>Tidak ada foto</span>
                            @endforelse
                        </div>
                    </div>
                    <input type="file" name="path" id="path" value="{{ old('path') }}" />
                    <span>{{ $errors->first('path') }}</span>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    {{-- delete photo --}}
    <script>
        $(".deletePhoto").click(function() {
                var id = $(this).data("id");
                var confirmation = confirm("Apakah anda yakin ingin menghapus foto ini ??");
                if(confirmation){
                    $.ajax({
                        url: "/village-media/delete/photo/" +'{{ $gallery }}/'+ id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": '{{ csrf_token() }}',
                        },
                        success: function() {
                            $(".data-photo-id-" + id).remove();
                        },
                        error: function(){
                            alert('Gagal menghapus foto')
                        }
                    });
                }

            });
    </script>
    {{-- //delete photo --}}

    {{-- ckeditor --}}
    <script src="{{ asset('vendors/ckeditor/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error(
                    'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                );
                console.warn('Build id: bznspbhgo6qx-32n13df5w9i6');
                console.error(error);
            });
    </script>
    {{-- //ckeditor --}}

    {{-- datepicker --}}
    <script src="{{ asset('vendors/datepickers/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('#date').datepicker({
            format: "dd-mm-yyyy",
        });
    </script>
    {{-- //datepicker --}}

    {{-- filepond --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );
        const inputElement = document.querySelector('input[id="path"]');
        const pond = FilePond.create(inputElement, {
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg'],
            fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                // Do custom type detection here and return with promise
                resolve(type);
            })
        });
        FilePond.setOptions({
            server: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/upload/media');
                    request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}'); 

                    request.onload = function () {
                        if (request.status == 200 && this.readyState === XMLHttpRequest.DONE) {
                            // the load method accepts either a string (id) or an object
                            load(request.responseText);
                            $('form').append('<input type="hidden" name="medias[]" value='+request.responseText+'>')
                        } else {
                            // Can call the error method if something is wrong, should exit after
                            error('oh no');
                        }
                    };
                    request.send(formData);
                    return {
                        abort: () => {
                            // This function is entered if the user has tapped the cancel button
                            request.abort();

                            // Let FilePond know the request has been cancelled
                            abort();
                        },
                    };
                },
                revert: {
                    url: '/delete/media',
                    onload: function (response) {
                        const name = JSON.parse(response);
                        $('form').find('input[name="medias[]"][value="' + name + '"]').remove()
                    },
                }
            },
        });
    </script>
    {{-- //filepond --}}
@endpush
