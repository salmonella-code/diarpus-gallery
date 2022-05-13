<div class="d-flex">
    <a href="{{ url('/village/'.$model->id.'/show') }}" class="btn btn-sm btn-success me-2">
        <i class="fas fa-fw fa-eye align-middle" aria-hidden="true"></i>
    </a>
    <a href="{{ url('/village/'.$model->id) }}" class="btn btn-sm btn-warning me-2">
        <i class="fas fa-fw fa-edit align-middle" aria-hidden="true"></i>
    </a>
    
    <a href="#" onclick="return confirm('apakah anda yakin ingin menghapus desa ini ??');">
        <form action="{{ url('/village/'.$model->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash fa-fw"></i>
            </button>
        </form>
    </a>
</div>