@extends('layouts.app')

@push('css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

@endpush

@section('page_title', 'Edit Profile')
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <div class="container">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group mb-3">
                        <label for="nip" class="text-capitalize">nip</label>
                        <input type="text" class="form-control  @error('nip') is-invalid @enderror" id="nip" name="nip"
                            placeholder="Masukkan nip" value="{{ old('nip', $profile->nip) }}">
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                "{{ $message }}"
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="group" class="text-capitalize">golongan</label>
                        <input type="text" class="form-control  @error('group') is-invalid @enderror" id="group" name="group"
                            placeholder="Masukkan golongan" value="{{ old('group', $profile->group) }}">
                        @error('group')
                            <span class="invalid-feedback" role="alert">
                                "{{ $message }}"
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="text-capitalize">nama<span class="text-danger">*</span></label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name"
                            placeholder="Masukkan nama" value="{{ old('name', $profile->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="position" class="text-capitalize">jabatan<span class="text-danger">*</span></label>
                        <input type="text" class="form-control  @error('position') is-invalid @enderror" id="position"
                            name="position" placeholder="Masukkan jabatan" value="{{ old('position', $profile->position) }}">
                        @error('position')
                            <span class="invalid-feedback" role="alert">
                                "{{ $message }}"
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="text-capitalize">email<span class="text-danger">*</span></label>
                        <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Masukkan nama" value="{{ old('email', $profile->email) }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="contact" class="text-capitalize">no hp<span class="text-danger">*</span></label>
                        <input type="text" class="form-control  @error('contact') is-invalid @enderror" id="contact"
                            name="contact" placeholder="Masukkan no hp" value="{{ old('contact', $profile->contact) }}">
                        @error('contact')
                            <span class="invalid-feedback" role="alert">
                                "{{ $message }}"
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <label>Ubah Password</label>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="password">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password" placeholder="Masukkan Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password"
                                    placeholder="Konfirmasi Password">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="text-capitalize">photo profile</label>
                        <input type="file" id="avatar" name="avatar">
                    </div>

                    <button type="submit" class="btn btn-primary rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
        );
        FilePond.create(document.querySelector('input[id="avatar"]'), {
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                // Do custom type detection here and return with promise
                resolve(type);
            })
        });
        FilePond.setOptions({
            server: {
                url: '/upload/avatar',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
        });
    </script>
@endpush
