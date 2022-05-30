@extends('layouts.app')

@push('css')
    {{-- filepond --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    {{-- //filepond --}}
@endpush

@section('page_title', 'edit data leter c')

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ url('/'.$village.'/leter-c/'.$leterC->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('layouts.partials.input', ['name' => 'register_number', 'label' => 'nomor', 'required' => true, 'value' => $leterC->register_number])
                
                @include('layouts.partials.input', ['name' => 'name', 'label' => 'nawa wajib pajak', 'required' => true, 'value' => $leterC->name])

                @include('layouts.partials.input', ['name' => 'address', 'label' => 'alamat', 'required' => true, 'value' => $leterC->address])

                <div class="form-group mb-3 d-flex flex-column">
                    <label for="path" class="text-capitalize">scan leter c<span class="text-danger">*</span></label>
                    <span class="text-muted"><i>Format yang didukung: jpeg, jpg, png</i></span>
                    <span class="text-muted"><i>Ukuran Maksimal: 2Mb</i></span>
                    <div class="wrapper px-0 mx-sm-3 mx-0 mb-3">
                        <div class="thumb-wrap mb-1">
                            <img src="{{ asset('village/'.$village.'/leter-c/'.$leterC->scan) }}" alt="{{ $leterC->scan }}">
                        </div>
                    </div>
                    <input type="file" name="path" id="path" value="{{ old('path') }}" required/>
                    <span>{{ $errors->first('path') }}</span>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    {{-- filepond --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );
        const inputElement = document.querySelector('input[id="path"]');
        const pond = FilePond.create(inputElement, {
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            maxFileSize: '2MB',
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
                            $('form').append('<input type="hidden" name="scan" value='+request.responseText+'>')
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
                        $('form').find('input[name="scan"][value="' + name + '"]').remove()
                    },
                }
            },
        });
    </script>
    {{-- //filepond --}}
@endpush
