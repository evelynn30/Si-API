<div class="form-group">
    <label>{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" class="form-control {{ $class ?? '' }} @error($name) is-invalid @enderror"
        name="{{ $name }}" id="{{ $name }}" placeholder="Masukkan {{ $label }}"
        value="{{ $value }}">
    @error($name)
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
