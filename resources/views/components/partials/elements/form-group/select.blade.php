<div class="form-group">
    <div class="form-group">
        <label>{{ $label }}</label>
        <select class="form-control select2 @error($name) is-invalid @enderror" name="{{ $name }}"
            id="{{ $name }}" placeholder="Masukkan {{ $label }}">
            <option value="">Pilih salah satu</option>
            @foreach ($options as $id => $option)
                <option value="{{ $id }}" {!! isset($value) && $value == $id ? 'selected' : '' !!}>{{ $option }}
                    {{-- <option value="{{ $id }}">{{ $option }} --}}
                </option>
            @endforeach
        </select>
        @error($name)
            <div class="alert alert-danger mt-2">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
