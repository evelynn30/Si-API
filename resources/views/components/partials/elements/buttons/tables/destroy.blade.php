<div class="d-inline">
    <form id="delete-form-{{ $id }}" data-label="{{ $nama }}" class="btn btn-sm btn-danger btn-destroy"
        action="{!! $href !!}" method="POST">
        <i class="fas fa-trash-alt"></i>
        @csrf
        @method('DELETE')
    </form>
</div>
