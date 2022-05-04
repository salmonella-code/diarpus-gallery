@extends('layouts.app')

@push('css')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@section('page_title', $galleries->name)

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('photo.store', $galleries->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="description" class="text-capitalize">keterangan<span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" placeholder="Masukkan keterangan">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            "{{ $message }}"
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="path" class="text-capitalize">Foto<span class="text-danger">*</span></label><br>
                    <span class="text-muted"><i>Format yang didukung: jpeg, jpg, png</i></span>
                    <input type="file" name="path" id="path" value="{{ old('path') }}"/>
                    <span>{{ $errors->first('path') }}</span>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
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
                url: '/uploadPhoto',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
        });
    </script>
@endpush
