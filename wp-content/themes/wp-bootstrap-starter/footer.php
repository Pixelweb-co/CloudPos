<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */


global $post;
if (isset($post->post_name)) {
	$post_slug = $post->post_name;
} else {
	$post_slug = '';
}


?>
<?php if (!is_page_template('blank-page.php') && !is_page_template('blank-page-with-container.php')) : ?>
	</div><!-- .row -->
	</div><!-- .container -->
	</div><!-- #content -->


	<?php if ($post_slug != 'login') { ?>
	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
		<div class="container-fluid pt-3 pb-3 first-row-colo">
			

				<!-- <div class="row d-flex align-items-stretch">
					<div class="col-md-2 mb-3 d-flex flex-column align-items-center justify-content-center text-center">
						<img src="<?= site_url('wp-content/images/Logo-crystal-transparente1.png') ?>" alt="Imagen" class="img-fluid">

					</div>
					<div class="col-md-2 mb-3 d-flex flex-column">
						<h2 class="texto-titulo-footer">Sobre nosotros</h2>
						<ul class="texto-parrafo-footer">
							<li><a href="url1">Quiénes somos</a></li>
							<li><a href="url2">Propósito y esencia</a></li>
							<li><a href="url3">Nuestra historia</a></li>
							<li><a href="url4">Hilanderia</a></li>
							<li><a href="url5">Paquete completo</a></li>
							<li><a href="url6">Marcas</a></li>
							<li><a href="url7">Ubicación</a></li>
						</ul>
					</div>
					<div class="col-md-2 mb-3 d-flex flex-column">
						<h2 class="texto-titulo-footer">Sostenibilidad</h2>
						<ul class="texto-parrafo-footer">
							<li><a href="url1">Nuestro compromiso</a></li>
							<li><a href="url2">Compromiso social</a></li>
							<li><a href="url3">Compromiso ambiental</a></li>
							<li><a href="url4">Certificaciones</a></li>
						</ul>
					</div>
					<div class="col-md-2 mb-3 d-flex flex-column">
						<h2 class="texto-titulo-footer">Cumplimiento</h2>
						<ul class="texto-parrafo-footer">
							<li><a href="url1">Gobierno corporativo</a></li>
							<li><a href="url2">Programa ético así somos</a></li>
							<li><a href="url3">Políticas</a></li>

						</ul>
					</div>
					<div class="col-md-1 mb-3 d-flex flex-column">
						<ul class="texto-parrafo-footer texto-parrafo-footer-contacto">
							<li><a href="url1">Contáctanos</a></li>
							<li><a href="url2">Empleo</a></li>
							<li><a href="url3">Innova</a></li>
							<li><a href="url4">Ingreso</a></li>
							<li><a href="url5">Proveedores</a></li>

						</ul>
					</div>
					<div class="col-md-3 d-flex flex-column text-center">
						<h2 class="texto-titulo-footer text-center">Redes sociales</h2>
						<div class="d-flex  mb-3 align-items-center justify-content-center text-center">
							<a href="url_de_facebook" target="_blank">
								<img src="<?= site_url('wp-content/images/face.png') ?>" alt="Facebook" class="mr-2">
							</a>

							<a href="url_de_facebook" target="_blank">
								<img src="<?= site_url('wp-content/images/instagram.jpeg') ?>" style="width:26px;height:26px" alt="Instagram" class="mr-2">

							</a>
							<a href="url_de_facebook" target="_blank">
								<img src="<?= site_url('wp-content/images/in.png') ?>" alt="LinkedIn">

							</a>
							<a href="url_de_facebook" target="_blank">
								<img src="<?= site_url('wp-content/images/Vine.png') ?>" alt="Vimeo" class="ml-2">

							</a>
						</div>
						<p>Encuéntranos como Crystal S.A.S</p>
						<div class="d-flex  justify-content-center text-center">
							<img src="<?=site_url('wp-content/images/telefono.png')?>" alt="Teléfono" class="image-telefono">
							<p class="num-telefono">(604) 604 96 00</p>
						</div>
					</div>
				</div> -->
			

			<div class="row row-color">
				<div class="col-md-5 align-items-center   d-flex">
					Colombia | &copy; <?php echo date('Y'); ?> <?php echo '<a href="' . home_url() . '">' . get_bloginfo('name') . '</a>'; ?>
					<span class="sep"> | </span>
					<a href="url_de_terminos_y_condiciones">Terms and Conditions</a> |
					<a href="url_de_politica_de_privacidad">Privacy Policy and Notice</a>
				</div>
				<div class="col-md-7 align-items-center justify-content-center text-center d-flex">
					<a href="#" taret="_blank">
						<img src="<?= site_url('wp-content/images/gef.png') ?>" alt="Gef" class="mr-2">
					</a>
					<a href="#" target="_blank">
						<img src="<?= site_url('wp-content/images/punto_blanco.png') ?>" alt="Punto_blanco" class="mr-2">
					</a>
					<a href="#" target="_blank">
						<img src="<?= site_url('wp-content/images/hcl-logo.png') ?>" alt="Baby_fresh" class="mr-2">
					</a>
					<a href="#" target="_blank">
						<img src="<?= site_url('wp-content/images/logo-galax.png') ?>" alt="Galax" class="mr-2">
					</a>
					<a href="#" target="_blank">
						<img src="<?= site_url('wp-content/images/Parfois1.png') ?>" alt="Parfois1" class="mr-2">
					</a>
					<a href="#" target="_blank">
						<img src="<?= site_url('wp-content/images/img_casino.png') ?>" alt="Casino" class="mr-2">
					</a>
				</div>
			</div>


		</div><!-- close .site-info -->
	</footer><!-- #colophon -->
	<?php } ?>
	<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>