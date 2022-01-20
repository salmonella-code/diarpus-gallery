@extends('layouts.app')

@section('page_title', 'User')

@section('content')
    <a href="{{ route('user.create') }}" class="btn btn-success mb-3"><i class="fa fa-plus-circle align-middle"
            aria-hidden="true"></i> <span class="align-middle">User</span></a>
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
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ is_null($user->nip) ? 'belum memiliki nip' : $user->nip }}</td>
                            <td>{{ is_null($user->group) ? 'belum memiliki golongan' : $user->group }}</td>
                            <td>{{ $user->position }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-fw fa-eye align-middle" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-fw fa-edit align-middle" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" onclick="return confirm('apakah anda yakin ingin menghapus user ini ??');">
                                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
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
