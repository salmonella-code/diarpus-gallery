@extends('layouts.app')

@section('page_title', 'Detail User Village')

@section('content')
<a href="{{ url('/village-user/'.$village->id) }}" class="btn btn-warning text-white mb-3"><i class="fas fa-fw fa-edit"></i> Edit</a>
    <div class="card shadow">
        <div class="card-body">
            <div class="avatar-profile mx-auto mb-5">
                <img src="{{ asset('avatar/' . $village->avatar) }}" alt="">
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">NIP</label>
                    <p class="form-control">{{ is_null($village->nip) ? 'Belum memiliki NIP' : $village->nip }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Golongan</label>
                    <p class="form-control">{{ is_null($village->group) ? 'Belum memiliki Golongan' : $village->group }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">Jabatan</label>
                    <p class="form-control">{{ $village->position }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Nama</label>
                    <p class="form-control">{{ $village->name }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <label class="form-label">No Hp</label>
                    <p class="form-control">{{ $village->contact }}</p>
                </div>
                <div class="col">
                    <label class="form-label">Email</label>
                    <p class="form-control">{{ $village->email }}</p>
                </div>
            </div>

            <label class="form-label">Desa</label>
            <p class="form-control">{{ $village->village[0]->village }}</p>
        </div>
    </div>
@endsection
