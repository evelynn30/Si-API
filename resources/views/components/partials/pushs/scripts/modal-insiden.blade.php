@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-modal-insiden').on('click', function() {
                var insidenData = $(this).data('insiden');
                var modalBody = $('#insidenModal .modal-body');
                modalBody.empty();

                // Populate modal with insiden data
                $.each(insidenData, function(index, insiden) {
                    modalBody.append('<span class="badge badge-primary mr-2 mb-2">' + insiden
                        .insiden.nama + '</span>');
                });

                $('#insidenModal').modal('show');
            });
        });
    </script>
@endpush
