@extends('layouts.app')

@section('page_title', 'Detail Data Desa')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'provinsi', 'required' => true, 'value' => $village->village->district->regency->province->name])
                    </div>
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'kota/kabupaten', 'required' => true, 'value' => $village->village->district->regency->name])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'kecamatan', 'required' => true, 'value' => $village->village->district->name])
                    </div>
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'desa', 'required' => true, 'value' => $village->name])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'email', 'type' => 'email', 'value' => $village->email])
                    </div>
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'no hp', 'value' => $village->phone])
                    </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-2">
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'jumlah rw', 'value' => $village->rw])
                    </div>
                    <div class="col">
                        @include('layouts.partials.formParagraf', ['name' => 'jumlah rt', 'value' => $village->rt])
                    </div>
                </div>
                @include('layouts.partials.formParagraf', ['name' => 'kepala desa', 'value' => $village->head_village])
        </div>
    </div>
@endsection