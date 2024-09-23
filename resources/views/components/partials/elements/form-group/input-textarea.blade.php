<div class="form-group">
    <label>{{ $label }}</label>
    <textarea class="form-control {{ $class ?? '' }} @error($name) is-invalid @enderror" data-height="{{ $height ?? 150 }}"
        name="{{ $name }}" id="{{ $name }}" placeholder="Masukkan {{ $label }}">{{ $value }}</textarea>
    @error($name)
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>


