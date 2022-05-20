@extends('layouts.app')

@section('page_title', 'Tambah Data Desa')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/villages') }}" method="post">
                @csrf
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'province', 'label' => 'provinsi', 'required' => true])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'regency', 'label' => 'kota/kabupaten', 'required' => true])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'district', 'label' => 'kecamatan', 'required' => true])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'village', 'label' => 'desa', 'required' => true])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'email', 'label' => 'email', 'type' => 'email'])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'phone', 'label' => 'no hp'])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'rw', 'label' => 'jumlah rw'])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'rt', 'label' => 'jumlah rt'])
                    </div>
                </div>
                @include('layouts.partials.input', ['name' => 'head_village', 'label' => 'kepala desa'])
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection