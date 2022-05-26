@extends('layouts.app')

@section('page_title', 'Create User Village')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form action="{{ url('/village-user') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label for="village" class="text-capitalize">Desa<span class="text-danger">*</span></label>
                <select class="form-select" name="village" id="village" @error('village') is-invalid @enderror>
                    <option selected disabled>-- Pilih Desa ---</option>
                    @foreach ($villages as $village)
                    <option value="{{ $village->id }}" {{ old('village') == $village->id ? 'selected' : '' }}>{{ $village->name }}</option>
                    @endforeach
                </select>
                @error('village')
                <div class="invalid-feedback">
                    "{{ $message }}"
                </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="nip" class="text-capitalize">nip</label>
                <input type="text" class="form-control  @error('nip') is-invalid @enderror" id="nip" name="nip" placeholder="Masukkan nip" value="{{ old('nip') }}">
                @error('nip')
                <span class="invalid-feedback" role="alert">
                    "{{ $message }}"
                </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="group" class="text-capitalize">golongan</label>
                <input type="text" class="form-control  @error('group') is-invalid @enderror" id="group" name="group" placeholder="Masukkan golongan" value="{{ old('group') }}">
                @error('group')
                <span class="invalid-feedback" role="alert">
                    "{{ $message }}"
                </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="position" class="text-capitalize">jabatan<span class="text-danger">*</span></label>
                <input type="text" class="form-control  @error('position') is-invalid @enderror" id="position" name="position" placeholder="Masukkan jabatan" value="{{ old('position') }}">
                @error('position')
                <span class="invalid-feedback" role="alert">
                    "{{ $message }}"
                </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="name" class="text-capitalize">nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    "{{ $message }}"
                </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="contact" class="text-capitalize">no hp<span class="text-danger">*</span></label>
                <input type="text" class="form-control  @error('contact') is-invalid @enderror" id="contact" name="contact" placeholder="Masukkan no hp" value="{{ old('contact') }}">
                @error('contact')
                <span class="invalid-feedback" role="alert">
                    "{{ $message }}"
                </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email" class="text-capitalize">email<span class="text-danger">*</span></label>
                <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}">
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
