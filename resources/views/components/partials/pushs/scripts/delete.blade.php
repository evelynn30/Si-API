@push('scripts')
    <script>
        // Select the delete buttons
        const deleteButtons = document.querySelectorAll('.btn-destroy');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                // Scroll to the top of the page smoothly
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                // Show the confirmation alert
                const alertContainer = document.getElementById('alert-confirmation-container');
                const labelDestroy = this.getAttribute('data-label');
                document.getElementById('label-destroy').innerText = labelDestroy;

                alertContainer.style.display = 'block';

                // Get the form associated with the delete button
                const form = this.closest('form');

                // Add a one-time click event listener to the destroy button
                const destroyButton = document.getElementById('btn-confirm');
                destroyButton.onclick = function() {
                    form.submit();
                };

                // Add a click event listener to the cancel button
                const cancelButton = document.getElementById('btn-cancel');
                cancelButton.onclick = function() {
                    alertContainer.style.display = 'none';
                };
            });
        });

        // Hide success alert after 4 seconds
        let alertElement = document.getElementById('alert-success');
        if (alertElement) {
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, 4000);
        }
    </script>
@endpush
