<?php
define('SAVEQUERIES', true);


require_once('classes/cart.php');

/*
Plugin Name: Cristal POS
Description: Plugin para gestionar órdenes de productos
Version: 1.0
Author: Tu Nombre
*/


//desactivar plugin
register_deactivation_hook(__FILE__, 'my_plugin_remove_database');
function my_plugin_remove_database()
{
    global $wpdb;
    $table_name_order_items = $wpdb->prefix . 'orden_items';
    $sql = "DROP TABLE IF EXISTS $table_name_order_items";
    //  $wpdb->query($sql);

    $table_name_order = $wpdb->prefix . 'orden';
    $sql = "DROP TABLE IF EXISTS $table_name_order";
    //$wpdb->query($sql);

    $table_valores_ideales = $wpdb->prefix . 'valores_ideales';
    $sql = "DROP TABLE IF EXISTS $table_valores_ideales";
    // $wpdb->query($sql);

    $tabla_productos = 'productos';
    $sql = "DROP TABLE IF EXISTS $tabla_productos";
    // $wpdb->query($sql);

    $tabla_categorias = 'categorias';
    $sql = "DROP TABLE IF EXISTS $tabla_categorias";
    // $wpdb->query($sql);


    $tabla_relacion_categorias = 'relacion_categorias';
    $sql = "DROP TABLE IF EXISTS $tabla_relacion_categorias";
    //$wpdb->query($sql);


    $tabla_herrajes = 'herrajes';
    $sql = "DROP TABLE IF EXISTS $tabla_herrajes";
    //$wpdb->query($sql);

    $tabla_formulas_herrajes = 'formulas_herrajes';
    $sql = "DROP TABLE IF EXISTS $tabla_formulas_herrajes";
    //$wpdb->query($sql);


    $tabla_materiales_relacionados = $wpdb->prefix . 'materiales_relacionados';
    $sql = "DROP TABLE IF EXISTS $tabla_materiales_relacionados";
    //$wpdb->query($sql);

    // Eliminar todas las entradas del tipo de publicación personalizada 'marca'
    $args = array(
        'post_type' => 'marcas', // Nombre del tipo de publicación personalizada
        'posts_per_page' => -1, // Obtener todas las entradas
    );

    $marcas = get_posts($args);

    foreach ($marcas as $marca) {
        //   wp_delete_post($marca->ID, true); // Eliminar la entrada de 'marca'
    }
    // Eliminar el tipo de publicación personalizada 'marca' al desactivar el plugin
    // unregister_post_type('marcas');  

}

// Activar el plugin
register_activation_hook(__FILE__, 'cristal_pos_activate');

function cristal_pos_activate()
{
    global $wpdb;
    $orden_table_name = $wpdb->prefix . 'orden';
    $orden_items_table_name = $wpdb->prefix . 'orden_items';
    $tabla_valores_ideales = $wpdb->prefix . 'valores_ideales';
    $tabla_productos = 'productos';
    $tabla_categorias = 'categorias';
    $tabla_relacion_categorias = 'relacion_categorias';
    $tabla_herrajes = 'herrajes';
    $tabla_formulas_herrajes = 'formulas_herrajes';
    $tabla_materiales_relacionados = $wpdb->prefix . 'materiales_relacionados';


    $charset_collate = $wpdb->get_charset_collate();

    $orden_sql = "CREATE TABLE $orden_table_name (
        id INT(10) NOT NULL AUTO_INCREMENT,
        fecha_orden datetime NOT NULL,
        cliente varchar(100) NOT NULL,
        cliente_name varchar(255) NOT NULL,
        totalOrden decimal(10,2) NOT NULL,
        fichero_adjunto longtext NOT NULL,
        marca varchar(100) NOT NULL,
        image_marca varchar(100) NOT NULL,
        name_marca varchar(100) NOT NULL,
        links varchar(255) NOT NULL,
        is_send varchar(255) NOT NULL,
        tienda varchar(255) NOT NULL,
        tienda_name varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";



    $orden_items_sql = "CREATE TABLE $orden_items_table_name (
        id_item int(10) NOT NULL AUTO_INCREMENT,
        order_id mediumint(9) NOT NULL,
        ID varchar(100) NOT NULL,
        post_title varchar(100) NOT NULL,
        post_content longtext,
        post_id int(10) NOT NULL,
        price decimal(10,2) NOT NULL,
        categorias longtext NOT NULL,
        cnt int NOT NULL,
        subtotal decimal(10,2) NOT NULL,
        observacion longtext ,
        marca varchar(100) NOT NULL,
        sku varchar(100) NOT NULL,
        image_url   longtext NOT NULL, 
        PRIMARY KEY  (id_item)
    ) $charset_collate;";

    $sql_valores_ideales = "CREATE TABLE IF NOT EXISTS $tabla_valores_ideales (
        id int(10) NOT NULL AUTO_INCREMENT,
        marca_id mediumint(9) NOT NULL,
        categoria_id mediumint(9) NOT NULL,
        valor_ideal float NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";


    $sql_productos = "CREATE TABLE IF NOT EXISTS $tabla_productos (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `sku` varchar(255) NOT NULL,
        `codigo_sap` varchar(255) NOT NULL,
        `post_title` varchar(255) NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `marca` varchar(255) NOT NULL,
        `tipo` varchar(255) NOT NULL,
        `categorias` varchar(255) NOT NULL,
        `image_url` varchar(255) NOT NULL,
        `thumbnail_prod` varchar(255) NOT NULL,
        `post_content` text NOT NULL,
        `observacion` text DEFAULT NULL,
        `order` int(10) NOT NULL,
        PRIMARY KEY  (id)
) $charset_collate;";


    $sql_categorias = "CREATE TABLE IF NOT EXISTS $tabla_categorias (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL,
    `descripcion` text DEFAULT NULL,
    `parent_id` int(11) DEFAULT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";


    $sql_wp_materiales_realcionados = "CREATE TABLE IF NOT EXISTS $tabla_materiales_relacionados (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_padre` int(10) NOT NULL,
    `id_material` int(11) NOT NULL,
    `cantidad_defecto` int(11) NOT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";

    $sql_relacion_categorias = "CREATE TABLE IF NOT EXISTS $tabla_relacion_categorias (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `relacion` varchar(255) NOT NULL,
    `categoria_padre_id` int(11) NOT NULL,
    `categoria_hija_id` int(11) NOT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";

    $sql_herrajes = "CREATE TABLE IF NOT EXISTS $tabla_herrajes (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `sku` varchar(255) NOT NULL,
    `post_title` varchar(255) NOT NULL,
    `price` decimal(10,2) NOT NULL,
    `marca` varchar(255) NOT NULL,
    `tipo` varchar(255) NOT NULL,
    `categorias` varchar(255) NOT NULL,
    `image_url` varchar(255) NOT NULL,
    `thumbnail_prod` varchar(255) NOT NULL,
    `post_content` text NOT NULL,
    `observacion` text DEFAULT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";


    $sql_formulas_herrajes = "CREATE TABLE IF NOT EXISTS $tabla_formulas_herrajes (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_herraje` int(11) NOT NULL,
    `id_formula` int(11) NOT NULL,
    `cantidad_defecto` int(11) DEFAULT NULL,
    `id_mundo` int(10) NOT NULL,
    `id_marca` int(10) DEFAULT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($orden_sql);
    dbDelta($orden_items_sql);
    dbDelta($sql_valores_ideales);
    dbDelta($sql_productos);
    dbDelta($sql_herrajes);
    dbDelta($sql_formulas_herrajes);
    dbDelta($sql_wp_materiales_realcionados);
    dbDelta($sql_relacion_categorias);
    dbDelta($sql_categorias);
}


// Agregar página de administración valores ideales
add_action('admin_menu', 'cristal_pos_admin_menu_valores_ideales');

function mi_plugin_enqueue_admin_scripts()
{
    // Registrar y encolar el archivo JS
    wp_register_script('dropzone-plugin', plugins_url('assets/js/file-dropzone.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('dropzone-plugin');


    //typeahead.bundle
    wp_register_script('typeahead-bundle', plugins_url('assets/js/typeahead.bundle.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('typeahead-bundle');


    wp_localize_script(
        'order-plugin',
        'dcmsUpload',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce-upload')
        ]
    );
}
add_action('admin_enqueue_scripts', 'mi_plugin_enqueue_admin_scripts');

function agregar_estilos_y_scripts()
{
?>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var plugins_url = '<?= plugins_url() ?>'
        var admin_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>'
    </script>
<?php

    // Registrar y encolar el archivo JS
    wp_register_script('dropzone-plugin', plugins_url('assets/js/file-dropzone.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('dropzone-plugin');

    // Registrar y encolar el archivo CSS
    wp_register_style('estilos-plugin', plugins_url('assets/css/cart_order.css', __FILE__));
    wp_enqueue_style('estilos-plugin');

    // Registrar y encolar el archivo JS
    wp_register_script('segbar-plugin', plugins_url('assets/js/segbar.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('segbar-plugin');

    wp_register_style('cart_order-plugin', plugins_url('assets/css/cart_order.css', __FILE__));
    wp_enqueue_style('cart_order-plugin');


    wp_register_script('ng-infinite-scroll', plugins_url('assets/js/ng-infinite-scroll.min.js', __FILE__), array('jquery'), '1.6', true);
    wp_enqueue_script('ng-infinite-scroll');
    // Registrar y encolar el archivo JS
    wp_register_script('order-plugin', plugins_url('assets/js/order_cart.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('order-plugin');

    wp_localize_script(
        'order-plugin',
        'dcmsUpload',
        [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce-upload')
        ]
    );

    // Registrar y encolar el archivo JS
    wp_register_script('validate-plugin', plugins_url('assets/js/jquery.validate.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('validate-plugin');

    //typeahead.bundle
    wp_register_script('typeahead-bundle', plugins_url('assets/js/typeahead.bundle.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('typeahead-bundle');

    // Registrar y encolar el archivo JS noty
    wp_register_script('noty-plugin', plugins_url('assets/js/noty/noty.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('noty-plugin');


    wp_register_style('noty-plugin-css', plugins_url('assets/js/noty/noty.css', __FILE__));
    wp_enqueue_style('noty-plugin-css');

    wp_register_style('noty-plugin-css-theme', plugins_url('assets/js/noty/themes/mint.css', __FILE__));
    wp_enqueue_style('noty-plugin-css-theme');
}

// Llamar a la función 'agregar_estilos_y_scripts' para que se ejecute cuando WordPress cargue los scripts y estilos
add_action('wp_enqueue_scripts', 'agregar_estilos_y_scripts');




function cristal_pos_admin_menu_valores_ideales()
{
    add_menu_page(
        'Valores ideales',
        'Valores ideales',
        'manage_options',
        'cristal_pos_valores_ideales',
        'cristal_pos_valores_ideales_page',
        'dashicons-money',
        20
    );
}

function get_valor_ideal($valores_ideales, $marca_id, $categoria_id)
{
    $valor_ideal_found = 0;
    foreach ($valores_ideales as $valor_ideal) {

        if ($valor_ideal->marca_id == $marca_id && $valor_ideal->categoria_id == $categoria_id) {

            $valor_ideal_found = $valor_ideal->valor_ideal;
            return $valor_ideal_found;
        }
    }

    return $valor_ideal_found;
}

add_filter('logout_redirect', 'custom_logout_redirect');

function custom_logout_redirect($redirect_to)
{
    return home_url('/login');
}

function restrict_access_to_logged_in_users()
{

    $post_d = get_post();


    if (!is_user_logged_in() && !is_page('login') && $post_d->post_name != 'login' && !is_page('wp-login.php')) {

        wp_redirect(site_url('/index.php/login'));
        exit;
    }
}
add_action('template_redirect', 'restrict_access_to_logged_in_users');

function redirect_to_profile()
{
    if (isset($_POST['log'])) {
        $who = strtolower(sanitize_user($_POST['log']));
        $redirect_to = get_option('home');
        return $redirect_to;
    } else {
        return false;
    }
}
add_filter('login_redirect', 'redirect_to_profile');


// Página de administración para mostrar órdenes
function cristal_pos_valores_ideales_page()
{
    global $wpdb;
    $valores_ideales_table_name = $wpdb->prefix . 'valores_ideales';
    $categorias = get_categories_relation_data();
    $marcas = obtener_marcas();


    $valores_ideales = $wpdb->get_results("SELECT * FROM $valores_ideales_table_name");

    echo '<div class="wrap">';
    echo '<h2>Valores ideales</h2>';

    include("templates/valores_ideales_admin.php");
    echo '</div>';
}



// Agregar página de administración
add_action('admin_menu', 'cristal_pos_admin_menu');

function cristal_pos_admin_menu()
{
    add_menu_page(
        'Órdenes',
        'Órdenes',
        'manage_options',
        'cristal_pos_ordenes',
        'cristal_pos_ordenes_page',
        'dashicons-cart',
        20
    );
}



// Página de administración para mostrar órdenes
function cristal_pos_ordenes_page()
{
    global $wpdb;
    $orden_table_name = $wpdb->prefix . 'orden';

    $ordenes = $wpdb->get_results("SELECT * FROM $orden_table_name");

    echo '<div class="wrap">';
    echo '<h2>Órdenes</h2>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Fecha de Orden</th><th>Cliente</th><th>Total de la Orden</th></tr></thead>';
    echo '<tbody>';
    foreach ($ordenes as $orden) {
        echo '<tr>';
        echo '<td>' . $orden->id . '</td>';
        echo '<td>' . $orden->fecha_orden . '</td>';
        echo '<td>' . $orden->cliente . '</td>';
        echo '<td>' . $orden->totalOrden . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    echo '</div>';
}



// Función para mostrar formulario de orden
function mostrar_formulario_orden()
{
    // Aquí va el HTML del formulario de orden

    $cart = new Cart();



    $cart_items = $cart->contents();

    $categorias = get_categories_relation_data();
    $marcas = obtener_marcas();
    $tiendas = obtener_tiendas();

    ob_start();
?>
    <script>
        var categorias_data = <?= json_encode($categorias) ?>
    </script>

    <?php include('templates/cart2.php'); ?>



<?php

    return ob_get_clean();
}

$cart = new Cart();



function shortcode_generar_orden()
{
    return mostrar_formulario_orden();
}
add_shortcode('generar_orden', 'shortcode_generar_orden');


// Función para mostrar minicart
function mostrar_minicart()
{
    ob_start();
?>


    <?php include('templates/miniCart.php'); ?>

<?php

    return ob_get_clean();
}


function shortcode_mini_cart()
{
    return mostrar_minicart();
}
add_shortcode('mini_cart', 'shortcode_mini_cart');

// Crear la página "hacer_pedido" y asignar el shortcode
function crear_pagina_hacer_pedido()
{
    $post_content = '[generar_orden]';
    $page_check = get_page_by_title('hacer_pedido');
    $page_check_ID = $page_check->ID;
    // Si la página no existe, entonces la creamos
    if (empty($page_check)) {
        $page_id = wp_insert_post(array(
            'post_title'     => 'hacer_pedido',
            'post_content'   => $post_content,
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'ping_status'    => 'closed',
            'comment_status' => 'closed',
        ));
        // Asociar la plantilla del plugin
        $template_path = 'template-nuevo-pedido.php';
        update_post_meta($page_id, '_wp_page_template', $template_path);
    }
}
add_action('init', 'crear_pagina_hacer_pedido');


// Registra la ruta personalizada para el endpoint agregar carrito
function custom_add_to_cart_endpoint()
{
    register_rest_route('ordenes_cristal/v1', '/add_to_cart', array(
        'methods' => 'POST',
        'callback' => 'handle_add_to_cart_request',
    ));
}
add_action('rest_api_init', 'custom_add_to_cart_endpoint');

// Función para manejar las solicitudes POST al endpoint
function handle_add_to_cart_request($request)
{
    // Obtener los datos del cuerpo de la solicitud
    $params = $request->get_params();
    $cart = new Cart();


    // Verificar si se enviaron los datos del producto
    if (isset($params['ID']) && isset($params['post_title']) && isset($params['post_content']) && isset($params['price'])) {

        // Crear una instancia de la clase Cart


        // Crear un array con los datos del producto
        $producto = array(
            'ID' => $params['ID'],
            'post_title' => $params['post_title'],
            'image_url' => $params['image_url'],
            'post_content' => $params['post_content'],
            'price' => $params['price']
        );

        // Insertar el producto en el carrito
        $result = $cart->insert($producto);

        // Verificar si la inserción fue exitosa
        if ($result == true) {
            return array('success' => true, 'message' => 'Product added to cart successfully');
        } else {
            return array('success' => false, 'message' => 'Failed to add product to cart');
        }
    } else {
        // Si faltan datos del producto, devolver un mensaje de error
        return array('success' => false, 'message' => 'Error: Missing product data');
    }
}

// AÃ±adir el endpoint personalizado para recibir los datos
add_action('rest_api_init', function () {
    register_rest_route('ordenes_cristal/v1', '/list_cart_items/', array(
        'methods' => 'GET',
        'callback' => 'list_cart_items',
        'permission_callback' => function () {
            return current_user_can('manage_options'); // Puedes ajustar los permisos segÃºn tus necesidades
        },
    ));
});


function list_cart_items($request)
{
    $cart = new Cart();


    $cart_items = $cart->contents();


    echo json_encode(array("cart_items" => $cart_items));
    die();
}



function registrar_post_type_tiendas()
{
    $args = array(
        'label'               => __('Tiendas', 'text-domain'),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'tiendas'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields')
    );
    register_post_type('tiendas', $args);

    // Registrar el campo adicional para metros cuadrados
    register_meta('post', 'metros_cuadrados', array(
        'type' => 'string',
        'description' => 'Metros Cuadrados de la tienda',
        'single' => true,
        'show_in_rest' => true, // Para que se pueda utilizar en la API REST de WordPress
    ));

    // Agregar metabox para mostrar el campo "metros cuadrados"
    add_action('add_meta_boxes', 'agregar_metabox_metros_cuadrados');
    // Guardar el valor del campo "metros_cuadrados"
    add_action('save_post', 'guardar_valor_metros_cuadrados');
}

function agregar_metabox_metros_cuadrados()
{
    add_meta_box(
        'metros_cuadrados',
        __('Metros Cuadrados', 'text-domain'),
        'mostrar_campo_metros_cuadrados',
        'tiendas',
        'normal',
        'default'
    );
}

function mostrar_campo_metros_cuadrados($post)
{
    $metros_cuadrados = get_post_meta($post->ID, 'metros_cuadrados', true);
?>
    <label for="metros_cuadrados"><?php _e('Metros Cuadrados:', 'text-domain'); ?></label>
    <input type="text" id="metros_cuadrados" name="metros_cuadrados" value="<?php echo esc_attr($metros_cuadrados); ?>" />
<?php
}

function guardar_valor_metros_cuadrados($post_id)
{
    if (isset($_POST['metros_cuadrados'])) {
        update_post_meta($post_id, 'metros_cuadrados', sanitize_text_field($_POST['metros_cuadrados']));
    }
}

add_action('init', 'registrar_post_type_tiendas');

// Agregar columna personalizada a la lista de tiendas
function agregar_columna_metros_cuadrados($columns)
{
    $columns['metros_cuadrados'] = __('Metros Cuadrados', 'text-domain');
    return $columns;
}
add_filter('manage_tiendas_posts_columns', 'agregar_columna_metros_cuadrados');

// Mostrar el valor del campo "metros_cuadrados" en la columna personalizada
function mostrar_valor_metros_cuadrados_columna($column, $post_id)
{
    if ($column == 'metros_cuadrados') {
        $metros_cuadrados = get_post_meta($post_id, 'metros_cuadrados', true);
        echo esc_html($metros_cuadrados);
    }
}
add_action('manage_tiendas_posts_custom_column', 'mostrar_valor_metros_cuadrados_columna', 10, 2);





function registrar_post_type_marcas()
{
    $args = array(
        'label'               => __('Marcas', 'text-domain'),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'marcas'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields')
    );
    register_post_type('marcas', $args);
}
add_action('init', 'registrar_post_type_marcas');

function agregar_campos_marcas_productos()
{
    global $woocommerce, $post;

    echo '<div class="options_group">';

    // Campo de selección de marca
    woocommerce_wp_select(array(
        'id'          => '_marca_producto',
        'label'       => __('Marca', 'woocommerce'),
        'class'       => 'wc-enhanced-select',
        'options'     => obtener_marcas_disponibles(),
    ));

    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'agregar_campos_marcas_productos');

function guardar_datos_marcas_productos($post_id)
{
    $marca = isset($_POST['_marca_producto']) ? sanitize_text_field($_POST['_marca_producto']) : '';
    update_post_meta($post_id, '_marca_producto', $marca);
}
add_action('woocommerce_process_product_meta', 'guardar_datos_marcas_productos');

function obtener_marcas_disponibles()
{
    $marcas = get_posts(array(
        'post_type'      => 'marcas',
        'posts_per_page' => -1,
    ));

    $options = array();
    foreach ($marcas as $marca) {
        $options[$marca->ID] = $marca->post_title;
    }

    return $options;
}
// Agregar columna de marca en el listado de productos
function agregar_columna_marca($columns)
{
    // Asegúrate de obtener el índice de la columna de categoría
    $category_column_index = array_search('product_cat', array_keys($columns));

    // Insertar la columna de marca después de la columna de categoría
    $new_columns = array_slice($columns, 0, $category_column_index + 1, true) +
        array('marca' => 'Marca') +
        array_slice($columns, $category_column_index + 1, null, true);

    return $new_columns;
}
add_filter('manage_edit-product_columns', 'agregar_columna_marca');

// Mostrar la marca en la columna personalizada
function mostrar_marca_en_columna($column, $post_id)
{
    if ($column === 'marca') {
        $marca_id = get_post_meta($post_id, '_marca_producto', true);
        if ($marca_id) {
            $marca = get_post($marca_id);
            if ($marca) {
                echo $marca->post_title;
            }
        } else {
            echo '-';
        }
    }
}
add_action('manage_product_posts_custom_column', 'mostrar_marca_en_columna', 10, 2);

// Establecer el ancho de la columna de marca
function estilo_ancho_columna_marca()
{
    echo '<style type="text/css">
        .column-marca {
            width: 200px !important;
        }
    </style>';
}
add_action('admin_head', 'estilo_ancho_columna_marca');

// Permitir ordenar por la columna de marca
function ordenar_por_marca($columns)
{
    $columns['marca'] = 'marca';
    return $columns;
}
add_filter('manage_edit-product_sortable_columns', 'ordenar_por_marca');

// Personalizar la consulta para ordenar por marca
function orden_personalizada_por_marca($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('orderby') === 'marca') {
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', '_marca_producto');
    }
}
add_action('pre_get_posts', 'orden_personalizada_por_marca');

// Agregar campo de marca en la edición rápida de productos
add_action('quick_edit_custom_box', 'mostrar_campo_marca_edicion_rapida', 10, 2);

function mostrar_campo_marca_edicion_rapida($column_name, $post_type)
{
    if ($post_type === 'product' && $column_name === 'marca') {
        global $post;
        $marca_id = get_post_meta($post->ID, '_marca_producto', true);

        echo '
        <fieldset class="inline-edit-col-right">
            <div class="inline-edit-col">
                <label>
                    <span class="title">' . __('Marca', 'woocommerce') . '</span>
                    <span class="input-text-wrap">
                        <select name="marca" class="select">';
        // Obtener todas las marcas
        $marcas = get_posts(array(
            'post_type' => 'marcas',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));
        foreach ($marcas as $marca) {
            echo '<option value="' . $marca->ID . '" ' . selected($marca->ID, $marca_id, false) . '>' . $marca->post_title . '</option>';
        }
        echo '</select>
                    </span>
                </label>
            </div>
        </fieldset>';
    }
}

// Guardar la marca en la edición rápida de productos
add_action('save_post', 'guardar_marca_edicion_rapida');

function guardar_marca_edicion_rapida($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_REQUEST['marca'])) {
        $marca_id = sanitize_text_field($_REQUEST['marca']);
        update_post_meta($post_id, '_marca_producto', $marca_id);
    }
}

// Cargar jQuery en la interfaz de edición rápida
add_action('admin_print_scripts-edit.php', 'cargar_jquery_edicion_rapida');

function cargar_jquery_edicion_rapida()
{
    wp_enqueue_script('jquery');
}



//categoria prodctos



// Crear el menú de administración
function categorias_admin_menu()
{
    add_menu_page(
        'Categorias',
        'Categorias',
        'manage_options',
        'categorias',
        'categorias_admin_page',
        'dashicons-cart',
        5
    );
}
add_action('admin_menu', 'categorias_admin_menu');


// Página de administración de productos
function categorias_admin_page()
{
    global $wpdb;
    $tabla_categorias = 'categorias';

    // Verificar acción (agregar, editar, eliminar)
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($action == 'add' || $action == 'edit') {
        categorias_admin_form($action, $id);
    } else {
        categorias_admin_list();
    }
}


function categorias_admin_list()
{
    global $wpdb;
    $tabla_categorias = 'categorias';

    // Obtener todos los categorias
    $categorias = $wpdb->get_results("SELECT * FROM $tabla_categorias");

    // Mostrar la lista de categorias
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Categorias</h1>';
    echo '<a href="?page=categorias&action=add" class="page-title-action">Añadir nueva</a>';
    echo '<table class="wp-list-table widefat fixed striped table-view-list">';
    echo '<thead><tr>';
    echo '<th>ID</th>';
    echo '<th>Título</th>';
    echo '<th>Acciones</th>';
    echo '</tr></thead>';
    echo '<tbody>';
    foreach ($categorias as $categoria) {
        echo '<tr>';
        echo '<td>' . esc_html($categoria->id) . '</td>';
        echo '<td>' . esc_html($categoria->nombre) . '</td>';
        echo '<td>';
        echo '<a href="?page=categorias&action=edit&id=' . esc_html($categoria->id) . '">Editar</a> | ';
        if ($categoria->id != 3) {
            echo '<a href="?page=categorias&action=delete&id=' . esc_html($categoria->id) . '">Eliminar</a>';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function categorias_admin_form($action, $id)
{
    global $wpdb;
    $tabla_categoria =  'categorias';
    $catgoria = new stdClass();

    if ($action == 'edit') {
        $catgoria = $wpdb->get_row("SELECT * FROM $tabla_categoria WHERE id = $id");
    }

    // Incluir la plantilla del formulario
    include('templates/formulario-categoria.php');
}


//guardar categorias

add_action('wp_ajax_save_category', 'save_category');
add_action('wp_ajax_nopriv_save_category', 'save_category');

function save_category()
{
    global $wpdb;

    if (isset($_POST)) {

        $nombre_categoria = $_POST['nombre'];
        // Sanitizar el nombre de la categoría para evitar inyección de SQL
        $nombre_categoria = sanitize_text_field($nombre_categoria);
        $tabla_categorias = 'categorias';
        $tabla_categorias_relacion = "relacion_categorias";
        // Datos a insertar
        $datos = array(
            'nombre' => $nombre_categoria,
        );

        // Formato de los datos (s es para string)
        $formato = array('%s');

        // Insertar la nueva categoría
        $resultado = $wpdb->insert($tabla_categorias, $datos, $formato);

        // Verificar si la inserción fue exitosa
        if ($resultado) {

            $nuevo_id = $wpdb->insert_id;

            if (isset($_POST['categorias']) && count($_POST['categorias']) > 0) {

                foreach ($_POST['categorias'] as $cat) {

                    $datosr  = array("categoria_padre_id" => $cat, "categoria_hija_id" => $nuevo_id);


                    $wpdb->insert($tabla_categorias_relacion, $datosr, $formato);
                }
            }




            echo json_encode(array("result" => "success"));
        } else {
            echo json_encode(array("result" => "error"));
        }
    } else {
        echo json_encode(array("result" => "error"));
    }

    die();
}


add_action('wp_ajax_get_categories_relations', 'get_categories_relations');
add_action('wp_ajax_nopriv_get_categories_relations', 'get_categories_relations'); // Para usuarios no autenticados



function get_categories_relations()
{
    global $wpdb;

    // Nombre de las tablas
    $tabla_categorias =  'categorias';

    $query = "SELECT * FROM $tabla_categorias ";



    $categorias_r = $wpdb->get_results($query);


    echo json_encode($categorias_r);


    die();
}


function get_materials_relations()
{
    global $wpdb;
    $tabla_productos = 'productos';
    $tabla_materiales_relacionados = 'wp_materiales_relacionados';

    // Obtener parámetros de búsqueda y parent_id
    $search = isset($_GET['q']) ? $_GET['q'] : '';
    $parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;

    // Consulta SQL para obtener productos no relacionados y que no tengan el parent_id especificado
    /*     $productos = $wpdb->get_results($wpdb->prepare("
        SELECT p.*
        FROM $tabla_productos p
        LEFT JOIN $tabla_materiales_relacionados r ON p.id = r.id_padre
        WHERE r.id_padre IS NULL
        AND p.tipo = 'material'
        AND (
            p.post_title LIKE %s OR
            p.codigo_sap LIKE %s OR
            p.sku LIKE %s
        )
        AND p.id NOT IN (
            SELECT id_material 
            FROM $tabla_materiales_relacionados 
            WHERE id_padre = %d
        )
    ", '%' . $wpdb->esc_like($search) . '%', '%' . $wpdb->esc_like($search) . '%', '%' . $wpdb->esc_like($search) . '%', $parent_id), OBJECT);
 */


    $productos = $wpdb->get_results("select * from productos where codigo_sap LIKE '%$search%' and id <> '$parent_id'", OBJECT);

    echo json_encode($productos);
    die();
}




add_action('wp_ajax_get_materials_relations', 'get_materials_relations');
add_action('wp_ajax_nopriv_get_materials_relations', 'get_materials_relations');


//endpoint relaionados



// function registrar_endpoint_busqueda_relacionados_post()
// {
//     register_rest_route('ordenes_cristal/v1', '/get_related', array(
//         'methods' => 'POST',
//         'callback' => 'buscar_productos_relacionados',
//     ));
// }
// add_action('rest_api_init', 'registrar_endpoint_busqueda_relacionados_post');

// // Función de devolución de llamada para buscar productos desde el endpoint por POST
// function buscar_productos_relacionados($request)
// {

//     $params = $request->get_params();
//     $id = $params['id'];
//     $relacionados = obtener_productos_relacionados_por_padre($id);


//     // Devolver los productos encontrados como respuesta JSON
//     return rest_ensure_response($relacionados);
// }



// /**
//  * Función para obtener productos relacionados por ID de producto padre.
//  *
//  * @param int $parent_product_id El ID del producto padre.
//  * @param int $limit (Opcional) Límite de productos relacionados a obtener.
//  * @return array Array de IDs de productos relacionados.
//  */
// function obtener_productos_relacionados_por_padre($parent_product_id, $limit = -1)
// {
//     // Obtener los productos hijos del producto padre.
//     global $product;

//     $productos_con_info = array();
//     $product_id = $parent_product_id;
//     $post = get_post($product_id);
//     if ($post) {
//         $related_products = array();
//         $product = wc_get_product($product_id);
//         $related = $product->get_children();

//         if (!empty($related)) {

//             foreach ($related as $related_id) {

//                 $pr = wc_get_product($related_id);

//                 $related_products[] = $pr;
//             }
//         }

//         foreach ($related_products as $productoi) {
//             $precio_producto = get_post_meta($productoi->get_id(), '_price', true);
//             $imagen_producto_id = get_post_thumbnail_id($productoi->get_id());
//             $imagen_producto_url = wp_get_attachment_url($imagen_producto_id);
//             $imagen_miniatura = get_the_post_thumbnail_url($productoi->get_id(), 'thumbnail');
//             $sku_producto = get_post_meta($productoi->get_id(), '_sku', true); // Obtener el SKU del producto
//             $marca_id_producto = get_post_meta($productoi->get_id(), '_marca_producto', true);

//             // Obtener las categorías asociadas al producto con todos los campos y metacampos
//             $categorias_producto = wp_get_post_terms($productoi->get_id(), 'product_cat');

//             // Almacenar la información relevante de cada categoría asociada al producto
//             $categorias_producto_info = array();
//             foreach ($categorias_producto as $categoria_producto) {
//                 // Obtener todos los detalles de la categoría, incluidos los metacampos
//                 $categoria_info = get_term_by('id', $categoria_producto->term_id, 'product_cat');
//                 $categorias_producto_info[] = $categoria_info;
//             }



//             $productos_con_info[] = array(
//                 'ID' => $productoi->get_id(),
//                 'post_title' => $productoi->get_title(),
//                 'post_content' => $productoi->get_description(),
//                 'price' => $precio_producto,
//                 'image_url' => $imagen_producto_url,
//                 'thumbnail_prod' => $imagen_miniatura,
//                 'sku' => $sku_producto,
//                 'categorias' => $categorias_producto_info, // Agregar las categorías del producto al resultado
//                 'marca' => $marca_id_producto,
//                 'observacion' => ''
//             );
//         }

//         return $productos_con_info;
//     } else {
//         return array();
//     }
// }





// Registrar endpoint personalizado para buscar productos por POST
function registrar_endpoint_busqueda_productos_post()
{
    register_rest_route('ordenes_cristal/v1', '/buscar_productos', array(
        'methods' => 'POST',
        'callback' => 'buscar_productos_endpoint_post',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_busqueda_productos_post');


// Función de devolución de llamada para buscar productos desde el endpoint por POST
function buscar_productos_endpoint_post($request)
{
    $params = $request->get_params();
    $nombre = isset($params['nombre']) ? $params['nombre'] : '';
    $marca = isset($params['marca']) ? $params['marca'] : null;
    $categoria = isset($params['categoria']) ? $params['categoria'] : null;
    $tienda = isset($params['categoria']) ? $params['categoria'] : null;
    $page  = isset($params['page']) ? $params['page'] : 1;
    $term  = isset($params['term']) ? $params['term'] : '';

    // Llamar a la función buscar_productos con los parámetros proporcionados
    $productos_encontrados = buscar_productos($nombre, $marca, $categoria, $tienda, $page, $term);

    // Devolver los productos encontrados como respuesta JSON
    return rest_ensure_response($productos_encontrados);
}


function obtener_post_type_tienda_por_titulo($titulo_tienda)
{
    $args = array(
        'post_type' => 'tiendas',
        'post_title' => $titulo_tienda,
        'posts_per_page' => 1, // Solo necesitamos un post
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        return $posts[0];
    } else {
        return null;
    }
}


function obtener_post_type_marca_por_titulo($titulo_marca)
{
    $args = array(
        'post_type' => 'marcas',
        'post_title' => $titulo_marca,
        'posts_per_page' => 1, // Solo necesitamos un post
    );

    $posts = get_posts($args);
    if (!empty($posts)) {
        return $posts[0];
    } else {
        return null;
    }
}

function buscar_productos($nombre = '', $marca_id = null, $categoria_id = null, $tienda_id = null, $paged = 1, $term = '')
{
    global $wpdb;

    $tabla_productos = 'productos';
    $tabla_materiales_relacionados = 'wp_materiales_relacionados';

    // Construir la condición de filtrado por categoría
    $categoria_filter = "1=1";  // Por defecto, condición siempre verdadera
    if ($categoria_id !== null) {
        $categoria_filter = "p.categorias LIKE '%" . esc_sql($categoria_id) . "%'";
    }

    $marca_filter = "1=1";  // Por defecto, condición siempre verdadera
    if ($marca_id !== null) {
        $marca_filter = "p.marca LIKE '%" . esc_sql($marca_id) . "%'";
    }

    $sqlb = "SELECT *, 
                    IFNULL((SELECT consecutivo FROM consecutivos_materiales u 
                            WHERE u.id_material = p.id AND u.id_marca = '" . esc_sql($marca_id) . "'), '1') AS consecutivo 
             FROM $tabla_productos p 
             WHERE $categoria_filter AND $marca_filter";

    $sqlw = "";

    $for_page = 5; // Número de productos por página
    $offset = ($paged - 1) * $for_page;

    if (!empty($term)) {
        $sqlw = " AND (p.post_title LIKE '%" . esc_sql($term) . "%' OR p.codigo_sap LIKE '%" . esc_sql($term) . "%')";
    }

    // Construir la consulta completa con paginación
    $sql = $sqlb . ' ' . $sqlw . ' ORDER BY CAST(consecutivo AS UNSIGNED) ASC LIMIT ' . intval($offset) . ', ' . intval($for_page);



    $product_list = $wpdb->get_results($sql, OBJECT);
    $productos_con_info = array();

    $items_categorias = get_categories_relation_data();

    foreach ($product_list as $producto) {
        $cats_format = [];
        $cat_p = explode(',', $producto->categorias);
        foreach ($cat_p as $cat) {
            $cat_sel = findCategorytById($cat, $items_categorias);
            if (isset($cat_sel->id)) {
                $cats_format[] = (object) array('term_id' => $cat_sel->id, 'name' => $cat_sel->nombre);
            }
        }



        // Obtener los materiales relacionados

        $materiales_relacionados = $wpdb->get_results($wpdb->prepare("SELECT id_material, cantidad_defecto FROM wp_materiales_relacionados WHERE id_padre = %d", $producto->id), OBJECT);
        $producto->related = [];
        $ids_m = array();
        foreach ($materiales_relacionados as $mat) {
            array_push($ids_m, $mat->id_material);
        }

        if (!empty($ids_m)) {
            // Obtener los datos de los materiales relacionados
            $related_materials = $wpdb->get_results("
                        SELECT m.*, r.cantidad_defecto
                        FROM wp_materiales_relacionados AS r
                        INNER JOIN $tabla_productos AS m ON r.id_material = m.ID
                        WHERE r.id_padre = '$producto->id'
                    ", OBJECT);

            // Añadir los materiales relacionados al objeto herraje
            $producto->related = $related_materials;
        }

        $productos_con_info[] = array(
            'ID' => $producto->id,
            'post_title' => $producto->post_title,
            'post_content' => $producto->post_content,
            'order' => $producto->consecutivo,
            'price' => $producto->price,
            'image_url' => $producto->image_url,
            'thumbnail_prod' => $producto->thumbnail_prod,
            'codigo_sap' => $producto->codigo_sap,
            'cuenta' => $producto->cuenta,
            'categorias' => $cats_format, // Agregar las categorías del producto al resultado
            'marca' => $producto->marca,
            'observacion' => $producto->observacion,
            'tipo' => $producto->tipo,
            'related' => $producto->related,
            'tipo_imputacion' => $producto->tipo_imputacion
        );
    }

    // Obtener el número total de productos para calcular el número de páginas
    $total_sql2 = "
        SELECT COUNT(*) 
        FROM (
            SELECT p.id
            FROM $tabla_productos p
            LEFT JOIN $tabla_materiales_relacionados mr1 ON p.id = mr1.id_padre
            LEFT JOIN $tabla_materiales_relacionados mr2 ON p.id = mr2.id_material
            WHERE mr1.id_padre IS NULL AND mr2.id_material IS NULL 
                  AND $categoria_filter AND $marca_filter $sqlw

            UNION

            SELECT p.id
            FROM $tabla_productos p
            INNER JOIN $tabla_materiales_relacionados mr ON p.id = mr.id_padre
            WHERE  $categoria_filter AND $marca_filter $sqlw
        ) AS combined
    ";

    $total_sql = "SELECT COUNT(*)  AS combined FROM $tabla_productos p WHERE $categoria_filter AND $marca_filter";



    $total_products = $wpdb->get_var($total_sql);

    $num_pages = ceil($total_products / $for_page);

    return ['productos' => $productos_con_info, 'num_pages' => $num_pages, 'for_page' => $for_page];
}





function get_categories_relation_data()
{
    global $wpdb;

    // Nombre de las tablas
    $tabla_categorias =  'categorias';
    $tabla_relacion =  'relacion_categorias';

    // Consulta SQL para seleccionar categorías que no tienen padres relacionados
    $query = "SELECT * from categorias";

    $categorias_r = $wpdb->get_results($query, OBJECT);


    return $categorias_r;
}




add_filter('posts_request', function ($query) {
    error_log($query);
    return $query;
});





function obtener_categorias()
{
    $categorias = get_terms(array(
        'taxonomy' => 'product_cat', // Taxonomía de categorías de WooCommerce
        'hide_empty' => false, // Incluir categorías incluso si están vacías
    ));

    return $categorias;
}

function obtener_marcas()
{
    $marcas = get_posts(array(
        'post_type'      => 'marcas',
        'posts_per_page' => -1,
    ));


    $marcas_con_imagenes = array();

    foreach ($marcas as $marca) {
        $imagen_url = get_the_post_thumbnail_url($marca->ID, 'full');

        $marca_info = array(
            'ID'   => $marca->ID,
            'post_title'    => $marca->post_title,
            'post_content' => $marca->post_content,
            'image'    => $imagen_url,
            // Puedes añadir más información del post si la necesitas
        );

        $marcas_con_imagenes[] = $marca_info;
    }

    return $marcas_con_imagenes;
}


function obtener_tiendas()
{
    // Define los parámetros de la consulta
    $args = array(
        'post_type'      => 'tiendas',
        'posts_per_page' => -1,
        'meta_key'       => 'metros_cuadrados', // Especifica el meta campo que deseas recuperar
    );

    // Realiza la consulta
    $tiendas = get_posts($args);

    // Verifica si se encontraron tiendas
    if ($tiendas) {
        // Itera sobre cada tienda encontrada
        foreach ($tiendas as $tienda) {
            // Obtén el valor del meta campo 'metros_cuadrados' para cada tienda
            $metros_cuadrados = get_post_meta($tienda->ID, 'metros_cuadrados', true);

            // Agrega el valor del meta campo al objeto de la tienda
            $tienda->metros_cuadrados = $metros_cuadrados;
            $tienda->post_title = str_replace('-', ' ', $tienda->post_title);
        }
    }

    // Devuelve el array de tiendas con los valores de 'metros_cuadrados' agregados
    return $tiendas;
}


// Registrar la ruta del endpoint
function registrar_endpoint_obtener_tiendas()
{
    register_rest_route('ordenes_cristal/v1', '/obtener_tiendas', array(
        'methods'  => 'GET',
        'callback' => 'obtener_tiendas_callback',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_obtener_tiendas');

// Callback para obtener las tiendas y sus metadatos
function obtener_tiendas_callback($data)
{
    $args = array(
        'post_type'      => 'tiendas',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    $tiendas = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $tienda = array(
                'id'            => get_the_ID(),
                'titulo'        => preg_replace('/[^a-zA-Z0-9 ]/', '', get_the_title()),
                'contenido'     => get_the_content(),
                'imagen'        => get_the_post_thumbnail_url(),
                'metros_cuadrados' => get_post_meta(get_the_ID(), 'metros_cuadrados', true),
            );
            $tiendas[] = $tienda;
        }
        wp_reset_postdata();
    }

    return $tiendas;
}

// Hook para asignar valores ideales cuando se crea una nueva marca
function asignar_valores_ideales_por_defecto($post_id, $post, $update)
{


    if ($post->post_type == 'marcas' && !$update) {
        global $wpdb;
        $tabla_valores_ideales = $wpdb->prefix . 'valores_ideales';

        echo "asignano valores ideales por defecto " . $tabla_valores_ideales;

        // Obtener todas las categorías de productos
        $categorias = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));

        // Insertar registros en la tabla valores_ideales con valor por defecto
        foreach ($categorias as $categoria) {
            if ($categoria->slug != 'uncategorized') {
                $wpdb->insert(
                    $tabla_valores_ideales,
                    array(
                        'marca_id' => $post_id,
                        'categoria_id' => $categoria->term_id,
                        'valor_ideal' => 0,
                    )
                );
            }
        }
    }
}
add_action('save_post', 'asignar_valores_ideales_por_defecto', 10, 3);

// Agregar endpoint personalizado para manejar la actualización del valor ideal
add_action('rest_api_init', 'registrar_endpoint_actualizar_valor_ideal');

function registrar_endpoint_actualizar_valor_ideal()
{
    register_rest_route('ordenes_cristal/v1', '/actualizar_valor_ideal/', array(
        'methods' => 'POST',
        'callback' => 'actualizar_valor_ideal_callback',
        'permission_callback' => '__return_true' // Permitir acceso a todos
    ));
}

function actualizar_valor_ideal_callback($request)
{
    global $wpdb;

    // Obtener los parámetros enviados en la solicitud
    $marca_id = $request->get_param('marca_id');
    $categoria_id = $request->get_param('categoria_id');
    $nuevo_valor_ideal = $request->get_param('valor_ideal');

    // Verificar si el registro existe
    $registro_existente = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}valores_ideales WHERE marca_id = %d AND categoria_id = %d",
            $marca_id,
            $categoria_id
        )
    );

    if ($registro_existente) {
        // Si el registro existe, actualizar el valor ideal
        $result = $wpdb->update(
            $wpdb->prefix . 'valores_ideales',
            array('valor_ideal' => $nuevo_valor_ideal),
            array('marca_id' => $marca_id, 'categoria_id' => $categoria_id),
            array('%f'),
            array('%d', '%d')
        );

        if ($result !== false) {
            return new WP_REST_Response(array('message' => 'Valor ideal actualizado correctamente'), 200);
        } else {
            return new WP_Error('actualizacion_error', 'Error al actualizar el valor ideal', array('status' => 500));
        }
    } else {
        // Si el registro no existe, insertarlo
        $result = $wpdb->insert(
            $wpdb->prefix . 'valores_ideales',
            array(
                'marca_id' => $marca_id,
                'categoria_id' => $categoria_id,
                'valor_ideal' => $nuevo_valor_ideal
            ),
            array('%d', '%d', '%f')
        );

        if ($result !== false) {
            return new WP_REST_Response(array('message' => 'Nuevo valor ideal insertado correctamente'), 200);
        } else {
            return new WP_Error('insercion_error', 'Error al insertar el nuevo valor ideal', array('status' => 500));
        }
    }
}



// Agregar endpoint personalizado para manejar la actualización del valor ideal
add_action('rest_api_init', 'obtener_valores_ideales');

function obtener_valores_ideales()
{
    register_rest_route('ordenes_cristal/v1', '/obtener_valores_ideales/', array(
        'methods' => 'POST',
        'callback' => 'consultar_valores_ideales_callback',
        'permission_callback' => '__return_true' // Permitir acceso a todos
    ));
}



function consultar_valores_ideales_callback($request)
{
    global $wpdb;

    // Obtener los parámetros enviados en la solicitud
    $marca_id = $request->get_param('marca');
    $categorias_string = $request->get_param('categorias');


    // Realizar la consulta para obtener los valores ideales
    $query = "
        SELECT *
        FROM {$wpdb->prefix}valores_ideales
        WHERE marca_id = $marca_id
        AND categoria_id IN ($categorias_string)
    ";



    $valores_ideales = $wpdb->get_results($query);

    if ($valores_ideales) {
        // Devolver los valores ideales encontrados
        return new WP_REST_Response($valores_ideales, 200);
    } else {
        // No se encontraron valores ideales para los parámetros dados
        return new WP_Error('sin_valores_ideales', 'No se encontraron valores ideales para la marca y categorías indicadas', array('status' => 404));
    }
}





function registrar_endpoint_guardar_material()
{
    register_rest_route('ordenes_cristal/v1', '/guardar_material', array(
        'methods' => 'POST',
        'callback' => 'save_material',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_guardar_material');


function save_material()
{
    global $wpdb;

    // Verificar los datos enviados y sanitizarlos
    $post_title = sanitize_text_field($_POST['post_title']);
    $codigo_sap = sanitize_text_field($_POST['codigo_sap']);
    $cuenta = sanitize_text_field($_POST['cuenta']);
    $tipo_imputacion = sanitize_text_field($_POST['tipo_imputacion']);
    $order = sanitize_text_field($_POST['order']);
    $price = sanitize_text_field($_POST['price']);
    $marca = sanitize_text_field($_POST['marca']);
    $tipo = sanitize_text_field($_POST['tipo']);
    $categorias = $_POST['categorias'];
    $post_content = sanitize_text_field($_POST['post_content']);
    $observacion = sanitize_text_field($_POST['observacion']);


    $files_order_complete_path = [];

    // Subir archivos adjuntos
    $archivos = [];
    $upload_dir = wp_upload_dir();

    if (isset($_FILES['files'])) {
        $upload_dir = wp_upload_dir(); // Obtiene la información del directorio de subidas de WordPress
        $upload_path = $upload_dir['path']; // Ruta del directorio de subidas

        $archivos = array(); // Array para almacenar las URLs de los archivos

        // Recorre cada archivo cargado
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $file_name = str_replace(" ", "_", $_FILES['files']['name'][$key]);
            $file_path = $upload_path . '/' . $file_name; // Ruta completa del archivo en el servidor

            // Mueve el archivo al directorio de subidas de WordPress
            move_uploaded_file($tmp_name, $file_path);
            // Sube el archivo a WordPress y obtén su ID de adjunto
            $attachment_id = wp_insert_attachment(array(
                'guid' => $upload_dir['url'] . '/' . $file_name,
                'post_mime_type' => $_FILES['files']['type'][$key],
                'post_title' => $file_name,
                'post_content' => '',
                'post_status' => 'inherit'
            ), $file_path);

            // Genera el enlace de descarga directa para el archivo adjunto
            $file_url = wp_get_attachment_url($attachment_id);

            // Almacena la URL del archivo
            $archivos[] = $file_url;
        }

        $files_order_complete_path = $archivos;
    }

    // Insertar los datos en la tabla
    $table_name = 'productos';

    if (count($files_order_complete_path) > 0) {
        $data = array(
            'codigo_sap' => $codigo_sap,
            'cuenta' => $cuenta,
            'tipo_imputacion' => $tipo_imputacion,
            'order' => $order,
            'post_title' => $post_title,
            'price' => $price,
            'marca' => $marca,
            'tipo' => $tipo,
            'categorias' => $categorias,
            'image_url' => $files_order_complete_path[0],
            'thumbnail_prod' => '',
            'post_content' => $post_content,
            'observacion' => $observacion
        );
        $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
    } else {
        $data = array(
            'codigo_sap' => $codigo_sap,
            'cuenta' => $cuenta,
            'tipo_imputacion' => $tipo_imputacion,
            'order' => $order,
            'post_title' => $post_title,
            'price' => $price,
            'marca' => $marca,
            'tipo' => $tipo,
            'categorias' => $categorias,
            'thumbnail_prod' => '',
            'post_content' => $post_content,
            'observacion' => $observacion
        );
        $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
    }

    if (isset($_POST['edit']) && intval($_POST['edit']) > 0) {
        $where = array('id' => $_POST['edit']);
        $where_format = array('%d');
        $success = $wpdb->update($table_name, $data, $where, $format, $where_format);
        $padre_id = $_POST['edit'];
    } else {
        $format = array('%s', '%s', '%s', '%s',  '%s', '%s', '%s', '%s', '%s', '%s');
        $success = $wpdb->insert($table_name, $data, $format);
        $padre_id = $wpdb->insert_id;
    }


    $related_m = [];
    $consecutivo_m = [];

    if ($success == true || $success == 0) {

        if (isset($_POST['consecutivos_marca'])) {

            $consecutivos = $_POST['consecutivos_marca'];

            foreach ($consecutivos as $consecutivo) {

                $items_p = explode(",", $consecutivo);
                $temp_array = [];


                foreach ($items_p as $sk) {
                    $parts = explode("=", $sk);

                    if (count($parts) == 2) {

                        $key = trim($parts[0]);
                        $value = trim($parts[1]);
                        $temp_array[$key] = $value;
                    } else {
                        //errors
                    }
                }

                if (!empty($temp_array)) {
                    $consecutivo_m[] = $temp_array;


                }
            }



        } else {
            $consecutivos = [];
        }



        if (isset($_POST['relatedcants'])) {
            // Decodificar la cadena JSON en un array PHP
            $array = $_POST['relatedcants'];

            foreach ($array as $related) {

                $items_p = explode(",", $related);
                $temp_array = [];


                foreach ($items_p as $sk) {
                    $parts = explode("=", $sk);

                    if (count($parts) == 2) {

                        $key = trim($parts[0]);
                        $value = trim($parts[1]);
                        $temp_array[$key] = $value;
                    } else {
                        //errors
                    }
                }

                if (!empty($temp_array)) {
                    $related_m[] = $temp_array;
                }
            }
        } else {

            $array = [];
        }



        // Eliminar relaciones existentes si es una edición
        if (isset($_POST['edit']) && intval($_POST['edit']) > 0) {
            $wpdb->delete('consecutivos_materiales', array('id_material' => $padre_id), array('%d'));
            $wpdb->delete('wp_materiales_relacionados', array('id_padre' => $padre_id), array('%d'));
        }


        // Guardar consecutivos nuevas
        $consecutivos_materiales = $consecutivo_m;

        foreach ($consecutivos_materiales as $consecutivo) {


            $id_marca = $consecutivo['id_marca'];
            $consecutivo = $consecutivo['consecutivo'];
            $wpdb->insert(
                'consecutivos_materiales',
                array(
                    'id_material' => $padre_id,
                    'id_marca' => $id_marca,
                    'consecutivo' => (int) $consecutivo
                ),
                array(
                    '%d', // id_material
                    '%d', // id_marca
                    '%d'  // consecutivo
                )
            );
        
      //  echo $wpdb->last_error;
        }



        // Guardar relaciones nuevas
        $materiales_relacionados = $related_m;

        foreach ($materiales_relacionados as $product) {



            $id_material = $product['id'];
            $cantidad_defecto = $product['cantidad_defecto'];


            $wpdb->insert(
                'wp_materiales_relacionados',
                array(
                    'id_padre' => $padre_id,
                    'id_material' => $id_material,
                    'cantidad_defecto' => $cantidad_defecto
                ),
                array(
                    '%d', // id_padre
                    '%d', // id_material
                    '%s'  // cantidad_defecto
                )
            );
        }

        return json_encode(array("result" => "success", "message" => 'Producto añadido correctamente.'));
    } else {
        return json_encode(array("result" => "error", "message" => 'No se pudo agregar el producto.'));
    }
}


function mostrar_campo_marca($post)
{
    $marca_producto = get_post_meta($post->ID, '_marca_producto', true);
?>
    <label for="marca_producto"><?php _e('Marcca:', 'text-domain'); ?></label>
    <input type="text" id="marca" name="marca" value="<?php echo esc_attr($marca_producto); ?>" />
<?php
}



// Agregar campo select para relacionar marca al producto
add_action('woocommerce_product_options_general_product_data', 'agregar_metabox_marca_producto');


function agregar_metabox_marca_producto()
{
    add_meta_box(
        '_marca_producto',
        __('Marca', 'text-domain'),
        'mostrar_metabox_marca_producto',
        'product',
        'normal',
        'default'
    );
}



// Mostrar la metabox para seleccionar la marca
function mostrar_metabox_marca_producto()
{
    global $post;

    // Obtenemos las marcas asociadas al producto, si existen
    $marca_ids = get_post_meta($post->ID, '_marca_producto', true);

    // Asegurarse de que $marca_ids es un array
    if (!is_array($marca_ids)) {
        $marca_ids = array();
    }

    // Obtenemos todas las marcas
    $marcas = get_posts(array(
        'post_type' => 'marcas',
        'posts_per_page' => -1,
    ));

    // Creamos una lista de checkboxes para seleccionar la marca
    echo '<label>Marca del Producto:</label><br>';

    foreach ($marcas as $marca) {
        $checked = in_array($marca->ID, $marca_ids) ? 'checked' : '';
        echo '<input type="checkbox" id="marca_producto_' . esc_attr($marca->ID) . '" name="_marca_producto[]" value="' . esc_attr($marca->ID) . '" ' . esc_attr($checked) . '>';
        echo '<label for="marca_producto_' . esc_attr($marca->ID) . '">' . esc_html($marca->post_title) . '</label><br>';
    }

    // Añadimos un campo nonce para la verificación de seguridad
    wp_nonce_field('guardar_valor_marca_producto', 'marca_producto_nonce');
}

function guardar_valor_marca_producto($post_id)
{
    // Verifica que es una solicitud legítima
    if (!isset($_POST['marca_producto_nonce']) || !wp_verify_nonce($_POST['marca_producto_nonce'], 'guardar_valor_marca_producto')) {
        return $post_id;
    }

    // Asegurarse de que el usuario tiene permiso para editar el post
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Si no hay valores, eliminamos la metadato
    if (!isset($_POST['_marca_producto'])) {
        delete_post_meta($post_id, '_marca_producto');
        return $post_id;
    }

    // Sanitizar y guardar los IDs de las marcas
    $marca_ids = array_map('sanitize_text_field', $_POST['_marca_producto']);
    update_post_meta($post_id, '_marca_producto', $marca_ids);
}

add_action('save_post', 'guardar_valor_marca_producto');


// Nonce validation
function validate_nonce($nonce_name)
{
    if (!wp_verify_nonce($_POST['nonce'], $nonce_name)) {
        $res = [
            'status' => 0,
            'message' => '✋ Error nonce validation!!'
        ];
        echo json_encode($res);
        wp_die();
    }
}


// Registrar la ruta del endpoint para guardar la orden
function registrar_endpoint_guardar_orden()
{
    register_rest_route('ordenes_cristal/v1', '/guardar_orden', array(
        'methods' => 'POST',
        'callback' => 'handle_order_save_request',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_guardar_orden');



//Función para manejar las solicitudes POST al endpoint /guardar_orden
function handle_order_save_request($request)
{
    // Obtener los datos del cuerpo de la solicitud
    $params = $request->get_params();


    $files_order_complete_path = [];

    // Subir archivos adjuntos
    $archivos = [];
    $upload_dir = wp_upload_dir();

    if (isset($_FILES['file_order'])) {
        $upload_dir = wp_upload_dir(); // Obtiene la información del directorio de subidas de WordPress
        $upload_path = $upload_dir['path']; // Ruta del directorio de subidas

        if (isset($params['files_edit'])) {

            $archivos = json_decode($params['files_edit']); // Array para almacenar las URLs de los archivos

        } else {

            $archivos = array(); // Array para almacenar las URLs de los archivos

        }

        // Recorre cada archivo cargado
        foreach ($_FILES['file_order']['tmp_name'] as $key => $tmp_name) {
            $file_name = str_replace(" ", "_", $_FILES['file_order']['name'][$key]);
            $file_path = $upload_path . '/' . $file_name; // Ruta completa del archivo en el servidor

            // Mueve el archivo al directorio de subidas de WordPress
            move_uploaded_file($tmp_name, $file_path);

            // Sube el archivo a WordPress y obtén su ID de adjunto
            $attachment_id = wp_insert_attachment(array(
                'guid' => $upload_dir['url'] . '/' . $file_name,
                'post_mime_type' => $_FILES['file_order']['type'][$key],
                'post_title' => $file_name,
                'post_content' => '',
                'post_status' => 'inherit'
            ), $file_path);

            // Genera el enlace de descarga directa para el archivo adjunto
            $file_url = wp_get_attachment_url($attachment_id);

            // Almacena la URL del archivo
            //echo "furl ".$file_url;
            $archivos[] = $file_url;
        }

        $files_order_complete_path = $archivos;

        // $archivos ahora contiene las URLs de los archivos cargados en WordPress
        // Puedes usar este array para descargar los archivos más tarde
    }

    // Verificar si se enviaron los datos de la orden
    if (isset($params['items'])) {
        // Si el usuario está logueado, obtener su ID
        $user = wp_get_current_user();
        $user_id = $user->ID;

        if ($user_id) {
            global $wpdb;
            $orden_table_name = $wpdb->prefix . 'orden';
            $orden_items_table_name = $wpdb->prefix . 'orden_items';

            // Obtener los datos de la orden del cuerpo de la solicitud


            $totalOrden = $params['total_order'];
            $marca = $params['marca'];
            $image_marca = $params['image_marca'];
            $name_marca = $params['name_marca'];
            $tienda = $params['tienda'];
            $tienda_name = $params['tienda_name'];
            $observaciones = $params['observaciones'];
            $tems = json_decode($params['items']);

            $links = $params['links'];

            // Verificar si se proporcionó un ID de orden para actualizar
            if (isset($params['orden_id'])) {
                $order_id = intval($params['orden_id']);

                // Actualizar la orden en la tabla de órdenes
                $wpdb->update(
                    $orden_table_name,
                    array(
                        'totalOrden' => $totalOrden,
                        'marca' => $marca,
                        'image_marca' => $image_marca,
                        'name_marca' => $name_marca,
                        'tienda' => $tienda,
                        'tienda_name' => $tienda_name,
                        'links' => $links,
                        'fichero_adjunto' => json_encode($files_order_complete_path),
                        'observaciones' => $observaciones
                    ),
                    array('id' => $order_id)
                );




                // Eliminar los elementos de la orden existentes en la tabla de items de la orden
                $wpdb->delete(
                    $orden_items_table_name,
                    array('order_id' => $order_id)
                );



                // Insertar los nuevos elementos de la orden en la tabla de items de la orden
                foreach ($tems as $item) {

                    $update_item_r = $wpdb->insert(
                        $orden_items_table_name,
                        array(
                            'order_id' => $order_id,
                            'ID' => $item->ID,
                            'post_title' => $item->post_title,
                            'post_content' => $item->post_content,
                            'cnt' => $item->cnt,
                            'observacion' => $item->observacion,
                            'price' => $item->price,
                            'categorias' => json_encode($item->categorias),
                            'subtotal' => $item->subtotal,
                            'codigo_sap' => $item->codigo_sap,
                            'tipo_imputacion' => $item->tipo_imputacion,
                            'image_url' => $item->image_url
                        )
                    );

                    echo $wpdb->last_error;
                }



                return array('success' => true, 'message' => 'Order updated successfully', 'order_id' => $order_id);
            } else {
                // Si no se proporcionó un ID de orden, se crea una nueva orden
                // Insertar la nueva orden en la tabla de órdenes
                $fecha_actual = current_time('mysql');



                $resultado_insercion_order = $wpdb->insert(
                    $orden_table_name,
                    array(
                        'fecha_orden' => $fecha_actual,
                        'cliente' => $user_id,
                        'cliente_name' => $user->display_name,
                        'totalOrden' => $totalOrden,
                        'marca' => $marca,
                        'image_marca' => $image_marca,
                        'name_marca' => $name_marca,
                        'links' => $links,
                        'fichero_adjunto' => json_encode($files_order_complete_path),
                        'tienda' => $tienda,
                        'tienda_name' => $tienda_name,
                        'is_send' => 0,
                        'observaciones' => $observaciones
                    )
                );


                // echo $wpdb->last_query;

                // echo "----------------";

                // // Print last SQL query Error
                // echo $wpdb->last_error;

                if ($resultado_insercion_order !== false) {
                    // Obtener el ID de la orden recién creada
                    $order_id = $wpdb->insert_id;

                    // Insertar los elementos de la orden en la tabla de items de la orden
                    foreach ($tems as $item) {

                        $wpdb->insert(
                            $orden_items_table_name,
                            array(
                                'order_id' => $order_id,
                                'ID' => $item->ID,
                                'post_title' => $item->post_title,
                                'post_content' => $item->post_content,
                                'cnt' => $item->cnt,
                                'observacion' => $item->observacion,
                                'price' => $item->price,
                                'categorias' => json_encode($item->categorias),
                                'subtotal' => $item->subtotal,
                                'codigo_sap' => $item->codigo_sap,
                                'tipo_imputacion' => $item->tipo_imputacion,
                                'image_url' => $item->image_url
                            )
                        );
                    }

                    //echo $wpdb->last_error;
                    //mail_order($order_id);   
                    return array('success' => true, 'message' => 'Order saved successfully', 'order_id' => $order_id);
                } else {
                    // Si la inserción de la orden falla, devuelve un mensaje de error
                    return array('error' => false, 'message' => 'Error: Failed to insert order');
                }
            }
        } else {
            // Si el usuario no está logueado, devuelve un mensaje de error
            return array('success' => false, 'message' => 'Error: User not logged in');
        }
    } else {
        // Si faltan datos de la orden, devuelve un mensaje de error
        return array('success' => false, 'message' => 'Error: Missing order data');
    }
}



function get_orders_list()
{

    global $wpdb;
    $orden_table_name = $wpdb->prefix . 'orden';
    $orden_items_table_name = $wpdb->prefix . 'orden_items';
    $usuarios_table_name = $wpdb->prefix . 'users';

    $out_data = [];

    $query = "SELECT o.*, u.display_name AS cliente_name 
          FROM $orden_table_name AS o 
          INNER JOIN $usuarios_table_name AS u ON o.cliente = u.ID
          ORDER BY o.id DESC";


    $orders = $wpdb->get_results($query);
    foreach ($orders as $order) {

        $order_items = $wpdb->get_results("SELECT * FROM $orden_items_table_name where order_id = $order->id");

        array_push($out_data, ['order' => $order, 'items' => $order_items]);
    }

    return $out_data;
}

// Hook para registrar un shortcode que mostrará el formulario de inicio de sesión
add_shortcode('custom_login_form', 'custom_login_form_shortcode');

function custom_login_form_shortcode($atts)
{
    if (is_user_logged_in()) {
        return '<p>Ya estás conectado.</p>';
    }

    // Mensaje de error si hay algún error de inicio de sesión
    $error = '';
    if (isset($_GET['login']) && $_GET['login'] === 'failed') {
        $error = '<p class="error">Credenciales inválidas. Inténtalo de nuevo.</p>';
    }

    // Mostrar formulario de inicio de sesión
    $form = '<form id="login-form">
    <p>
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username">
    </p>
    <p>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input type="submit" value="Iniciar sesión">
    </p>

    <div id="login-error"></div>
</form>';

    return $error . $form;
}

add_action('wp_ajax_custom_login', 'custom_login');
add_action('wp_ajax_nopriv_custom_login', 'custom_login');

function custom_login()
{
    // Comprueba si se ha enviado el formulario
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $creds = array(
            'user_login'    => $_POST['username'],
            'user_password' => $_POST['password'],
            'remember'      => true
        );

        // Iniciar sesión del usuario
        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            // Si hay un error de inicio de sesión, devuelve un mensaje de error
            wp_send_json_error(array('message' => $user->get_error_message()));
        } else {
            // Si el inicio de sesión es exitoso, devuelve un mensaje de éxito
            wp_send_json_success(array('message' => 'Inicio de sesión exitoso'));
        }
    }

    // Si no se ha enviado el formulario, devuelve un mensaje de error
    wp_send_json_error(array('message' => 'Error: los campos de inicio de sesión están vacíos'));
}



add_action('wp_ajax_mail_order', 'mail_order');
add_action('wp_ajax_nopriv_mail_order', 'mail_order');




function mail_order()
{


    global $wpdb;

    $order_id = $_POST['order_id'];


    $logo_url = site_url('wp-content/uploads/2024/03/Logo-crystal.png');

    // Realiza la consulta para obtener los datos de la orden
    $orden_table_name = $wpdb->prefix . 'orden';
    $query_orden = $wpdb->prepare("
           SELECT *
           FROM $orden_table_name
           WHERE id = %d
       ", $order_id);

    // Realiza la consulta para obtener los elementos de la orden
    $orden_items_table_name = $wpdb->prefix . 'orden_items';
    $query_items = $wpdb->prepare("
           SELECT *
           FROM $orden_items_table_name
           WHERE order_id = %d
       ", $order_id);

    $orden_data = $wpdb->get_row($query_orden); // Obtiene solo un registro
    $items_orden = $wpdb->get_results($query_items); // Obtiene una lista de elementos

    $links = json_decode($orden_data->links);

    $adjuntos = json_decode($orden_data->fichero_adjunto);


    $strdjuntos = '';
    $ad = 1;
    foreach ($adjuntos as $adjunto) {
        $strdjuntos .=  '<p><a href="' . $adjunto . '">Adjunto ' . $ln . '</a></p>';

        $ad++;
    }


    $stlnks = '';
    $ln = 1;
    foreach ($links as $link) {
        $stlnks .=  '<p><a href="' . $link . '">Link ' . $ln . '</a></p>';

        $ln++;
    }
    // Actualiza el campo is_send a 1 para el registro con el ID especificado
    // $result = $wpdb->update(
    //     $orden_table_name,
    //     array('is_send' => '1'),
    //     array('id' => $order_id),
    //     array('%d'),
    //     array('%d')
    // );


    ob_start(); // Comenzar el almacenamiento en búfer de salida
    // Incluir la plantilla de correo
    include 'templates/orderMail.php';

    // Obtener el contenido del búfer y limpiar el búfer de salida
    $mensaje = ob_get_clean();

    // Obtener el email destino enviar
    $para = get_option('mail_to_order');

    // Asunto del correo electrónico
    $asunto = 'Correo de confirmación de pedido';

    // Cabeceras del correo electrónico (opcional)
    $cabeceras = array(
        'Content-Type: text/html; charset=UTF-8',
    );

    //prov 
    // Actualizar el campo 'is_send' a 1 en la base de datos
    $orden_table_name = $wpdb->prefix . 'orden';
    $wpdb->update(
        $orden_table_name,
        array('is_send' => '1'),
        array('id' => $order_id) //  ID de la orden
    );



    // Envío del correo electrónico
    $enviado = wp_mail($para, $asunto, $mensaje, $cabeceras);



    //header('Content-Type: application/json');
    // Verificar si el correo electrónico se envió correctamente
    if ($enviado) {
        echo json_encode(array('result' => 'success', 'messaje' => 'El correo electrónico se ha enviado correctamente. '));
    } else {
        echo json_encode(array('result' => 'error', 'messaje' => 'Error al enviar el correo electrónico.'));
    }
    die();
}

// Agrega la acción wp_ajax_my_get_order
add_action('wp_ajax_my_get_order', 'my_get_order');
add_action('wp_ajax_nopriv_my_get_order', 'my_get_order');

// Función que maneja la solicitud AJAX
function my_get_order()
{

    // Verifica si se proporcionó un ID de orden en la solicitud
    if (!isset($_GET['id_orden'])) {
        wp_send_json_error('ID de orden no especificado');
    }

    // Obtiene el ID de la orden de la solicitud
    $id_orden = intval($_GET['id_orden']);

    // Realiza la consulta para obtener los datos de la orden
    global $wpdb;
    $orden_table_name = $wpdb->prefix . 'orden';
    $query_orden = $wpdb->prepare("
        SELECT *
        FROM $orden_table_name
        WHERE id = %d
    ", $id_orden);

    // Realiza la consulta para obtener los elementos de la orden
    $orden_items_table_name = $wpdb->prefix . 'orden_items';
    $query_items = $wpdb->prepare("
        SELECT *
        FROM $orden_items_table_name
        WHERE order_id = %d
    ", $id_orden);

    $orden_data = $wpdb->get_row($query_orden); // Obtiene solo un registro
    $items_orden = $wpdb->get_results($query_items); // Obtiene una lista de elementos

    // Verifica si se encontraron resultados
    if ($orden_data !== null || !empty($items_orden)) {
        // Construye el arreglo de respuesta
        $response = array(
            'result' => 'success',
            'orden_data' => $orden_data,
            'items_orden' => $items_orden
        );
        // Devuelve los resultados como respuesta AJAX
        wp_send_json_success($response);
    } else {
        wp_send_json_error('No se encontró ninguna orden con el ID proporcionado');
    }
}


// Agregar un menú en el administrador de WordPress
add_action('admin_menu', 'crear_menu_formulario');

function crear_menu_formulario()
{
    // Añadir un nuevo elemento al menú en el administrador de WordPress
    add_menu_page('Formulario de Email', 'Email pedido', 'manage_options', 'formulario-email', 'mostrar_formulario_email');
}

// Función para mostrar el formulario en el administrador de WordPress
function mostrar_formulario_email()
{
    $email_guardado = get_option('mail_to_order'); // Obtener el email guardado

?>
    <div class="wrap">
        <h1>Destinatario Email</h1>
        <?php if ($email_guardado) : ?>
            <div class="notice notice-info">
                <p>El email guardado actualmente es: <?php echo esc_html($email_guardado); ?></p>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" class="regular-text" value="<?php echo $email_guardado; ?>" required><br><br>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar">
        </form>
    </div>
<?php
}

// Función para procesar los datos del formulario y guardar el email en la opción 'mail_to_order'
add_action('admin_init', 'guardar_email');

function guardar_email()
{
    if (isset($_POST['submit'])) {
        $email = sanitize_email($_POST['email']); // Sanitizar y obtener el email enviado desde el formulario

        // Guardar el email en la opción 'mail_to_order'
        update_option('mail_to_order', $email);

        // Mostrar un mensaje de éxito
        echo '<div class="notice notice-success is-dismissible"><p>Email guardado correctamente.</p></div>';
    }
}


function custom_post_types()
{




    // Registrar tipo de post 'formulas'
    register_post_type(
        'formulas',
        array(
            'labels'      => array(
                'name'          => __('Formulas'),
                'singular_name' => __('Formula'),
            ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array('title'),
            'show_in_rest' => false, // Para soporte de Gutenberg
        )
    );
}
add_action('init', 'custom_post_types');


//mundos


function registrar_post_type_mundos()
{
    $args = array(
        'label'               => __('Mundos', 'text-domain'),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'mundos'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields')
    );
    register_post_type('mundos', $args);
}
add_action('init', 'registrar_post_type_mundos');


// Añadir una nueva columna para el Mundo Padre
function agregar_columna_mundo_padre($columns)
{
    $columns['mundo_padre'] = __('Mundo Padre', 'text-domain');
    return $columns;
}
add_filter('manage_mundos_posts_columns', 'agregar_columna_mundo_padre');

// Mostrar el contenido de la columna Mundo Padre
function mostrar_columna_mundo_padre($column, $post_id)
{
    if ($column === 'mundo_padre') {
        $mundo_padre_id = get_post_meta($post_id, '_mundo_padre_id', true);

        if ($mundo_padre_id) {
            $mundo_padre = get_post($mundo_padre_id);
            if ($mundo_padre) {
                echo '<a href="' . get_edit_post_link($mundo_padre_id) . '">' . esc_html($mundo_padre->post_title) . '</a>';
            } else {
                echo __('(No encontrado)', 'text-domain');
            }
        } else {
            echo __('Ninguno', 'text-domain');
        }
    }
}
add_action('manage_mundos_posts_custom_column', 'mostrar_columna_mundo_padre', 10, 2);



///////////////////


// Añadir una nueva columna para el Mundo Padre
function agregar_columna_marca_mundo($columns)
{
    $columns['marca'] = __('Marca', 'text-domain');
    return $columns;
}
add_filter('manage_mundos_posts_columns', 'agregar_columna_marca_mundo');

// Mostrar el contenido de la columna marca
function mostrar_columna_marca($column, $post_id)
{
    if ($column === 'marca') {

        $marca_id = get_post_meta($post_id, '_marca_mundo', true);


        if ($marca_id) {
            $marca = get_post($marca_id);
            if ($marca) {
                echo '<a href="' . get_edit_post_link($marca_id) . '">' . esc_html($marca->post_title) . '</a>';
            } else {
                echo __('(No encontrada)', 'text-domain');
            }
        } else {
            echo __('Ninguna', 'text-domain');
        }
    }
}
add_action('manage_mundos_posts_custom_column', 'mostrar_columna_marca', 10, 2);


///////////////111




function agregar_metabox_mundo_padre()
{
    add_meta_box(
        'mundo_padre_metabox',          // ID único del metabox
        __('Mundo Padre', 'text-domain'), // Título del metabox
        'mostrar_mundo_padre_metabox',  // Callback para mostrar el contenido del metabox
        'mundos',                       // El post type donde se añadirá el metabox
        'side',                         // Colocación del metabox (side, normal, etc.)
        'default'                       // Prioridad del metabox
    );
}



//add_action('add_meta_boxes', 'agregar_metabox_mundo_padre');

function mostrar_mundo_padre_metabox($post)
{
    // Recuperar el valor actual del campo, si existe
    $mundo_padre_id = get_post_meta($post->ID, '_mundo_padre_id', true);

    // Obtener todos los mundos disponibles
    $mundos = get_posts(array(
        'post_type' => 'mundos',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'exclude' => array($post->ID)
    ));



    echo '<label for="mundo_padre">' . __('Selecciona un Mundo Padre:', 'text-domain') . '</label>';
    echo '<select name="mundo_padre" id="mundo_padre">';
    echo '<option value="0">' . __('Ninguno', 'text-domain') . '</option>';

    foreach ($mundos as $mundo) {
        $padre_id = get_post_meta($mundo->ID, '_mundo_padre_id', true);

        if (!$padre_id && $mundo->ID != $post->ID) {
            $marca_id = get_post_meta($mundo->ID, '_marca_mundo', true);

            $marca = get_post($marca_id);
            echo '<option value="' . esc_attr($mundo->ID) . '" ' . selected($mundo_padre_id, $mundo->ID, false) . '>' . esc_html($marca->post_title . ' - ' . $mundo->post_title) . '</option>';
        }
    }

    echo '</select>';
}

function guardar_mundo_padre_meta($post_id)
{
    // Verificar que no es un autosave y que el usuario tiene permisos para editar
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['mundo_padre'])) {

        if (!empty($_POST['mundo_padre'])) {
            update_post_meta($post_id, '_mundo_padre_id', sanitize_text_field($_POST['mundo_padre']));
        } else {

            update_post_meta($post_id, '_mundo_padre_id', '0');
        }
    } else {

        update_post_meta($post_id, '_mundo_padre_id', '0');
    }
}
add_action('save_post', 'guardar_mundo_padre_meta');


function formulas_add_meta_box()
{
    add_meta_box(
        'formulas_mundos_box',
        'Mundos Relacionados',
        'render_mundos_metabox',
        'formulas',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'formulas_add_meta_box');

// Renderizar la Metabox
function render_mundos_metabox($post)
{

    $marcas = obtener_marcas();

    foreach ($marcas as $marca) {

        echo "<p><b>Marca: " . $marca['post_title'] . "</b> </p>";
        // Obtener los mundos relacionados
        $mundos_relacionados = get_post_meta($post->ID, '_relacionar_mundos', true);

        // Obtener todos los mundos disponibles
        $mundos_padre = get_posts(array(
            'post_type' => 'mundos',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => '_marca_mundo',
                    'value' => $marca['ID'],
                    'compare' => '='
                ),
                array(
                    'key' => '_mundo_padre_id', // Filtrar solo los mundos padres
                    'compare' => '=',
                    'value' => '0'
                )
            )
        ));



        // Mostrar checkbox para cada mundo
        echo '<ul style="margin-left:10px">';
        foreach ($mundos_padre as $mundo) {

            $checked = is_array($mundos_relacionados) && in_array($mundo->ID, $mundos_relacionados) ? 'checked="checked"' : '';


            echo '<li>';
            echo '<label>';
            echo '<input type="checkbox" name="relacionar_mundos[]" value="' . esc_attr($mundo->ID) . '" ' . $checked . ' />';
            echo esc_html($mundo->post_title);
            echo '</label>';

            $submundos = get_posts(array(
                'post_type' => 'mundos',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_mundo_padre_id',
                        'value' => $mundo->ID,
                        'compare' => '='
                    )
                )
            ));

            if (count($submundos) > 0) {
                echo '<ul style="margin-left:20px; margin-top:10px">';
                foreach ($submundos as $submundo) {

                    $checked_sub = is_array($mundos_relacionados) && in_array($submundo->ID, $mundos_relacionados) ? 'checked="checked"' : '';


                    echo '<li>';
                    echo '<label>';
                    echo '<input type="checkbox" name="relacionar_mundos[]" value="' . esc_attr($submundo->ID) . '" ' . $checked_sub . ' />';
                    echo esc_html('-> ' . $submundo->post_title);
                    echo '</label>';
                }
                echo '</ul>';
            }




            echo '</li>';
        }
        echo '</ul><hr/>';
    }
}



function agregar_metabox_marca_mundo()
{
    add_meta_box(
        '_marca_mundo',
        __('Marca', 'text-domain'),
        'mostrar_metabox_marca_mundo',
        'mundos',
        'normal',
        'default'
    );
}

add_action('add_meta_boxes', 'agregar_metabox_marca_mundo');

// Mostrar la metabox para seleccionar la marca
function mostrar_metabox_marca_mundo()
{
    global $post;

    // Obtenemos la marca asociada al mundo, si existe
    $marca_id = get_post_meta($post->ID, '_marca_mundo', true);

    // Obtenemos todas las marcas
    $marcas = get_posts(array(
        'post_type' => 'marcas',
        'posts_per_page' => -1,
    ));

    // Creamos un select para seleccionar la marca
    echo '<label for="marca_mundo">Marca del mundo:</label>';
    echo '<select id="marca_mundo" name="_marca_mundo">';
    echo '<option value="">Seleccione una marca</option>';

    foreach ($marcas as $marca) {
        $selected = ($marca_id == $marca->ID) ? 'selected' : '';
        echo '<option value="' . $marca->ID . '" ' . $selected . '>' . $marca->post_title . '</option>';
    }

    echo '</select>';

    echo '<hr/>';

    echo '<div class="select">';



    // Recuperar el valor actual del campo, si existe
    $mundo_padre_id = get_post_meta($post->ID, '_mundo_padre_id', true);

    // Obtener todos los mundos disponibles
    $mundos = get_posts(array(
        'post_type' => 'mundos',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'exclude' => array($post->ID),
        'meta_query' => array(
            array(
                'key' => '_marca_mundo',
                'value' => $marca_id,
                'compare' => '='
            ),
            array(
                'key' => '_mundo_padre_id', // Filtrar solo los mundos padres
                'compare' => '=',
                'value' => '0'
            )
        )
    ));


    echo '<label for="mundo_padre">' . __('Selecciona un Mundo Padre:', 'text-domain') . '</label>';
    echo '<select name="mundo_padre" id="mundo_padre">';
    echo '<option value="">' . __('Ninguno', 'text-domain') . '</option>';

    foreach ($mundos as $mundo) {
        $padre_id = get_post_meta($mundo->ID, '_mundo_padre_id', true);



        echo '<option value="' . esc_attr($mundo->ID) . '" ' . selected($mundo_padre_id, $mundo->ID, false) . '>' . esc_html($mundo->post_title) . '</option>';
    }

    echo '</select></div>';

?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            $('#marca_mundo').change(function(e) {


                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        marca: $(this).val(),
                        action: 'get_parent_mundos',
                    },
                    success: function(response) {
                        console.log(response);

                        const data = JSON.parse(response);

                        const $select = $('#mundo_padre');

                        // Vaciar cualquier opción existente
                        $select.empty();

                        // Agregar una opción vacía o inicial
                        $select.append('<option value="0">Ninguno</option>');

                        // Iterar a través del array y agregar opciones al <select>
                        data.forEach(function(option) {
                            $select.append($('<option>', {
                                value: option.ID,
                                text: option.post_title
                            }));
                        });




                    },
                    error: function(response) {
                        console.error("Error al obtener el producto:", response);
                    }
                });


            })

        })
    </script>

<?php




}

function get_parent_mundos()
{

    $marca_id =  $_POST['marca'];

    // Obtenemos los mundos relacionados con la marca seleccionada
    $mundos = get_posts(array(
        'post_type' => 'mundos',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_marca_mundo',
                'value' => $marca_id,
                'compare' => '='
            ),
            array(
                'key' => '_mundo_padre_id', // Filtrar solo los mundos padres
                'compare' => '=',
                'value' => '0'
            )
        )
    ));



    echo json_encode($mundos);

    die(); //
}


add_action('wp_ajax_get_parent_mundos', 'get_parent_mundos');
add_action('wp_ajax_nopriv_get_parent_mundos', 'get_parent_mundos');

// Guardar los Datos de la Metabox marca mundo
function save_marca_metabox($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['_marca_mundo'])) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $marca = sanitize_text_field($_POST['_marca_mundo']);
    update_post_meta($post_id, '_marca_mundo', $marca);
}
add_action('save_post', 'save_marca_metabox');


// Añadir la Metabox para el Selector de Color
function add_color_metabox()
{
    add_meta_box(
        'mundo_color', // ID
        'Color del Mundo', // Título
        'render_color_metabox', // Callback
        'mundos', // Pantalla
        'side', // Contexto
        'default' // Prioridad
    );
}
add_action('add_meta_boxes', 'add_color_metabox');

// Renderizar la Metabox
function render_color_metabox($post)
{
    $color = get_post_meta($post->ID, '_mundo_color', true);
    echo '<input type="color" id="mundo_color" name="mundo_color" value="' . esc_attr($color) . '" class="wp-color-picker-field" data-default-color="#ffffff" />';
}

// Guardar los Datos de la Metabox
function save_color_metabox($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['mundo_color'])) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $color = sanitize_hex_color($_POST['mundo_color']);
    update_post_meta($post_id, '_mundo_color', $color);
}
add_action('save_post', 'save_color_metabox');

// Guardar los Datos de la Metabox
function save_mundos_metabox($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['relacionar_mundos'])) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $mundos_relacionados = array_map('intval', $_POST['relacionar_mundos']);


    update_post_meta($post_id, '_relacionar_mundos', $mundos_relacionados);
}
add_action('save_post', 'save_mundos_metabox');



// Crear el menú de administración herrajes
function materiales_admin_menu()
{
    add_menu_page(
        'materiales',
        'materiales',
        'manage_options',
        'materiales',
        'materiales_admin_page',
        'dashicons-cart',
        6
    );
}
add_action('admin_menu', 'materiales_admin_menu');


// Página de administración de materiales
function materiales_admin_page()
{
    global $wpdb;
    $tabla_materiales = $wpdb->prefix . 'productos';

    // Verificar acción (agregar, editar, eliminar)
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($action == 'add' || $action == 'edit') {
        materiales_admin_form($action, $id);
    } else {
        materiales_admin_list();
    }
}

function materiales_admin_list()
{
    global $wpdb;
    $tabla_productos = 'productos';

    $where = '';

    if (isset($_GET['s']) && $_GET['s'] != '') {
        $search = $_GET['s'];
        $where = " where codigo_sap = '$search'";
    }


    if (isset($_GET['marca']) && $_GET['marca'] != '') {

        $search = $_GET['marca'];
        $where = " where marca LIKE '%$search%'";
    }


    echo "SELECT * FROM $tabla_productos $where ORDER BY id DESC";

    $materiales = array();
    // Obtener todos los materiales
    $materiales_res = $wpdb->get_results("SELECT * FROM $tabla_productos $where ORDER BY id DESC");

    $marcas = obtener_marcas();
    $items_categorias = get_categories_relation_data();

    foreach ($materiales_res as $mat) {

        $mn = '';
        $sep = '';
        $sep2 = '';

        $mat_mk = explode(',', $mat->marca);
        $cat_p = explode(',', $mat->categorias);

        foreach ($marcas as $mrc) {

            if (in_array($mrc['ID'], $mat_mk)) {
                //echo $mrc['post_title']." mar<br/>";
                $mat->mname .= $sep . $mrc['post_title'];
                $sep = ', ';
            }
        }



        foreach ($cat_p as $cat) {
            $cat_sel = findCategorytById($cat, $items_categorias);

            $mat->cname .=  $sep2 . $cat_sel->nombre;
            $sep2 = ', ';
        }
    }

    $materiales = $materiales_res;

    // Ordenamiento del array
    $sortable_columns = array('codigo_sap', 'post_title', 'price', 'mname', 'cname', 'tipo');

    $orderby = 'id';
    $order = 'DESC';

    if (isset($_GET['orderby']) && in_array($_GET['orderby'], $sortable_columns)) {
        $orderby = $_GET['orderby'];
    }

    if (isset($_GET['order']) && in_array(strtoupper($_GET['order']), array('ASC', 'DESC'))) {
        $order = strtoupper($_GET['order']);
    }

    usort($materiales, function ($a, $b) use ($orderby, $order) {
        if ($order === 'ASC') {
            return strcmp($a->$orderby, $b->$orderby);
        } else {
            return strcmp($b->$orderby, $a->$orderby);
        }
    });

    $select =  '<select name="marca" class="form-control w-100"><option value="">Seleccione marca</option>';

    foreach ($marcas as $marca) {

        $select .=  '<option value="' . $marca['ID'] . '">' . $marca['post_title'] . '</option>';
    }

    $select .= '</select>';


    // Mostrar la lista de materiales
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Materiales</h1>';
    echo '<a href="?page=materiales&action=add" class="page-title-action">Añadir nuevo</a>';
    echo '<div class="search"><form action="admin.php" method="get"><input type="hidden" name="page" value="materiales"/><input type="search" class="form-control" style="width:300px" name="s" placeholder="busca por codigo sap o nombre"/> ' . $select . ' <button class="btn btn-default">Buscar</button></form></div>';
    echo '<table class="wp-list-table widefat fixed striped table-view-list">';
    echo '<thead><tr>';
    echo '<th>Imagen</th>';
    echo '<th><a href="?page=materiales&orderby=codigo_sap&order=' . ($orderby === 'codigo_sap' && $order === 'ASC' ? 'DESC' : 'ASC') . '">Código sap</a></th>';
    echo '<th><a href="?page=materiales&orderby=post_title&order=' . ($orderby === 'post_title' && $order === 'ASC' ? 'DESC' : 'ASC') . '">Título</a></th>';
    echo '<th><a href="?page=materiales&orderby=price&order=' . ($orderby === 'price' && $order === 'ASC' ? 'DESC' : 'ASC') . '">Precio</a></th>';
    echo '<th><a href="?page=materiales&orderby=mname&order=' . ($orderby === 'mname' && $order === 'ASC' ? 'DESC' : 'ASC') . '">Marca</a></th>';
    echo '<th><a href="?page=materiales&orderby=cname&order=' . ($orderby === 'cname' && $order === 'ASC' ? 'DESC' : 'ASC') . '">Categorias</a></th>';
    echo '<th><a href="?page=materiales&orderby=tipo&order=' . ($orderby === 'tipo' && $order === 'ASC' ? 'DESC' : 'ASC') . '">Tipo</a></th>';

    echo '<th>Acciones</th>';
    echo '</tr></thead>';
    echo '<tbody>';
    foreach ($materiales as $material) {
        echo '<tr>';
        echo '<td><img src="' . esc_html($material->image_url) . '" class="img_pl"  height="50" width="100"/></td>';
        echo '<td>' . esc_html($material->codigo_sap) . '</td>';
        echo '<td>' . esc_html($material->post_title) . '</td>';
        echo '<td align="center">' . esc_html($material->price) . '</td>';
        echo '<td>' . esc_html($material->mname) . '</td>';
        echo '<td>' . esc_html($material->cname) . '</td>';
        echo '<td>' . esc_html($material->tipo) . '</td>';
        echo '<td>';
        echo '<a href="?page=materiales&action=edit&id=' . esc_html($material->id) . '">Editar</a> | ';
        echo '<a href="?page=materiales&action=delete&id=' . esc_html($material->id) . '">Eliminar</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function materiales_admin_form($action, $id)
{
    global $wpdb;
    $tabla_materiales = 'productos';
    $material = new stdClass();

    $materiales_relacionados = [];
    $materiales_data = [];
    $consecutivos_data = [];
    $parent_id = '';
    $consecutivos_final = [];

    if ($action == 'edit') {


        $parent_id = $id;

        
    $material_edit = $wpdb->get_row("SELECT * FROM $tabla_materiales WHERE id = '$id'");



        $materiales_relacionados = $wpdb->get_results("SELECT id_material, cantidad_defecto FROM wp_materiales_relacionados WHERE id_padre = '$id'", OBJECT);
        
        
        $ids_m = array();
        
        foreach ($materiales_relacionados as $mat) {
            array_push($ids_m, $mat->id_material);
        }

        $strids = implode(",", $ids_m);

        $materiales_data = $wpdb->get_results("
        SELECT m.*, r.cantidad_defecto
        FROM wp_materiales_relacionados AS r
        INNER JOIN $tabla_materiales AS m ON r.id_material = m.id
        WHERE r.id_padre = '$id'
    ", OBJECT);


        $material_marca_id = explode(',', $material_edit->marca);
       

        $cons = 1;



        $marcas = obtener_marcas();

        foreach ($material_marca_id as $consecutivo_marca) {

            foreach ($marcas as $marca) {
         
                $orden_nw = $wpdb->get_row("SELECT MAX(`consecutivo`) AS consecutivo FROM consecutivos_materiales WHERE id_marca = '$marca[ID]'", OBJECT);

                

                if ($consecutivo_marca == $marca['ID']) {

                    $consecutivo_data = $wpdb->get_row("SELECT * FROM consecutivos_materiales WHERE id_material = '$id' and id_marca = '$marca[ID]'", OBJECT);
                  
                    if (isset($consecutivo_data) && (int) $consecutivo_data->consecutivo > 1) {
                        $cons = $consecutivo_data->consecutivo;
                    } else {
                        $cons = (int) $orden_nw->consecutivo + 1;
                    }

                    //$consecutivo_marca->text = $marca['post_title'];
                    array_push($consecutivos_final, (object) array('text' => $marca['post_title'], 'id' => $marca['ID'], 'consecutivo' => $cons));
                }
            }
        }
    }


    $orden_nw = $wpdb->get_row("SELECT MAX(`order`) AS order_max FROM productos", OBJECT);


    $marcas = obtener_marcas();
    // Incluir la plantilla del formulario
    include('templates/formulario-productos.php');
}


function materiales_handle_crud_actions()
{
    global $wpdb;
    $tabla_materiales = 'productos';

    // if (isset($_POST['action']) && $_POST['action'] == 'save') {
    //     $id = isset($_POST['ID']) ? intval($_POST['ID']) : 0;
    //     $data = array(
    //         'post_title' => sanitize_text_field($_POST['post_title']),
    //         'post_content' => sanitize_textarea_field($_POST['post_content']),
    //         'price' => floatval($_POST['price']),
    //         'image_url' => esc_url_raw($_POST['image_url']),
    //         'thumbnail_prod' => esc_url_raw($_POST['thumbnail_prod']),
    //         'sku' => sanitize_text_field($_POST['sku']),
    //         'categorias' => sanitize_text_field($_POST['categorias']),
    //         'marca' => intval($_POST['marca']),
    //         'observacion' => sanitize_textarea_field($_POST['observacion']),
    //         'tipo' => sanitize_text_field($_POST['tipo']),
    //     );

    //     if ($id > 0) {
    //         // Actualizar herraje existente
    //         $wpdb->update($tabla_materiales, $data, array('ID' => $id));
    //     } else {
    //         // Insertar nuevo herraje
    //         $wpdb->insert($tabla_materiales, $data);
    //     }

    //     wp_redirect(admin_url('admin.php?page=materiales'));
    //     exit;
    // }

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && isset($_GET['page']) && $_GET['page'] == 'materiales') {
        $id = intval($_GET['id']);
        $wpdb->delete($tabla_materiales, array('id' => $id));
        $wpdb->delete("formulas_herrajes", array("id_herraje" => $id), array("%d"));

        wp_redirect(admin_url('admin.php?page=materiales'));
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && isset($_GET['page']) && $_GET['page'] == 'categorias') {
        $id = intval($_GET['id']);
        $wpdb->delete("categorias", array("id" => $id), array("%d"));

        wp_redirect(admin_url('admin.php?page=categorias'));
        exit;
    }


    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && isset($_GET['page']) && $_GET['page'] == 'herrajes') {
        $id = intval($_GET['id']);
        // Actualizar el campo 'tipo' en lugar de eliminar el registro
        $wpdb->update(
            $tabla_materiales,
            array('tipo' => 'material'), // Datos a actualizar
            array('id' => $id), // Condición para seleccionar el registro
            array('%s'), // Formato para los datos a actualizar
            array('%d')  // Formato para la condición
        );

        $wpdb->delete("formulas_herrajes", array("id_herraje" => $id), array("%d"));

        wp_redirect(admin_url('admin.php?page=herrajes'));
        exit;
    }
}
add_action('admin_init', 'materiales_handle_crud_actions');


function get_product_data()
{
    global $wpdb;
    $tabla_productos = 'productos';

    $id =  $_POST['id'];
    // Obtener todos los productos
    $producto = $wpdb->get_row("SELECT * FROM $tabla_productos where id = '$id'");

    echo json_encode($producto);

    die(); //
}


add_action('wp_ajax_get_product', 'get_product_data');
add_action('wp_ajax_nopriv_get_product', 'get_product_data');


add_action('wp_ajax_get_last_consecutivo', 'get_last_consecutivo');
add_action('wp_ajax_nopriv_get_last_consecutivo', 'get_last_consecutivo');


function get_last_consecutivo()
{
    global $wpdb;
    $id =  $_POST['id_marca'];

    $orden_nw = $wpdb->get_row("SELECT MAX(`consecutivo`) AS consecutivo_max FROM consecutivos_materiales where id_marca = '$id'", OBJECT);

    echo wp_send_json_success($orden_nw);

    die(); //
}



//-------------------
// Crear el menú de administración herrajes
function herrajes_admin_menu()
{
    add_menu_page(
        'herrajes',
        'Formulas herrajes',
        'manage_options',
        'herrajes',
        'herrajes_admin_page',
        'dashicons-cart',
        6
    );
}
add_action('admin_menu', 'herrajes_admin_menu');

// Página de administración de herrajes
function herrajes_admin_page()
{
    global $wpdb;
    $tabla_herrajes = $wpdb->prefix . 'productos';

    // Verificar acción (agregar, editar, eliminar)
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($action == 'add' || $action == 'edit') {
        herrajes_admin_form($action, $id);
    } else {
        herrajes_admin_list();
    }
}

function herrajes_admin_list()
{
    global $wpdb;
    $tabla_herrajes = 'productos';

    // Obtener todos los herrajes
    $herrajes = $wpdb->get_results("SELECT * FROM $tabla_herrajes where tipo = 'herraje'");

    $marcas = obtener_marcas();


    // Mostrar la lista de herrajes
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Formulas herrajes</h1>';
    echo '<a href="?page=herrajes&action=add" class="page-title-action">Añadir nuevo</a>';
    echo '<table class="wp-list-table widefat fixed striped table-view-list">';
    echo '<thead><tr>';
    echo '<th>Imagen</th>';
    echo '<th>Código sap</th>';
    echo '<th>Título</th>';
    echo '<th>Marca</th>';
    echo '<th>Precio</th>';
    echo '<th>Tipo</th>';
    echo '<th>Acciones</th>';
    echo '</tr></thead>';
    echo '<tbody>';
    foreach ($herrajes as $herraje) {

        $mat_mk = explode(',', $herraje->marca);

        $mname = '';
        $sep = '';

        foreach ($marcas as $mrc) {

            if (in_array($mrc['ID'], $mat_mk)) {
                //echo $mrc['post_title']." mar<br/>";
                $mname .= $sep . $mrc['post_title'];
                $sep = ', ';
            }
        }

        echo '<tr>';
        echo '<td><img src="' . esc_html($herraje->image_url) . '" class="img_pl" width="100" heidth="100"/></td>';
        echo '<td>' . esc_html($herraje->codigo_sap) . '</td>';
        echo '<td>' . esc_html($herraje->post_title) . '</td>';
        echo '<td>' . esc_html($mname) . '</td>';
        echo '<td>' . esc_html($herraje->price) . '</td>';
        echo '<td>' . esc_html($herraje->tipo) . '</td>';
        echo '<td>';
        echo '<a href="?page=herrajes&action=edit&id=' . esc_html($herraje->id) . '">Editar</a> | ';
        echo '<a href="?page=herrajes&action=delete&id=' . esc_html($herraje->id) . '">Eliminar</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function herrajes_admin_form($action, $id)
{
    global $wpdb;
    $tabla_herrajes = 'productos';
    $herraje = new stdClass();

    // Obtener todas las categorías de productos de WooCommerce
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));

    if ($action == 'edit') {
        // Obtener el herraje
        $herraje = $wpdb->get_row($wpdb->prepare("SELECT id, codigo_sap, post_title, price, categorias, marca FROM $tabla_herrajes WHERE ID = %d", $id));

        // Obtener los materiales relacionados
        $materiales_relacionados = $wpdb->get_results($wpdb->prepare("SELECT id_material, cantidad_defecto FROM wp_materiales_relacionados WHERE id_padre = %d", $id), OBJECT);

        $ids_m = array();
        foreach ($materiales_relacionados as $mat) {
            array_push($ids_m, $mat->id_material);
        }

        if (!empty($ids_m)) {
            // Obtener los datos de los materiales relacionados
            $related_materials = $wpdb->get_results("
                SELECT m.*, r.cantidad_defecto
                FROM wp_materiales_relacionados AS r
                INNER JOIN $tabla_herrajes AS m ON r.id_material = m.ID
                WHERE r.id_padre = '$id'
            ", OBJECT);

            // Añadir los materiales relacionados al objeto herraje
            $herraje->related = $related_materials;
        } else {
            $herraje->related = [];
        }
    }


    $marcas = obtener_marcas();

    // Incluir la plantilla del formulario
    include('templates/formulas-herrajes.php');
}



function herrajes_handle_crud_actions()
{
    global $wpdb;
    $tabla_herrajes = $wpdb->prefix . 'herrajes';

    if (isset($_POST['action']) && $_POST['action'] == 'save') {
        $id = isset($_POST['ID']) ? intval($_POST['ID']) : 0;
        $data = array(
            'post_title' => sanitize_text_field($_POST['post_title']),
            'post_content' => sanitize_textarea_field($_POST['post_content']),
            'price' => floatval($_POST['price']),
            'image_url' => esc_url_raw($_POST['image_url']),
            'thumbnail_prod' => esc_url_raw($_POST['thumbnail_prod']),
            'sku' => sanitize_text_field($_POST['sku']),
            'categorias' => sanitize_text_field($_POST['categorias']),
            'marca' => intval($_POST['marca']),
            'observacion' => sanitize_textarea_field($_POST['observacion']),
            'tipo' => sanitize_text_field($_POST['tipo']),
        );

        if ($id > 0) {
            // Actualizar herraje existente
            $wpdb->update($tabla_herrajes, $data, array('ID' => $id));
        } else {
            // Insertar nuevo herraje
            $wpdb->insert($tabla_herrajes, $data);
        }

        wp_redirect(admin_url('admin.php?page=herrajes'));
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($tabla_herrajes, array('ID' => $id));
        wp_redirect(admin_url('admin.php?page=herrajes'));
        exit;
    }
}
add_action('admin_init', 'herrajes_handle_crud_actions');



function register_custom_endpoints()
{
    register_rest_route('ordenes_cristal/v1', '/get_formulas', array(
        'methods' => 'GET',
        'callback' => 'get_formulas_grouped_by_world',
    ));
}
add_action('rest_api_init', 'register_custom_endpoints');




function get_formulas_grouped_by_world()
{
    global $wpdb;

    $marca_id = isset($_GET['marca']) ? sanitize_text_field($_GET['marca']) : '';
    $edit = $_GET['herraje'];
    $marca = $_GET['marca'];

    $holgurasd = $wpdb->get_row("SELECT holgura_f, holgura_p FROM holguras_herrajes WHERE id_herraje = '$edit' and id_marca = '$marca'", OBJECT);

    if (!$holgurasd) {
        $holguras = (object)['holgura_f' => '', 'holgura_p' => ''];
    } else {
        $holguras = (object)['holgura_f' => $holgurasd->holgura_f, 'holgura_p' => $holgurasd->holgura_p];
    }


    $formulas_grouped_by_world = array();

    // Obtener todos los mundos padres
    $mundos_padres = get_posts(array(
        'post_type' => 'mundos',
        'posts_per_page' => -1,
        'orderby' =>'title',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => '_marca_mundo',
                'value' => $marca_id,
                'compare' => '='
            ),
            array(
                'key' => '_mundo_padre_id', // Filtrar solo los mundos padres
                'compare' => '=',
                'value' => '0'
            )
        )
    ));

    foreach ($mundos_padres as $mundo) {
        $mundo_data = array(
            'ID' => $mundo->ID,
            'title' => $mundo->post_title,
            'link' => get_permalink($mundo->ID),
            'color' => get_post_meta($mundo->ID, '_mundo_color', true),
            'formulas' => array(),
            'submundos' => array()
        );

        // Obtener las fórmulas del mundo padre
        $formulas = get_posts(array(
            'post_type' => 'formulas',
            'posts_per_page' => -1,
            'orderby' =>'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_relacionar_mundos',
                    'value' => $mundo->ID,
                    'compare' => 'LIKE'
                )
            )
        ));

        foreach ($formulas as $formula) {
            $sql = "SELECT cantidad_defecto FROM formulas_herrajes WHERE id_herraje = '$edit' and id_marca = '$marca' and id_mundo = '$mundo->ID' and id_formula = '$formula->ID'";
            $cantidad_seteada_defecto = $wpdb->get_row($sql);

            $mundo_data['formulas'][] = array(
                'ID' => $formula->ID,
                'title' => $formula->post_title,
                'content' => $formula->post_content,
                'link' => get_permalink($formula->ID),
                'cnt' => !empty($cantidad_seteada_defecto->cantidad_defecto) ? $cantidad_seteada_defecto->cantidad_defecto : '0'
            );
        }

        // Obtener los submundos de cada mundo padre
        $submundos = get_posts(array(
            'post_type' => 'mundos',
            'posts_per_page' => -1,
            'orderby' =>'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_mundo_padre_id',
                    'value' => $mundo->ID,
                    'compare' => '='
                )
            )
        ));



        foreach ($submundos as $submundo) {
            $submundo_data = array(
                'ID' => $submundo->ID,
                'title' => $submundo->post_title,
                'link' => get_permalink($submundo->ID),
                'color' => get_post_meta($submundo->ID, '_mundo_color', true),
                'formulas' => array()
            );

            // Obtener las fórmulas del submundo
            $formulas_submundo = get_posts(array(
                'post_type' => 'formulas',
                'posts_per_page' => -1,
                'orderby' =>'title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => '_relacionar_mundos',
                        'value' => $submundo->ID,
                        'compare' => 'LIKE'
                    )
                )
            ));

            foreach ($formulas_submundo as $formula) {
                $sql = "SELECT cantidad_defecto FROM formulas_herrajes WHERE id_herraje = '$edit' and id_marca = '$marca' and id_mundo = '$submundo->ID' and id_formula = '$formula->ID'";
                $cantidad_seteada_defecto = $wpdb->get_row($sql);

                $submundo_data['formulas'][] = array(
                    'ID' => $formula->ID,
                    'title' => $formula->post_title,
                    'content' => $formula->post_content,
                    'link' => get_permalink($formula->ID),
                    'cnt' => !empty($cantidad_seteada_defecto->cantidad_defecto) ? $cantidad_seteada_defecto->cantidad_defecto : '0'
                );
            }

            $mundo_data['submundos'][] = $submundo_data;
        }

        $formulas_grouped_by_world[] = $mundo_data;
    }

    return new WP_REST_Response((object)['holguras' => $holguras, 'dataf' => $formulas_grouped_by_world], 200);
}


function register_custom_endpoints_formulas()
{
    register_rest_route('ordenes_cristal/v1', '/get_formulas_front', array(
        'methods' => 'GET',
        'callback' => 'get_formulas_grouped_by_world_front',
    ));
}
add_action('rest_api_init', 'register_custom_endpoints_formulas');




function get_formulas_grouped_by_world_front()
{
    global $wpdb;


    // Obtenemos la marca asociada al producto a través de $_POST['marca']
    $marca_id = isset($_GET['marca']) ? sanitize_text_field($_GET['marca']) : '';


    // Obtener todos los mundos padres
    $mundos = get_posts(array(
        'post_type' => 'mundos',
        'posts_per_page' => -1,
        'orderby' => 'title',  // Ordenar por el título del post
        'order' => 'ASC' ,      // Orden ascendente (puedes cambiar a 'DESC' si lo prefieres
        'meta_query' => array(
            array(
                'key' => '_marca_mundo',
                'value' => $marca_id,
                'compare' => '='
            ),
            array(
                'key' => '_mundo_padre_id', // Filtrar solo los mundos padres
                'compare' => '=',
                'value' => '0'
            )
        )
    ));


    $marca = $_GET['marca'];


    $formulas_grouped_by_world = array();


    foreach ($mundos as $mundo) {
        $mundo_data = array(
            'ID' => $mundo->ID,
            'title' => $mundo->post_title,
            'link' => get_permalink($mundo->ID),
            'color' => get_post_meta($mundo->ID, '_mundo_color', true),
            'formulas' => array(),
            'submundos' => array()
        );

        //formulas de el mundo padre
        $formulas = get_posts(array(
            'post_type' => 'formulas',
            'posts_per_page' => -1,
            'orderby' => 'title',  // Ordenar por el título del post
            'order' => 'ASC',       // Orden ascendente (puedes cambiar a 'DESC' si lo prefieres
            'meta_query' => array(
                array(
                    'key' => '_relacionar_mundos',
                    'value' => $mundo->ID,
                    'compare' => 'LIKE'
                )
            )
        ));



        foreach ($formulas as $formula) {

            $sql = "SELECT cantidad_defecto FROM formulas_herrajes WHERE id_marca = '$marca' and id_mundo = '$mundo->ID' and id_formula = '$formula->ID'";

            $cantidad_seteada_defecto = $wpdb->get_row($sql);

            $mundo_data['formulas'][] = array(
                'ID' => $formula->ID,
                'title' => $formula->post_title,
                'content' => $formula->post_content,
                'link' => get_permalink($formula->ID),
                'cnt' => '0'
            );
        }


        // Obtener los submundos de cada mundo padre
        $submundos = get_posts(array(
            'post_type' => 'mundos',
            'posts_per_page' => -1,
            'orderby' => 'title',  // Ordenar por el título del post
            'order' => 'ASC',       // Orden ascendente (puedes cambiar a 'DESC' si lo prefieres
            'meta_query' => array(
                array(
                    'key' => '_mundo_padre_id',
                    'value' => $mundo->ID,
                    'compare' => '='
                )
            )
        ));



        foreach ($submundos as $submundo) {
            $submundo_data = array(
                'ID' => $submundo->ID,
                'title' => $submundo->post_title,
                'link' => get_permalink($submundo->ID),
                'color' => get_post_meta($submundo->ID, '_mundo_color', true),
                'formulas' => array()
            );

            // Obtener las fórmulas del submundo
            $formulas_submundo = get_posts(array(
                'post_type' => 'formulas',
                'posts_per_page' => -1,
                'orderby' => 'title',  // Ordenar por el título del post
                'order' => 'ASC',       // Orden ascendente (puedes cambiar a 'DESC' si lo prefieres
                'meta_query' => array(
                    array(
                        'key' => '_relacionar_mundos',
                        'value' => $submundo->ID,
                        'compare' => 'LIKE'
                    )
                )
            ));

            foreach ($formulas_submundo as $formula) {
                $sql = "SELECT cantidad_defecto FROM formulas_herrajes WHERE id_herraje = '$edit' and id_marca = '$marca' and id_mundo = '$submundo->ID' and id_formula = '$formula->ID'";
                $cantidad_seteada_defecto = $wpdb->get_row($sql);

                $submundo_data['formulas'][] = array(
                    'ID' => $formula->ID,
                    'title' => $formula->post_title,
                    'content' => $formula->post_content,
                    'link' => get_permalink($formula->ID),
                    'cnt' => !empty($cantidad_seteada_defecto->cantidad_defecto) ? $cantidad_seteada_defecto->cantidad_defecto : '0'
                );
            }

            $mundo_data['submundos'][] = $submundo_data;
        }


        $formulas_grouped_by_world[] = $mundo_data;
    }


    return new WP_REST_Response($formulas_grouped_by_world, 200);
}



// Registrar la ruta del endpoint para buscar materiales
function registrar_endpoint_buscar_material()
{
    register_rest_route('ordenes_cristal/v1', '/buscar_material', array(
        'methods' => 'GET',
        'callback' => 'buscar_material_callback',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_buscar_material');

function buscar_material_callback()
{
    global $wpdb;
    $query = isset($_GET['q']) ? $_GET['q'] : '';
    $query_like = $wpdb->esc_like($query);

    // Consulta para buscar en ambos campos
    $sql = $wpdb->prepare("
        SELECT * 
        FROM productos 
        WHERE post_title LIKE %s OR codigo_sap = '%s'
    ", $query_like, $query_like);


    $result = $wpdb->get_results($sql, OBJECT);

    //  error_log(print_r($result, true)); // Log de los productos principales

    // Iterar sobre los productos para buscar los relacionados
    foreach ($result as $producto) {
        // Consulta para obtener los productos relacionados
        $sql_related = $wpdb->prepare("
            SELECT p.*, r.cantidad_defecto 
            FROM wp_materiales_relacionados AS r
            JOIN productos AS p ON r.id_material = p.id 
            WHERE r.id_padre = %d
        ", $producto->id);


        // Ejecutar la consulta de productos relacionados
        $related = $wpdb->get_results($sql_related, OBJECT);

        //  print_r($related); // Log de los resultados relacionados

        // Añadir los productos relacionados al campo "related"
        $producto->related = $related;
    }

    return rest_ensure_response($result);
    die();
}



// Registrar la ruta del endpoint para guardar la orden
function registrar_endpoint_guardar_herraje()
{
    register_rest_route('ordenes_cristal/v1', '/guardar_herraje', array(
        'methods' => 'POST',
        'callback' => 'save_formula_herraje',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_guardar_herraje');



function save_formula_herraje()
{
    global $wpdb;


    if (isset($_POST['edit']) && intval($_POST['edit']) > 0) {

        $edit = $_POST['edit'];

        $data = array(
            'tipo' => 'herraje',
        );

        $format = array('%s');

        $where = array('id' => $edit);
        $where_format = array('%d');

        $success = $wpdb->update('productos', $data, $where, $format, $where_format);

        $json = $_POST['form'];

        // Intenta decodificar el JSON
        $data = json_decode(utf8_encode(base64_decode($json)), true);


        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error de JSON: ' . json_last_error_msg();
        }


        $materiales_relacionados = $data;


        foreach ($materiales_relacionados as $marca_conjunto) {



            $id_marca = $marca_conjunto['marca'];

            if (isset($_POST['edit'])) {

                $wpdb->delete("formulas_herrajes", array("id_herraje" => $edit, 'id_marca' => $id_marca), array("%d", "%d"));

                $wpdb->delete("holguras_herrajes", array("id_herraje" => $edit, 'id_marca' => $id_marca), array("%d", "%d"));
            }


            $success_h = $wpdb->insert(
                'holguras_herrajes',
                array(
                    'id_marca' => $id_marca,
                    'id_herraje' => $edit,
                    'holgura_f' => $marca_conjunto['holguras']['holgura_f'],
                    'holgura_p' => $marca_conjunto['holguras']['holgura_p'],
                ),
                array(
                    '%d', // id_marca
                    '%d', // id_herraje
                    '%d', // holgura_f
                    '%d', //holgura_p 

                )
            );

            if (!$success_h) {
                echo $wpdb->last_error;
            }

            foreach ($marca_conjunto['data'] as $mundos) {


                foreach ($mundos as $mundo) {

                    $id_mundo = $mundo['ID'];
                    //echo "mundo ".$id_mundo."<br/>";

                    foreach ($mundo['formulas'] as $formula) {

                        $id_formula = $formula['ID'];
                        $cantidad_defecto = $formula['cnt'];
                        //          echo "formula ".$id_formula."<br/>";


                        $success_h = $wpdb->insert(
                            'formulas_herrajes',
                            array(
                                'id_marca' => $id_marca,
                                'id_mundo' => $id_mundo,
                                'id_herraje' => $edit,
                                'id_formula' => $id_formula,
                                'cantidad_defecto' => $cantidad_defecto
                            ),
                            array(
                                '%d', // id_marca
                                '%d', // id_mundo
                                '%d', // id_herraje
                                '%d', // id_formula 
                                '%s'  // cantidad_defecto
                            )
                        );

                        if (!$success_h) {
                            echo $wpdb->last_error;
                        }
                    }



                    foreach ($mundo['submundos'] as $mundo) {

                        foreach ($mundo['formulas'] as $formula) {

                            $id_formula = $formula['ID'];
                            $cantidad_defecto = $formula['cnt'];



                            $success_h = $wpdb->insert(
                                'formulas_herrajes',
                                array(
                                    'id_marca' => $id_marca,
                                    'id_mundo' => $mundo['ID'],
                                    'id_herraje' => $edit,
                                    'id_formula' => $id_formula,
                                    'cantidad_defecto' => $cantidad_defecto
                                ),
                                array(
                                    '%d', // id_marca
                                    '%d', // id_mundo
                                    '%d', // id_herraje
                                    '%d', // id_formula 
                                    '%s'  // cantidad_defecto
                                )
                            );

                            if (!$success_h) {
                                echo $wpdb->last_error;
                            }
                        }
                    }
                }
            }
        }

        return json_encode(array("result" => "success", "message" => 'Herraje añadido a las formulas correctamente.'));
    }
}


function save_herraje()
{
    global $wpdb;


    $form = json_decode(base64_decode($_POST['form'], false));


    // Verificar los datos enviados y sanitizarlos
    $sku = $form->sku;
    $codigo_sap = $form->codigo_sap;
    $post_title = $form->post_title;
    $price = $form->price;



    $tipo = $_POST['tipo'];


    if ($tipo == 'herraje') {
        $categorias = '3';
    } else {
        $marca = $form->marca;
        $categorias = $form->categoria;
        $categorias = implode(',', $categorias);
    }
    $post_content = $form->post_content;
    $observacion = $form->observacion;
    $files_order_complete_path = [];

    // Subir archivos adjuntos
    $archivos = [];
    $upload_dir = wp_upload_dir();


    if (isset($_FILES['files'])) {
        $upload_dir = wp_upload_dir(); // Obtiene la información del directorio de subidas de WordPress
        $upload_path = $upload_dir['path']; // Ruta del directorio de subidas

        $archivos = array(); // Array para almacenar las URLs de los archivos

        // Recorre cada archivo cargado
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $file_name = str_replace(" ", "_", $_FILES['files']['name'][$key]);
            $file_path = $upload_path . '/' . $file_name; // Ruta completa del archivo en el servidor

            // Mueve el archivo al directorio de subidas de WordPress
            move_uploaded_file($tmp_name, $file_path);
            // Sube el archivo a WordPress y obtén su ID de adjunto
            $attachment_id = wp_insert_attachment(array(
                'guid' => $upload_dir['url'] . '/' . $file_name,
                'post_mime_type' => $_FILES['files']['type'][$key],
                'post_title' => $file_name,
                'post_content' => '',
                'post_status' => 'inherit'
            ), $file_path);

            // Genera el enlace de descarga directa para el archivo adjunto
            $file_url = wp_get_attachment_url($attachment_id);

            // Almacena la URL del archivo
            //echo "furl ".$file_url;
            $archivos[] = $file_url;
        }

        $files_order_complete_path = $archivos;

        // $archivos ahora contiene las URLs de los archivos cargados en WordPress
        // Puedes usar este array para descargar los archivos más tarde
    }


    // Insertar los datos en la tabla
    $table_name = 'productos';

    if (isset($_POST['edit']) && intval($_POST['edit']) > 0) {


        // Actualización
        $edit_id = intval($_POST['edit']);

        if (count($files_order_complete_path) > 0) {

            $data = array(
                'sku' => $sku,
                'codigo_sap' => $codigo_sap,
                'post_title' => $post_title,
                'price' => $price,
                'marca' => ' ',
                'tipo' => $tipo,
                'categorias' => 3,
                'image_url' => $files_order_complete_path[0],
                'thumbnail_prod' => '',
                'post_content' => $post_content,
                'observacion' => $observacion
            );

            $format = array('%s', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s');
        } else {
            $data = array(
                'sku' => $sku,
                'codigo_sap' => $codigo_sap,
                'post_title' => $post_title,
                'price' => $price,
                'marca' => ' ',
                'tipo' => $tipo,
                'categorias' => 3,
                'thumbnail_prod' => '',
                'post_content' => $post_content,
                'observacion' => $observacion
            );


            $format = array('%s', '%s', '%s', '%f', '%s',  '%s', '%s', '%s', '%s');
        }

        $where = array('id' => $edit_id);
        $where_format = array('%d');

        $success = $wpdb->update($table_name, $data, $where, $format, $where_format);
        $id_parent = $edit_id;
    } else {
        // Inserción
        $data = array(
            'sku' => $sku,
            'codigo_sap' => $codigo_sap,
            'post_title' => $post_title,
            'price' => $price,
            'marca' => ' ',
            'tipo' => $tipo,
            'categorias' => 3,
            'image_url' => $files_order_complete_path[0],
            'thumbnail_prod' => '',
            'post_content' => $post_content,
            'observacion' => $observacion
        );

        $format = array('%s', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s');
        $success = $wpdb->insert($table_name, $data, $format);
        $id_parent = $wpdb->insert_id;
    }


    if ($success == true || $success == 0) {

        if ($tipo == 'herraje') {
            $herraje_id = $id_parent;

            if ($herraje_id == 0) {
                return json_encode(array("result" => "success", "message" => 'Herraje no se añadio.'));
                die();
            }


            // Decodificar la cadena Base64
            $json_string = base64_decode($form->relatedformulas);

            // Decodificar la cadena JSON en un array PHP
            $array = json_decode($json_string, true);

            // Verificar si hubo errores en la decodificación
            if (json_last_error() === JSON_ERROR_NONE) {
                // Imprimir el array resultante
            } else {
                //                    echo 'Error decodificando JSON: ' . json_last_error_msg();
            }
            $materiales_relacionados = $array;

            if (isset($_POST['edit'])) {
                $edit = $_POST['edit'];

                $wpdb->delete("formulas_herrajes", array("id_herraje" => $edit), array("%d"));
            }


            foreach ($materiales_relacionados as $marca_conjunto) {
                $id_marca = $marca_conjunto['marca'];
                //echo "marca_conjunto ".$id_marca."<br/>";

                foreach ($marca_conjunto['data'] as $mundos) {


                    foreach ($mundos as $mundo) {

                        $id_mundo = $mundo['ID'];
                        //echo "mundo ".$id_mundo."<br/>";

                        foreach ($mundo['formulas'] as $formula) {

                            $id_formula = $formula['ID'];
                            $cantidad_defecto = $formula['cnt'];
                            //          echo "formula ".$id_formula."<br/>";


                            $success_h = $wpdb->insert(
                                'formulas_herrajes',
                                array(
                                    'id_marca' => $id_marca,
                                    'id_mundo' => $id_mundo,
                                    'id_herraje' => $herraje_id,
                                    'id_formula' => $id_formula,
                                    'cantidad_defecto' => $cantidad_defecto
                                ),
                                array(
                                    '%d', // id_marca
                                    '%d', // id_mundo
                                    '%d', // id_herraje
                                    '%d', // id_formula 
                                    '%d'  // cantidad_defecto
                                )
                            );

                            if (!$success_h) {
                                //echo $wpdb->last_error;
                            }
                        }
                    }
                }
            }
        }


        return json_encode(array("result" => "success", "message" => 'Herraje añadido correctamente.'));
    } else {
        return json_encode(array("result" => "error", "message" => 'no se agrego el producto.'));
    }

    die(); // Finalizar la ejecución para AJAX
}




function registrar_endpoint_busqueda_relacionados_post()
{
    register_rest_route('ordenes_cristal/v1', '/get_related', array(
        'methods' => 'POST',
        'callback' => 'buscar_productos_relacionados',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_busqueda_relacionados_post');




function findCategorytById($id, $array)
{

    foreach ($array as $element) {

        if ($id == $element->id) {
            return $element;
        }
    }

    return false;
}

/**
 * Buscar en un array de objetos por una propiedad específica.
 *
 * @param array $array El array de objetos.
 * @param string $property El nombre de la propiedad a buscar.
 * @param mixed $value El valor de la propiedad a buscar.
 * @return object|null El objeto encontrado o null si no se encontró.
 */
function buscarEnArrayDeObjetos($array, $property, $value)
{
    foreach ($array as $object) {

        $object = (object) $object;

        if (isset($object->$property) && $object->$property == $value) {

            return $object;
        }
    }
    return null;
}


/**
 * Eliminar un objeto de un array de objetos por una propiedad específica.
 *
 * @param array $array El array de objetos.
 * @param string $property El nombre de la propiedad a buscar.
 * @param mixed $value El valor de la propiedad a buscar.
 * @return array El array modificado con el objeto eliminado.
 */
function eliminarDeArrayDeObjetos($array, $property, $value)
{
    foreach ($array as $key => $object) {
        $object = (object) $object;
        if (isset($object->$property) && $object->$property == $value) {
            unset($array[$key]);
        }
    }
    // Reindexar el array para mantener los índices consecutivos
    return array_values($array);
}

function buscar_productos_relacionados($request)
{
    global $wpdb;

    $data_result = array();
    $params = $request->get_params();

    $padre  = $params['id'];

    $sql = "SELECT f.*,p.post_title ,p.codigo_sap ,p.tipo_imputacion,p.cuenta, p.price, p.image_url, p.thumbnail_prod, p.post_content, p.marca,p.observacion,p.tipo, p.categorias
    FROM wp_materiales_relacionados as f
    INNER JOIN productos AS p ON f.id_material = p.id 
    WHERE f.id_padre = '$padre' AND f.cantidad_defecto > 0";


    $materiales_relacionados = $wpdb->get_results($sql, OBJECT);

    $product_parent = $wpdb->get_row("select * from productos where id = '$padre'", OBJECT);
    $items_categorias = get_categories_relation_data();


    $productos_con_info = [];


    foreach ($materiales_relacionados as $producto) {

        $categorias_producto_info = array();

        $cats_format = [];
        $cat_p = explode(',', $producto->categorias);


        foreach ($cat_p as $cat) {
            $cat_sel = findCategorytById($cat, $items_categorias);

            $cats_format[] = (object) array('term_id' => $cat_sel->id, 'name' => $cat_sel->nombre);
        }

        $productos_con_info[] = array(
            'ID' => $producto->id_material,
            'post_title' => $producto->post_title,
            'post_content' => $producto->post_content,
            'order' => 0,
            'price' => $producto->price,
            'cnt'   => 0,
            'image_url' => $producto->image_url,
            'thumbnail_prod' => '',
            'codigo_sap' => $producto->codigo_sap,
            'cuenta' => $producto->cuenta,
            'categorias' => $cats_format, // Agregar las categorías del producto al resultado
            'marca' => '',
            'observacion' => $producto->observacion,
            'tipo' => $producto->tipo,
            'cantidad_defecto' => $producto->cantidad_defecto
        );
    }


    return rest_ensure_response($productos_con_info);

    die();
}



function registrar_endpoint_formulas_relacionados()
{
    register_rest_route('ordenes_cristal/v1', '/get_related_formulas', array(
        'methods' => 'POST',
        'callback' => 'buscar_formulas_relacionados',
    ));
}
add_action('rest_api_init', 'registrar_endpoint_formulas_relacionados');

function findObjectById($array, $id)
{
    foreach ($array as $object) {
        if (isset($object->id) && $object->id_herraje == $id) {
            return $object;
        }
    }
    return null;
}

function updateObjectCntById($array, $id, $newCnt)
{

    $nw_data = [];

    foreach ($array as &$object) {
        if (isset($object->id_herraje) && $object->id_herraje == $id) {
            $object->cantidad_defecto = $newCnt;
        }

        array_push($nw_data, $object);
    }

    return $nw_data;
}



function buscarPorCodigoSAP($arrayObjetos, $codigoSAP)
{
    foreach ($arrayObjetos as $indice => $objeto) {
        if (isset($objeto['codigo_sap']) && $objeto['codigo_sap'] == $codigoSAP) {

            return $indice;
        }
    }
    return null; // Devuelve null si no se encuentra ningún objeto con ese codigo_sap
}




function buscar_formulas_relacionados($request)
{
    global $wpdb;

    $data_result = array();
    $params = $request->get_params();

    $marca = $params['marca'];
    $categoria = $params['categoria'];

    $formulas = base64_decode($params['formulas']);
    $formulas_data = json_decode($formulas);

    

    $herrajes_final = [];

    foreach ($formulas_data as $formula) {
        $sql = $wpdb->prepare("
            SELECT f.*, p.post_title, p.codigo_sap,p.cuenta, p.price, p.image_url, p.thumbnail_prod, p.post_content, p.marca, p.observacion, p.tipo, p.categorias
            FROM formulas_herrajes as f
            INNER JOIN productos AS p ON f.id_herraje = p.id
            WHERE f.id_marca = %s AND f.id_mundo = %d AND f.id_formula = %d AND f.cantidad_defecto > 0 AND p.tipo = 'herraje'
        ", $marca, $formula->id_mundo, $formula->id_formula);

   
      //  echo " formla cnt ".$formula->cnt;


        $herrajes_relacionados = $wpdb->get_results($sql, OBJECT);

        foreach ($herrajes_relacionados as $herraje) {
            $herraje->cantidad_defecto *= $formula->cnt; // Multiplicar por la cantidad_defecto de la fórmula

            $found = findObjectById($herrajes_final, $herraje->id_herraje);

            if ($found) {
                // Actualizar el valor cnt si el objeto ya existe en herrajes_final
                $newCnt = ($found->cantidad_defecto + $herraje->cantidad_defecto);

                $herrajes_final = updateObjectCntById($herrajes_final, $herraje->id_herraje, $newCnt);
            } else {
                // Añadir el objeto al array herrajes_final si no existe
                $herrajes_final[] = $herraje;
            }
        }
    }

    $items_categorias = get_categories_relation_data();

    $productos_con_info = [];

    foreach ($herrajes_final as $producto) {
        $categorias_producto_info = [];
        $cats_format = [];
        $cat_p = explode(',', $producto->categorias);

        foreach ($cat_p as $cat) {
            if(!empty($cat)){
            $cat_sel = findCategorytById($cat, $items_categorias);

            $cats_format[] = (object) array('term_id' => $cat_sel->id, 'name' => $cat_sel->nombre);
            }
        }

        
        // Obtener holguras desde la tabla holguras_herrajes
        $sql_holguras = $wpdb->prepare("
                                SELECT holgura_f, holgura_p
                                FROM holguras_herrajes
                                WHERE id_herraje = %d AND id_marca = %d
                            ", $producto->id_herraje, $marca);

        $holguras = $wpdb->get_row($sql_holguras, OBJECT);



        //cantidad con holguras
        $cnt_cal = floatVal($producto->cantidad_defecto) + floatVal($holguras->holgura_f) + ((floatVal($producto->cantidad_defecto) + $holguras->holgura_f)) * ($holguras->holgura_p / 100);

        

        // Si hay productos relacionados
        $sql_related = $wpdb->prepare("
        SELECT m.*, r.cantidad_defecto
        FROM wp_materiales_relacionados AS r
        INNER JOIN productos AS m ON r.id_material = m.ID
        WHERE r.id_padre = %d
        ", $producto->id_herraje);


        $productos_relacionados = $wpdb->get_results($sql_related, OBJECT);

        if (count($productos_relacionados) < 0) {
            foreach ($productos_relacionados as $productoh) {


                $resultado = buscarPorCodigoSAP($productos_con_info, $productoh->codigo_sap);

                if ($resultado !== null) {


                    //      echo " encontrado h ".$productos_con_info[$resultado]['codigo_sap'].' -> '.$productos_con_info[$resultado]['cnt'];

                    $productos_con_info[$resultado]['cnt'] += (float) $producto->cantidad_defecto * (float) $productoh->cantidad_defecto;

                    //      echo " tcn: ".$productos_con_info[$resultado]['cnt'];
                } else {


                    $categorias_producto_info = [];
                    $cats_format = [];
                    $cat_p = explode(',', $productoh->categorias);

                    foreach ($cat_p as $cat) {
                        $cat_sel = findCategorytById($cat, $items_categorias);
                        $cats_format[] = (object) array('term_id' => $cat_sel->id, 'name' => $cat_sel->nombre);
                    }

                    $parent_id = $producto->codigo_sap;

                    $data = array(
                        'id' => $productoh->id,
                        'post_title' => ' (H: ' . $parent_id . ') ' . $productoh->post_title,
                        'post_content' => $productoh->post_content,
                        'order' => 0,
                        'price' => $productoh->price,
                        'cnt' => roundCantidadF($cnt_cal * (float) $productoh->cantidad_defecto),
                        'image_url' => $productoh->image_url,
                        'thumbnail_prod' => '',
                        'codigo_sap' => $productoh->codigo_sap,
                        'cuenta' => $productoh->cuenta,
                        'categorias' => $cats_format, // Agregar las categorías del producto al resultado
                        'marca' => $productoh->marca,
                        'observacion' => $productoh->observacion,
                        'tipo' => $productoh->tipo,
                        'cantidad_defecto' => (float) $cnt_cal * (float) $productoh->cantidad_defecto,
                        'holgura_f' => 0,
                        'holgura_p' => 0,
                        'padre_id' => $parent_id
                    );



                    $productos_con_info[] = $data;
                }
            }
        }

        $resultado = buscarPorCodigoSAP($productos_con_info, $producto->codigo_sap);

        if ($resultado !== null) {
            //  echo " encontrado p ".$productos_con_info[$resultado]['codigo_sap'].' -> '.$productos_con_info[$resultado]['cnt'];

            $productos_con_info[$resultado]['cnt'] += (float) $producto->cantidad_defecto;

            // echo " tcnp : ".$productos_con_info[$resultado]['cnt'];    

        } else {
            //echo "No se encontró ningún objeto con ese código SAP.";

            $data = array(
                'id' => $producto->id_herraje,
                'post_title' => '(P) ' . $producto->post_title,
                'post_content' => $producto->post_content,
                'order' => 0,
                'price' => $producto->price,
                'cnt' => roundCantidadF($cnt_cal),
                'image_url' => $producto->image_url,
                'thumbnail_prod' => '',
                'codigo_sap' => $producto->codigo_sap,
                'cuenta' => $producto->cuenta,
                'tipo_imputacion' => $producto->tipo_imputacion,
                'categorias' => $cats_format, // Agregar las categorías del producto al resultado
                'marca' => $producto->marca,
                'observacion' => $producto->observacion,
                'tipo' => $producto->tipo,
                'cantidad_defecto' => (float) $producto->cantidad_defecto,
                'holgura_f' => (int) $holguras->holgura_f,
                'holgura_p' => (int) $holguras->holgura_p,
            );

            $productos_con_info[] = $data;
        }
    }

    return rest_ensure_response($productos_con_info);
}

function roundCantidadF($value)
{
    return ceil($value); // Ajusta el redondeo según sea necesario
}

add_action('wp_ajax_validate_codigo_sap', 'validate_codigo_sap');
add_action('wp_ajax_nopriv_validate_codigo_sap', 'validate_codigo_sap');

function validate_codigo_sap() {
    global $wpdb;

    // Verificar si se recibió un parámetro 'codigo_sap'
    if (isset($_POST['codigo_sap'])) {
        $codigo_sap = sanitize_text_field($_POST['codigo_sap']);
        
        // Consulta a la tabla 'productos' en la base de datos de WordPress
        $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM productos WHERE codigo_sap = %s", $codigo_sap));

        if ($result > 0) {
            wp_send_json_error('Este código SAP ya existe.');
        } else {
            wp_send_json_success('Este código SAP es válido.');
        }
    }
    
    wp_die();
}
