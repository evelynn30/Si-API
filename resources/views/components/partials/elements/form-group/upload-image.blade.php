<div class="form-group {{ $classFormGroup ?? '' }}" id="form-group-image">
    <label>{{ $label }}</label>
    <div id="image-preview" class="image-preview @error($name) is-invalid @enderror">
        <label for="{{ $name }}-upload "
            id="{{ $name }} label">{{ $placeholder ?? 'PILIH GAMBAR' }}</label>
        <input type="file" name="{{ $name }}" id="image-upload" accept="image/png, image/jpg, image/jpeg" />
    </div>
    <small class="form-text text-muted">Maksimum ukuran file: 5MB</small>
    @error($name)
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
