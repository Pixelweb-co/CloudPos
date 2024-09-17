 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <!-- jQuery Validation -->
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<div class="wrap">
        <h1>Agregar Categoría</h1>
        <form method="post" action="" id="formCat">
            <?php wp_nonce_field('guardar_categoria', 'guardar_categoria_nonce'); ?>
            <label for="nombre">Nombre de la categoría:</label><br>
            <input type="text" id="nombre" name="nombre" required><br/>
            <div class="error-message" id="error-post_title"></div>
            <br><br>
            <input type="submit" name="guardar_categoria" value="Guardar Categoría" class="button-primary">
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#categorias').select2({
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        action: 'get_categories' // Nombre de la acción AJAX
                    };
                },
                processResults: function(data) {
                    console.log("procc ",data);
                    return {
                        results: $.map(data, function(obj) {
                            return { id: obj.id, text: obj.nombre };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });


$("#formCat").validate({
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
    rules: {
      nombre: "required",

    },
    messages: {
      post_title: "Por favor, ingrese el nombre",
    },
    submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: $(form).serialize() + "&action=save_category",
                        success: function(response) {
                            alert("Categoria guardada exitosamente.");
                            location.reload(); // Recarga la página
                        },
                        error: function(response) {
                            alert("Ocurrió un error al guardar la categoria.");
                        }
                    });
                }
  });



    $("#formCat").submit((event)=>{
        event.preventDefault();

        if ($(this).isValid()) {
                // Si el formulario es válido, enviarlo
                this.submit();
            } else {
                // Si hay campos no válidos, mostrar mensajes de error
                $('.error-message').each(function() {
                    var input = $(this).prev();
                    if (!input.isValid()) {
                        $(this).text(input.data('validation-error-msg'));
                        $(this).css('color', 'red');
                    } else {
                        $(this).text('');
                    }
                });
            }

    })    















    });






    </script>