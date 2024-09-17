<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



<?php
    foreach($marcas as $marca){
        echo "<h3>".$marca['post_title']."</h3>";

        echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>CATEGORÍA</th><th>VALOR IDEAL</th></tr></thead>';
    echo '<tbody>';
    foreach ($categorias as $categoria) {
        
       // if($categoria->nombre != 'herraje'){
        echo '<tr>';
        echo '<td>' . $categoria->nombre. '</td>';
        echo '<td><span><input type="text" class=" valores_indicados data-marca="'.$marca['ID'].'" data-categoria="'.$categoria->id.'" form-control" value="' .get_valor_ideal($valores_ideales,$marca['ID'],$categoria->id). '" /></span><span id="edit-controls" style="margin-left:10px"><button type="button" class="btn btn-success btn-save-vi" data-marca="'.$marca['ID'].'" data-categoria="'.$categoria->id.'">Guardar</button></span ><span class="save-confirm" style="color: green;margin-left:15px; display:none"><b>Actualizado</b></span></td>';
        echo '</tr>';
        //}
    }
    echo '</tbody></table>';
    

    }
?>
<script>
    var base_url = '<?=get_site_url()?>'
    var nonce = '<?php echo wp_create_nonce('wp_rest');?>'

</script>   
<script type="text/javascript">
    
    jQuery(document).ready(function($) {
       $('.btn-save-vi').click(function(e){
        // Encontrar el input correspondiente
        var input = $(this).closest('td').find('input.valores_indicados');
        var btn = $(this)
        // Obtener el valor del input
        var valorIdeal = input.val();

        var datos = {
            valor_ideal: valorIdeal,
            categoria_id: $(this).data('categoria'),
            marca_id: $(this).data('marca')
        };

        $.ajax({
            url: base_url+'/wp-json/ordenes_cristal/v1/actualizar_valor_ideal', // URL del endpoint
            type: 'POST', // Método HTTP
            headers:{'X-WP-Nonce' : nonce},
            data: datos, // Datos a enviar
            success: function(response) {
                // Manejar la respuesta exitosa
                console.log('Solicitud exitosa:', response);
                console.log(btn.closest('td').find("span.save-confirm"))
                btn.closest('td').find("span.save-confirm").show();
            },
            error: function(xhr, status, error) {
                // Manejar errores
                console.error('Error en la solicitud:', status, error);
            }
        });

       })
    })
</script>