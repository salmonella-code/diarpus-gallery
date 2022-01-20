@extends('layouts.app')

@section('page_title', 'detail user')

@section('content')
<a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning text-white mb-3"><i class="fas fa-fw fa-edit"></i> Edit</a>
    <div class="card shadow">
        <div class="card-body">
            <div class="avatar-profile mx-auto mb-5">
                <img src="{{ asset('avatar/' . $user->avatar) }}" alt="">
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">NIP</label>
                    <p class="form-control">{{ is_null($user->nip) ? 'Belum memiliki NIP' : $user->nip }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Golongan</label>
                    <p class="form-control">{{ is_null($user->group) ? 'Belum memiliki Golongan' : $user->group }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">Jabatan</label>
                    <p class="form-control">{{ $user->position }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Nama</label>
                    <p class="form-control">{{ $user->name }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">No Hp</label>
                    <p class="form-control">{{ $user->contact }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Email</label>
                    <p class="form-control">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
