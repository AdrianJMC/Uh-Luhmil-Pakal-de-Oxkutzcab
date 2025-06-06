<script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => successAlert.classList.add('d-none'), 3000);
            }

            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(() => errorAlert.classList.add('d-none'), 3000);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => successAlert.classList.add('d-none'), 3000);
            }

            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(() => errorAlert.classList.add('d-none'), 3000);
            }

            // Esto es útil solo si cambias la cantidad de slides con JS
            const badge = document.getElementById('slide-count');
            const slideLimitAlert = document.getElementById('slide-limit-alert');

            if (badge && slideLimitAlert) {
                const count = parseInt(badge.textContent);
                if (count < 6) {
                    slideLimitAlert.classList.add('d-none');
                } else {
                    slideLimitAlert.classList.remove('d-none');
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalEditarSlide');
            const form = document.getElementById('formEditarSlide');

            $('#modalEditarSlide').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);

                var id = button.data('id');
                var titulo = button.data('titulo');
                var descripcion = button.data('descripcion');
                var orden = button.data('orden');
                var imagen = button.data('imagen');

                var form = $('#formEditarSlide');
                form.attr('action', '/admin/slides/' + id);
                form.find('#edit_titulo').val(titulo);
                form.find('#edit_descripcion').val(descripcion);
                form.find('#edit_orden').val(orden);
                form.find('#edit_imagen_actual').attr('src', imagen);
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-open-delete-modal', function() {
            var id = $(this).data('id');
            var form = $('#formEliminarSlide');
            form.attr('action', '/admin/slides/' + id);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#modalEditarSlide').on('hidden.bs.modal', function() {
                setTimeout(function() {
                    document.activeElement && document.activeElement.blur();
                }, 10);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.modal').on('show.bs.modal', function() {
                // Desactiva todos los botones que abren modales
                $('[data-toggle="modal"]').not(this).prop('disabled', true);
            });

            $('.modal').on('hidden.bs.modal', function() {
                // Reactiva los botones una vez que el modal se cierra
                $('[data-toggle="modal"]').prop('disabled', false);
            });
        });
    </script>