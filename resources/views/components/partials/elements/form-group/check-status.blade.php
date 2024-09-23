<div class="form-group">
    <label>{{ $label }}</label>
    <div class="d-flex align-items-center">
        <label class="custom-switch mt-2 pl-0">
            <input type="checkbox" class="custom-switch-input {{ $class ?? '' }}" name="{{ $name }}"
                id="{{ $name }}" {{ ($value == 1) | isset($checked) ? 'checked' : '' }}>
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ $description ?? 'Aktif' }}</span>
        </label>
    </div>
</div>
