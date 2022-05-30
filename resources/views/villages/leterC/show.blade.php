@extends('layouts.app')

@section('page_title', 'Leter C Detail')

@section('content')
<div class="card border-secondary shadow">
    <div class="card-body pb-0">
        <div class="mb-3">
            <label class="form-label text-capitalize">nomor registrasi</label>
            <p class="form-control">{{ $leterC->register_number }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label text-capitalize">nama wajib pajak</label>
            <p class="form-control">{{ $leterC->name }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label text-capitalize">alamat</label>
            <p class="form-control">{{ $leterC->address }}</p>
        </div>
        <img src="{{ asset('village/'.$village.'/leter-c/'.$leterC->scan) }}" alt="{{ $leterC->scan }}" class="img-fluid mb-3">
    </div>
</div>
@endsection
