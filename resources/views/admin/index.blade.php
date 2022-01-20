@extends('layouts.app')

@section('page_title', 'admin')

@section('content')
    <a href="{{ route('admin.create') }}" class="btn btn-success mb-3"><i class="fa fa-plus-circle align-middle"
            aria-hidden="true"></i> Admin</a>
    <div class="card shadow">
        <div class="card-body">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nip</th>
                        <th>Golongan</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $key => $admin)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ is_null($admin->nip) ? 'belum memiliki nip' : $admin->nip }}</td>
                            <td>{{ is_null($admin->group) ? 'belum memiliki golongan' : $admin->group }}</td>
                            <td>{{ $admin->position }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->contact }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-fw fa-eye align-middle" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-fw fa-edit align-middle" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" onclick="return confirm('apakah anda yakin ingin menghapus admin ini ??');">
                                        <form action="{{ route('admin.destroy', $admin->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </button>
                                        </form>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
