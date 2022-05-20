@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
@endpush

@section('page_title', 'Data Desa')

@section('content')
    <a href="{{ url('/villages/create') }}" class="btn btn-success mb-3">
        <i class="fa fa-plus-circle align-middle" aria-hidden="true"></i> <span class="align-middle">Desa</span>
    </a>

    @include('layouts.partials.alert')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="village-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Desa</th>
                            <th>Kecamatan</th>
                            <th>Kota/Kab</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(function() {
            $('#village-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('village.index') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'village', name: 'village' },
                    { data: 'district', name: 'district' },
                    { data: 'regency', name: 'regency' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action' },
                ]
            });
        });
    </script>
@endpush