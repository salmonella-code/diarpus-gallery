@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
@endpush

@section('page_title', 'Data Leter C '. strtolower($dataVillage->name))

@section('content')
    <a href="{{ url('/'.$village.'/leter-c/create') }}" class="btn btn-success mb-3">
        <i class="fa fa-plus-circle align-middle" aria-hidden="true"></i> <span class="align-middle">Leter C</span>
    </a>

    @include('layouts.partials.alert')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="leter-c-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nomor Registrasi</th>
                            <th>Nama</th>
                            <th>Alamat</th>
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
            $('#leter-c-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('village.leterC.index', $village) !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'register_number', name: 'register_number' },
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'action', name: 'action' },
                ]
            });
        });
    </script>
@endpush