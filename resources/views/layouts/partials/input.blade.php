<div class="form-group mb-3">
    <label for="{{ $name }}" class="text-capitalize">
        {{ $label }}
        @if (isset($required) && $required == true)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="{{ $type??'text' }}" class="form-control  @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" placeholder="Masukkan {{ $label }}" value="{{ old($name, isset($value) ? $value : null) }}">
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>"{{ $message }}"</strong>
        </span>
    @enderror
</div>