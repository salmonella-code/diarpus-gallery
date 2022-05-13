<div class="modal fade" id="{{ $modal }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="{{ $modal }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modal }}Label">{{ $modal_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ $form }}" method="post" {{ $multipart??null }}>
                    @csrf
                    @method($method??'post')
                    {{ $body }}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-{{ $buttonColor??'primary' }}">{{ $buttonName??'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
