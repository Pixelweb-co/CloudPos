
<?php
$cart = new Cart();
$cart_items = $cart->contents();
    
    $categorias = obtener_categorias();
    $marcas = obtener_marcas();
    $tiendas = obtener_tiendas();
    
    ?>
<div class="container-fluid" id="MiniCart" ng-controller="miniCartController">
    

    <div class="row">
        <div class="col-md-6">
            
            <h3 class="left">Pedido</h3>
        </div>

        <div class="col-md-6">
            <button type="button" onclick="hideMiniCart()"  class="btn right mr-50 close_minicart w-100 h-100">X</button>
            </div>
    </div>
    <hr/>
    <div class="row-fluid overflow-auto" style="height: 150px;">
        
        <div class="col-md-12  "  ng-repeat="x in items">
                   <div class="row">     
                        <div class="col-12 col-sm-12 col-md-4 text-center">
                                <img class="img-responsive" ng-src="{{x.image_url}}" alt="prewiew" >
                        </div>
                        <div class="col-md-6">
                            <b>Código: {{x.sku}}</b><br/>
                            <small >{{x.post_title}}</small>
                            <p class="mt-3">
                                 <small>
                                <input type="number" class="qtyMinicartInput" ng-value="{{x.cnt}}" onchange="setQty(e,x.ID)"/>
                            </small> 
                            <small><span class="text-success">$</span>{{x.subtotal | currency: ''}}</small></p>
                        </div>
                        <div class="col-md-2 text-center p-1">
                        <button type="button" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                        </div>
                    
                    </div>
                <hr/>    
                </div>

    </div>
   
    <hr/>
    <div class="row">

<div class="col-md-7"><b>Total pedido:</b></div>
<div class="col-md-5"><b>{{total_order | currency: '$'}}</b></div>

</div>
    <hr/>
    <?php include('panelStats.php')?>
    </div>
    
    <hr/>
    <div class="row">

         <div class="col-md-6" style="text-align: center"><button type="button" class="btn btn-outline-generic">Enviar</button></div>
         <div class="col-md-6" style="text-align: center"><a role="button" href="<?=site_url('index.php/hacer_pedido')?>" class="btn btn-outline-generic">Ver pedido</a></div>
        
    </div>


</div>  