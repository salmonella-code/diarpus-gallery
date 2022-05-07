@extends('layouts.app')

@section('page_title', 'Edit user')

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="post">
                @method('put')
                @csrf
                <div class="form-group mb-3">
                    <label for="field" class="text-capitalize">Bidang<span class="text-danger">*</span></label>
                    <select class="form-select" name="field" id="field" @error('field') is-invalid @enderror>
                        <option selected disabled>-- Pilih Bidang ---</option>
                        @foreach ($fields as $field)
                        <option value="{{ $field->id }}" {{ old('field', $user->field_id) == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                        @endforeach
                    </select>
                    @error('field')
                    <div class="invalid-feedback">
                        "{{ $message }}"
                    </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="nip" class="text-capitalize">nip</label>
                    <input type="text" class="form-control  @error('nip') is-invalid @enderror" id="nip" name="nip"
                        placeholder="Masukkan nip" value="{{ old('nip', $user->nip) }}">
                    @error('nip')
                        <span class="invalid-feedback" role="alert">
                            "{{ $message }}"
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="group" class="text-capitalize">golongan</label>
                    <input type="text" class="form-control  @error('group') is-invalid @enderror" id="group" name="group"
                        placeholder="Masukkan golongan" value="{{ old('group', $user->group) }}">
                    @error('group')
                        <span class="invalid-feedback" role="alert">
                            "{{ $message }}"
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="position" class="text-capitalize">jabatan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('position') is-invalid @enderror" id="position"
                        name="position" placeholder="Masukkan jabatan" value="{{ old('position',  $user->position) }}">
                    @error('position')
                        <span class="invalid-feedback" role="alert">
                            "{{ $message }}"
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="name" class="text-capitalize">nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name"
                        placeholder="Masukkan nama" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            "{{ $message }}"
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="contact" class="text-capitalize">no hp<span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('contact') is-invalid @enderror" id="contact"
                        name="contact" placeholder="Masukkan no hp" value="{{ old('contact', $user->contact) }}">
                    @error('contact')
                        <span class="invalid-feedback" role="alert">
                            "{{ $message }}"
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="text-capitalize">email<span class="text-danger">*</span></label>
                    <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email" name="email"
                        placeholder="Masukkan email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            "{{ $message }}"
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
