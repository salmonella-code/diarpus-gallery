<div class="form-group mb-3">
    <label for="{{ $name }}" class="text-capitalize">{{ $label }}
        @if (isset($required) && $required == true)
            <span class="text-danger">*</span>
        @endif
    </label>
    <textarea class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" placeholder="Masukkan {{ $label }}">{{ old($label) }}</textarea>
    @error($name)
        <div class="invalid-feedback">
            <strong>"{{ $message }}"</strong>
        </div>
    @enderror
</div>