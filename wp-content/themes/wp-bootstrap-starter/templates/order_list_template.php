<?php
/*
Template Name: Order-list-template
*/

get_header();
$ordenes = get_orders_list();
$marcas = obtener_marcas();
$tiendas = obtener_tiendas();
$categorias = obtener_categorias();




?>
     

<div class="wrapper">
    
    <div id="primary-list" class="content-area" ng-controller="cartOrderListController">
        <main id="main" class="site-main">

        
            <div class="container mt-5">
                
                <div class="row">
                    <div class="col-md-12"><h2>Pedidos</h2></div>
                    <div class="col-md-12">

                        <?php if (count($ordenes) > 0) { ?>
                        <table border="0" id="order-list-table">
                            <thead>
                                <tr class="tr-border">
                                <th>Marca</th>
                                <th>Pedido</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                            </thead>
                            <?php 
                            foreach($ordenes as $ord){ 
                                $cantidad_items_orden = 0;
                                
                                 foreach($ord['items'] as $item){
                                    $cantidad_items_orden += number_format($item->cnt);
                                 }

                                ?>
                            <tbody>
                                <tr class="tr-border">
                                    <td>
                                    <?=$ord['order']->name_marca?>    
                                    
                                    </td>
                                    <td><?=$ord['order']->id?></td>
                                    <td><?=$ord['order']->cliente_name?></td>
                                    <td><?=$ord['order']->fecha_orden?></td>
                                    <td>$<?=number_format($ord['order']->totalOrden)?></td>
                                    <td width="13%"><?=count($ord['items'])?></td>
                                    <td width="15%">
                                    <?php if($ord['order']->is_send == '0') { ?> 
                                    <button type="button" class="btn  btn-xs edit_order" data-id_orden="<?=$ord['order']->id?>">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </button>
<!--                                     
                                    <button type="button" class="obs-toggle-m ml-2 btn btn-xs btnEmailOrder" >
                                    <i class=" fa fa-envelope" aria-hidden="true"></i>
                                   
                                    </button> -->
                                       <?php } ?>  
                                    <button type="button" class="obs-toggle-l ml-2 btn btn-xs" >
                                    <i class=" fa fa-caret-up" aria-hidden="true"></i>
                                        
                                    </button>
                                     
                                    </td>
                                </tr>
                                <tr class="detail-order">
                                    <td colspan="5" class="pl-5 pr-5 pt-5">
                                            <table cellspacing="0" class="table-order-detail" style="margin-left:20%">
                                                <thead>
                                                    <tr>
                                                    <th></th>
                                                    <th>Producto</th>
                                                    <th>Código</th>
                                                    <th>Valor</th>
                                                    <th style="text-align: center; width:15%">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ord['items'] as $item){ ?>
                                                    <tr>
                                                        <td><img src="<?=$item->image_url?>" style="height:50px; width:70px"/></td>
                                                        <td><?=$item->post_title?></td>
                                                        <td><?=$item->codigo_sap?></td>
                                                        <td>$<?=number_format($item->price)?></td>
                                                        <td style="text-align: center; width:15%"><?=$item->cnt?></td>
                                                    </tr>
                                                    <?php }?>    
                                                </tbody>
                                            </table>

                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>    
                            
                        </table>
                        <?php }else{ ?>                                
                        <div  class="alert alert-secondary" style="margin-top: 25px;" role="alert">
                            Aun no hay pedidos registrados.
                            </div>        
                         <?php } ?>   

                    </div>
                </div>
         
            </div>   

        </main><!-- .site-main -->
    </div><!-- .content-area -->
</div><!-- .container -->

<?php get_footer(); ?>
