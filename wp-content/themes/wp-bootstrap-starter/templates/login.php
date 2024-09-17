<?php
/*
Template Name: Login Template
*/

get_header();

?>
<style>
    <?php include './../style.css'; ?>
</style>

<div class="wrapper">

    <div id="primary" class="content-area" >
        <main id="main" class="site-main">

    <div class="row" style="height: 100vh;">
        <div class="col-md-5" >
         <div class="login-main-text">
            <h1>Intranet<br> Pedidos y reformas</h1>
         </div>
        <div>

            <img src="<?=site_url('wp-content/uploads/2024/03/Logo-crystal-2.png')?>"/> 

        </div>

      </div>
      <div class="col-md-7  bg-black">
         <div class="col-md-12 col-sm-12">
            <div class="login-form w-50">
                <div class="dt"></div>
                    <?=do_shortcode('[theme-my-login]')?>

               <div id="login-error"></div>
            </div>
         </div>
      </div>
      </div>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
</div><!-- .container -->
<script>

jQuery(document).ready(function($) {
    $('#btnSendOrder').click(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: formData + '&action=custom_login',
            success: function(response) {
                if (response.success) {
                    $('#login-error').html('Inicio de sesión exitoso');
                    // Aquí puedes redirigir a otra página si es necesario
                    location.href = base_url;
                } else {
                    $('#login-error').html(response.data.message);
                }
            },
            error: function(xhr, status, error) {
                
                $('#login-error').html(xhr.responseText);
            }
        });
    });
});

</script>


<?php get_footer(); ?>


<style>




.main-head{
    height: 150px;
    background: #FFF;
   
}

.sidenav {
    height: 100%;
    overflow-x: hidden;
    padding-top: 20px;
}


.main {
    padding: 0px 10px;
    background-color: black !important;
    height: 100% !important;

}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
}

@media screen and (max-width: 450px) {
    .login-form{
        margin-top: 10%;
    }

    .register-form{
        margin-top: 10%;
    }
}


.login-main-text{
    margin-top: 20%;
    padding: 60px;
    color: #FFF;
}

.login-main-text h2{
    font-weight: 400;
}

.btn-submit{
    background-color: #FFF !important;
    color: #000;
}

.bg-black{
    background-color: #000;
    color:#FFF;
}

.login-main-text h1{
    color: #000;
    font-style: italic;
}

#login-error{
    color: #FFF;
    width: 100%;
    margin-top: 10px;
    text-align: center;
}



.login-form{
    margin-left: 25% !important;
    margin-top: 25% !important;
    background-color: white !important;
    padding: 25px !important;
    color: #000;
    border-radius: 5px !important;
}

.login-form ul{

    list-style: none;
}



</style>
