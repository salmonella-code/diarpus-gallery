@extends('layouts.app')

@section('page_title', 'detail admin')

@section('content')
<a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning text-white mb-3"><i class="fas fa-fw fa-edit"></i> Edit</a>
    <div class="card shadow">
        <div class="card-body">
            <div class="avatar-profile mx-auto mb-5">
                <img src="{{ asset('avatar/' . $admin->avatar) }}" alt="">
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">NIP</label>
                    <p class="form-control">{{ is_null($admin->nip) ? 'Belum memiliki NIP' : $admin->nip }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Golongan</label>
                    <p class="form-control">{{ is_null($admin->group) ? 'Belum memiliki Golongan' : $admin->group }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">Jabatan</label>
                    <p class="form-control">{{ $admin->position }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Nama</label>
                    <p class="form-control">{{ $admin->name }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">No Hp</label>
                    <p class="form-control">{{ $admin->contact }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Email</label>
                    <p class="form-control">{{ $admin->email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
