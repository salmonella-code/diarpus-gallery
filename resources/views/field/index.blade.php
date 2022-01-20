@extends('layouts.app')

@section('page_title', 'Bidang')

@section('content')
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <i class="fas fa-fw fa-plus-circle align-middle"></i> <span class="align-middle">Bidang</span>
    </button>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fields as $key => $field)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $field->name }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-warning text-white me-3 field_edit" data-toggle="modal"
                                        data-target="#field_edit" value="{{ $field->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="#" onclick="return confirm('Perhatian dengan menghapus bidang ini semua data yang berkaitan dengan bidang ini akan terhapus, yakin ???');">
                                        <form action="{{ route('field.destroy', $field->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
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

    {{-- add field --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Bidang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('field.store') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="text-capitalize">nama</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Masukkan nama" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    "{{ $message }}"
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end add field --}}

    {{-- edit field --}}
    <div class="modal fade" id="field_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="field_editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="field_editLabel">Edit bidang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('field.update') }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group mb-3">
                            <label for="name" class="text-capitalize">nama</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="edit_name"
                                name="name" placeholder="Masukkan nama" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    "{{ $message }}"
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end edit field --}}
@endsection

@push('script')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
        $(document).on("click", ".field_edit", function() {
            var url = "field/";
            var id = $(this).val();
            $.get(url + id, function(items) {
                $("#edit_id").val(items.id);
                $("#edit_name").val(items.name);
                $("#field_edit").modal("show");
            });
        });
    </script>
@endpush
