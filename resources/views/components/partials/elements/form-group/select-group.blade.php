<div class="form-group">
    <label class="form-label">{{ $label }}</label>
    <div class="selectgroup selectgroup-pills">
        @foreach ($options as $key => $option)
            <label class="selectgroup-item">
                <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}"
                    class="selectgroup-input @error($name) is-invalid @enderror"
                    {{ ($value ?? old($name)) == $option['value'] ? 'checked' : '' }}>
                <span class="selectgroup-button">{{ $option['label'] }}</span>
            </label>
        @endforeach
    </div>
    @error($name)
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
