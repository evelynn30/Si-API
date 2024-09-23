@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-modal-image').on('click', function() {
                var imageUrl = $(this).data('gambar');
                var modalBody = $('#imageModal .modal-body');
                modalBody.empty();

                var img = $('<img>', {
                    src: imageUrl,
                    class: 'img-fluid',
                    alt: 'Temuan Image'
                });

                modalBody.append(img);

                $('#imageModal').modal('show');
            });
        });
    </script>
@endpush
