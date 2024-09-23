<div class="form-group">
    <label>{{ $label }}</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input @error($name) is-invalid @enderror" id="{{ $name }}"
            name="{{ $name }}" accept=".pdf">
        <label class="custom-file-label" for="{{ $name }}">
            {{ old($name, isset($value) ? basename($value) : $placeholder) }}
        </label>
    </div>
    @if (isset($value) && $value)
        <small class="form-text text-muted">
            Current file: <a href="{{ Storage::url($path . $value) }}" target="_blank">{{ basename($value) }}</a>
        </small>
    @endif
    @error($name)
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
