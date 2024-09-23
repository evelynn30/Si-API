<li class="list-group-item d-flex justify-content-between align-items-center">
    {{ $label }}:
    <span class="badge text-bold font-weight-bold {{ $value ? 'badge-success' : 'badge-danger' }} badge-pill">
        {{ $value ? $trueText : $falseText }}
    </span>
</li>
