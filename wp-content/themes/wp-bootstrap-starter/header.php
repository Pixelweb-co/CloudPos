<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php

    // WordPress 5.2 wp_body_open implementation
    if (function_exists('wp_body_open')) {
        wp_body_open();
    } else {
        do_action('wp_body_open');
    }

    global $post;
    if (isset($post->post_name)) {
        $post_slug = $post->post_name;
    } else {
        $post_slug = '';
    }

    ?>

    <div id="page" class="site" ng-app="shoppingCart">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'wp-bootstrap-starter'); ?></a>
        <?php if (!is_page_template('blank-page.php') && !is_page_template('blank-page-with-container.php')) : ?>
            <!-- <header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
                <div class="container">
                    <nav class="navbar navbar-expand-xl p-0">
                        <div class="navbar-brand">
                            <?php if (get_theme_mod('wp_bootstrap_starter_logo')) : ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <img src="<?php echo esc_url(get_theme_mod('wp_bootstrap_starter_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                                </a>
                            <?php else : ?>
                                <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_url(bloginfo('name')); ?></a>
                            <?php endif; ?>

                            <input type="search" class="form-control" placeholder="Busca aqui el producto que desees!" />

                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <?php
                        $image_url = 'wp-content/images/catalogo.png';
                        $image_url_pedidos = 'wp-content/images/free-box.png';
                        $image_url_avatar = 'wp-content/images/avatar.png';
                        $random_name = 'Usuario' . rand(100, 999);

                        ob_start();
                        wp_nav_menu(array(
                            'theme_location'    => 'primary',
                            'container'         => 'div',
                            'container_id'      => 'main-nav',
                            'container_class'   => 'collapse navbar-collapse justify-content-end',
                            'menu_id'           => false,
                            'menu_class'        => 'navbar-nav',
                            'depth'             => 3,
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker(),
                        ));
                        $menu_output = ob_get_clean();
                        $menu_output = preg_replace('/<a.*?>(.*?)Inicio<\/a>/', '', $menu_output);

                        $menu_output = preg_replace('/<a.*?>(.*?)Catalogo<\/a>/', '<a href=""><img src="' . $image_url . '" alt="Catálogo"></a>', $menu_output);

                        $menu_output = preg_replace('/<a.*?>(.*?)hacer_pedido<\/a>/', '<a href="index.php/hacer_pedido/"><img src="' . $image_url_pedidos . '" alt="Hacer Pedidos"></a>', $menu_output);
                        $menu_output = preg_replace('/<a.*?>(.*?)Mi cuenta<\/a>/', '<a href="#"><img src="' . $image_url_avatar . '" alt="Avatar" > ' . $random_name . '</a>', $menu_output);


                        echo $menu_output;
                        ?>
                    </nav>
                </div>
            </header> -->

            <!-- <header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
    <div class="container">
        <nav class="navbar navbar-expand-xl p-0">
            <div class="navbar-brand mr-auto">
                <?php if (get_theme_mod('wp_bootstrap_starter_logo')) : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo esc_url(get_theme_mod('wp_bootstrap_starter_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    </a>
                <?php else : ?>
                    <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_url(bloginfo('name')); ?></a>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center  col-sm-5"> 
                <input type="search" class="form-control w-100 border-0 custom-bg-search"  />
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex align-items-center ml-auto">
            <?php


            $image_url_catalogo = 'wp-content/images/catal.png';
            $image_url = get_site_url('wp-content/images/lista_prod.png');
            $image_url_pedidos = 'wp-content/images/free-box.png';
            $image_url_avatar = 'wp-content/images/avatar.png';
            $random_name = 'Usuario' . rand(100, 999);

            ob_start();
            wp_nav_menu(array(
                'theme_location'    => 'primary',
                'container'         => 'div',
                'container_id'      => 'main-nav',
                'container_class'   => 'collapse navbar-collapse justify-content-end',
                'menu_id'           => false,
                'menu_class'        => 'navbar-nav',
                'depth'             => 3,
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker(),
            ));
            $menu_output = ob_get_clean();
            $menu_output = preg_replace('/<a.*?>(.*?)Inicio<\/a>/', '', $menu_output);


            $menu_output = preg_replace('/<a.*?>(.*?)Listado de pedidos<\/a>/', '<a href=""><img src="' . $image_url_catalogo . '" alt="catal"></a>', $menu_output);
            $menu_output = preg_replace('/<a.*?>(.*?)Catalogo<\/a>/', '<a href=""><img src="' . $image_url . '" alt="Catálogo"></a>', $menu_output);

            $menu_output = preg_replace('/<a.*?>(.*?)hacer_pedido<\/a>/', '<a href="index.php/hacer_pedido/"><img src="' . $image_url_pedidos . '" alt="Hacer Pedidos"></a>', $menu_output);
            $menu_output = preg_replace('/<a.*?>(.*?)Mi cuenta<\/a>/', '<a href="#"><img src="' . $image_url_avatar . '" alt="Avatar" > ' . $random_name . '</a>', $menu_output);


            echo $menu_output;
            ?>
              </div>
        </nav>
    </div>
</header> -->

            <?php if ($post_slug != 'login') { ?>

                <header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner" ng-controller="CartHeaderController">
                    <div class="container">
                        <nav class="navbar navbar-expand-xl p-0">
                            <div class="navbar-brand mr-auto">
                                <?php if (get_theme_mod('wp_bootstrap_starter_logo')) : ?>
                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                        <img src="<?php echo esc_url(get_theme_mod('wp_bootstrap_starter_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                                    </a>
                                <?php else : ?>
                                    <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_url(bloginfo('name')); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex align-items-center col-sm-5">

                            <?php if (get_the_title() == 'Catalogo') : ?>
                                <input type="search" class="form-control w-100 border-0 custom-bg-search" id="searchField" placeholder="Ingresa el codigo sap para buscar">
                                <span class="search-icon" ng-click="searchTerm()"></span>

                                <?php endif; ?>    
                            </div>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="d-flex align-items-center ml-auto">
                                <?php
                                //$image_url = site_url('wp-content/images/catalogo.png');
                                $image_url_listado = site_url('wp-content/images/catalogo.png');
                                $image_url_pedidos = site_url('wp-content/images/free-box.png');
                                $image_url_avatar = site_url('wp-content/images/avatar.png');
                                $random_name = 'Usuario' . rand(100, 999);

                                ob_start();
                                wp_nav_menu(array(
                                    'theme_location'    => 'primary',
                                    'container'         => 'div',
                                    'container_id'      => 'main-nav',
                                    'container_class'   => 'collapse navbar-collapse justify-content-end',
                                    'menu_id'           => false,
                                    'menu_class'        => 'navbar-nav',
                                    'depth'             => 3,
                                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                    'walker'            => new wp_bootstrap_navwalker(),
                                ));
                                $menu_output = ob_get_clean();
                                $menu_output = preg_replace('/<a.*?>(.*?)Inicio<\/a>/', '', $menu_output);

                                $menu_output = preg_replace('/<a.*?>(.*?)Listado de pedidos<\/a>/', '<a href="' . site_url('index.php/listado-de-pedidos') . '"><img src="' . $image_url_listado . '" alt="Listado de pedidos" class="menu-image"></a>', $menu_output);

                                $menu_output = preg_replace('/<a.*?>(.*?)hacer_pedido<\/a>/', '<a href="' . site_url('index.php/hacer_pedido') . '"><img src="' . $image_url_pedidos . '" alt="Hacer Pedidos" class="menu-image"></a>', $menu_output);
                                $menu_output = preg_replace('/<a.*?>(.*?)Mi cuenta<\/a>/', '<a href="#"><img src="' . $image_url_avatar . '" alt="Avatar" > ' . $random_name . '</a>', $menu_output);

                                echo $menu_output;
                                ?>
                            </div>
                        </nav>
                    </div>
                </header>

            <?php } ?>




            <!-- #masthead -->
            <?php if (is_front_page() && !get_theme_mod('header_banner_visibility')) : ?>
                <!-- <div id="page-sub-header" <?php if (has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
                    <div class="container">
                        <h1>
                            <?php
                            if (get_theme_mod('header_banner_title_setting')) {
                                echo esc_attr(get_theme_mod('header_banner_title_setting'));
                            } else {
                                echo 'WordPress + Bootstrap';
                            }
                            ?>
                        </h1>
                        <p>
                            <?php
                            if (get_theme_mod('header_banner_tagline_setting')) {
                                echo esc_attr(get_theme_mod('header_banner_tagline_setting'));
                            } else {
                                echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize', 'wp-bootstrap-starter');
                            }
                            ?>
                        </p>
                        <a href="#content" class="page-scroller"><i class="fa fa-fw fa-angle-down"></i></a>
                    </div>
                </div> -->
            <?php endif; ?>

            <script>
                var base_url = '<?= get_site_url() ?>'
                var nonce = '<?php echo wp_create_nonce('wp_rest'); ?>'
            </script>

            <div id="content" class="site-content">
                <div class="container-fluid">
                    <div class="row-fluid">

                        <?php
                        if ($post_slug != 'hacer_pedido') {
                        ?>
                            <!-- #slider cart resume -->

                        <?php
                        }

                        ?>




                    <?php endif; ?>