@extends('layouts.app')

@section('page_title', 'Tambah Data Desa')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ url('/active-village') }}" method="post">
            @csrf
            <div class="row  row-cols-1 row-cols-sm-2">
                <div class="col">
                    <div class="form-group">
                        <label for="province" class="text-capitalize">provinsi<span class="text-danger">*</span></label>
                        <select class="form-select select2 @error('province') is-invalid @enderror" id="province"
                            name="province" aria-describedby="provinceFeedback">
                            <option value="" selected disabled>-- Pilih provinsi --</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                            @endforeach
                        </select>
                        @error('province')
                        <div id="provinceFeedback" class="invalid-feedback">
                            <strong>"{{ $message }}"</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="regency" class="text-capitalize">kota/kab<span class="text-danger">*</span></label>
                        <select class="form-select select2 @error('regency') is-invalid @enderror" id="regency"
                            name="regency" aria-describedby="regencyFeedback">
                            <option value="" selected disabled>-- Pilih kota/kab --</option>
                        </select>
                        @error('regency')
                        <div id="regencyFeedback" class="invalid-feedback">
                            <strong>"{{ $message }}"</strong>
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row  row-cols-1 row-cols-sm-2">
                <div class="col">
                    <div class="form-group">
                        <label for="district" class="text-capitalize">kecamatan<span class="text-danger">*</span></label>
                        <select class="form-select select2 @error('district') is-invalid @enderror" id="district"
                            name="district" aria-describedby="districtFeedback">
                            <option value="" selected disabled>-- Pilih kecamatan --</option>
                        </select>
                        @error('district')
                        <div id="districtFeedback" class="invalid-feedback">
                            <strong>"{{ $message }}"</strong>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="village" class="text-capitalize">desa<span class="text-danger">*</span></label>
                        <select class="form-select select2 @error('village') is-invalid @enderror" id="village"
                            name="village" aria-describedby="villageFeedback">
                            <option value="" selected disabled>-- Pilih desa --</option>
                        </select>
                        @error('village')
                        <div id="villageFeedback" class="invalid-feedback">
                            <strong>"{{ $message }}"</strong>
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row  row-cols-1 row-cols-sm-2">
                <div class="col">
                    @include('layouts.partials.input', ['name' => 'email', 'label' => 'email', 'type' => 'email', 'sm' => 'form-control-sm'])
                </div>
                <div class="col">
                    @include('layouts.partials.input', ['name' => 'phone', 'label' => 'no hp', 'sm' => 'form-control-sm'])
                </div>
            </div>
            <div class="row  row-cols-1 row-cols-sm-2">
                <div class="col">
                    @include('layouts.partials.input', ['name' => 'rw', 'label' => 'jumlah rw', 'sm' => 'form-control-sm'])
                </div>
                <div class="col">
                    @include('layouts.partials.input', ['name' => 'rt', 'label' => 'jumlah rt', 'sm' => 'form-control-sm'])
                </div>
            </div>
            @include('layouts.partials.input', ['name' => 'head_village', 'label' => 'kepala desa', 'sm' => 'form-control-sm'])
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
        function onChangeSelect(url, id, name) {
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            },
            success: function (data) {
                $('#' + name).empty();
                $.each(data, function (key, value) {
                    $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                });
            },
            error: function(err){
                console.log('error: ', err);
            }
        });
    }
    $(function () {
            $('#province').on('change', function () {
                onChangeSelect('/utilities/regency', $(this).val(), 'regency');
            });
            $('#regency').on('change', function () {
                onChangeSelect('/utilities/district', $(this).val(), 'district');
            })
            $('#district').on('change', function () {
                onChangeSelect('/utilities/village', $(this).val(), 'village');
            })
        });
    })
</script>
@endpush