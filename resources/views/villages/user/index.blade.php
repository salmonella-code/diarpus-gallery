@extends('layouts.app')

@section('page_title', 'User Desa')

@section('content')
    <a href="{{ url('/village-user/create') }}" class="btn btn-success mb-3"><i class="fa fa-plus-circle align-middle"
            aria-hidden="true"></i> <span class="align-middle">User Desa</span></a>
    
    @include('layouts.partials.alert')
            
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Desa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userVillages as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->position }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>{{ $user->village[0]->village }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ url('/village-user/'.$user->id.'/show') }}" class="btn btn-sm btn-info me-2">
                                        <i class="fas fa-fw fa-eye align-middle" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ url('/village-user/'.$user->id) }}" class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-fw fa-edit align-middle" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" onclick="return confirm('apakah anda yakin ingin menghapus user ini ??');">
                                        <form action="{{ url('/village-user/'.$user->id) }}" method="post">
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
