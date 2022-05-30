<div class="d-flex">
    <a href="{{ asset('village/'.$village.'/'.$model->scan) }}" class="btn btn-sm btn-primary me-2">
        <i class="fas fa-fw fa-download align-middle" aria-hidden="true"></i>
    </a>
    <a href="{{ url('/'.$village.'/leter-c/'.$model->id.'/show') }}" class="btn btn-sm btn-success me-2">
        <i class="fas fa-fw fa-eye align-middle" aria-hidden="true"></i>
    </a>
    <a href="{{url('/'.$village.'/leter-c/'.$model->id) }}" class="btn btn-sm btn-warning me-2">
        <i class="fas fa-fw fa-edit align-middle" aria-hidden="true"></i>
    </a>
    
    <a href="#" onclick="return confirm('apakah anda yakin ingin menghapus data leter c ini ??');">
        <form action="{{ url('/'.$village.'/leter-c/'.$model->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash fa-fw"></i>
            </button>
        </form>
    </a>
</div>