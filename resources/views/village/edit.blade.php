@extends('layouts.app')

@section('page_title', 'Edit Data Desa')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/village/'.$village->id) }}" method="post">
                @method('put')
                @csrf
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'province', 'label' => 'provinsi', 'required' => true, 'value' => $village->province])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'regency', 'label' => 'kota/kabupaten', 'required' => true, 'value' => $village->regency])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'district', 'label' => 'kecamatan', 'required' => true, 'value' => $village->district])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'village', 'label' => 'desa', 'required' => true, 'value' => $village->village])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'email', 'label' => 'email', 'type' => 'email', 'value' => $village->email])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'phone', 'label' => 'no hp', 'value' => $village->phone])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'rw', 'label' => 'jumlah rw', 'value' => $village->rw])
                    </div>
                    <div class="col">
                        @include('layouts.partials.input', ['name' => 'rt', 'label' => 'jumlah rt', 'value' => $village->rt])
                    </div>
                </div>
                @include('layouts.partials.input', ['name' => 'head_village', 'label' => 'kepala desa', 'value' => $village->head_village])
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection