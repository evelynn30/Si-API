<div class="form-group">
    <div class="control-label">{{ $label }}</div>
    <div class="custom-switches-stacked mt-2">
        @foreach ($options as $value => $description)
            <label class="custom-switch pl-0">
                <input type="radio" name="{{ $name }}" value="{{ $value }}" class="custom-switch-input"
                    {{ $checked == $value ? 'checked' : '' }}>
                <span class="custom-switch-indicator"></span>
                <span class="custom-switch-description">{{ $description }}</span>
            </label>
        @endforeach
    </div>
</div>
