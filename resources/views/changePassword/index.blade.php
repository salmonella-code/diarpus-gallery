@extends('layouts.app')

@section('page_title', 'Bidang')

@section('content')
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
<div class="card shadow">
    <div class="card-body">
        <form action="{{ url('/change-password') }}" method="post">
            @csrf
            @method('put')
            <div class="form-group mb-3">
                <label for="oldPassword" class="text-capitalize">password<span class="text-danger">*</span></label>
                <input type="password" class="form-control  @error('oldPassword') is-invalid @enderror" id="oldPassword" name="oldPassword" placeholder="Masukkan password" value="{{ old('oldPassword') }}">
                @error('oldPassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>"{{ $message }}"</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="text-capitalize">password baru<span class="text-danger">*</span></label>
                <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru" value="{{ old('password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>"{{ $message }}"</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="text-capitalize">konfirmasi password<span class="text-danger">*</span></label>
                <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Masukkan konfirmasi password">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>"{{ $message }}"</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection