<?php
/*
Template Name: Catalog Template
*/

get_header();

$marcas = obtener_marcas();
$tiendas = obtener_tiendas();
$categorias = get_categories_relation_data();



?>
<style>
    <?php include './../style.css'; ?>
</style>

<div class="wrapper">

    <div id="primary" class="content-area" ng-controller="cartSearchController">
        <main id="main" class="site-main">




            <div class="">
                <div class="" id="filter-area">
                    <div class="row">

                        <div class="col-md-6 pt-4 pl-5">
                            <?php foreach ($marcas as $marca) {
                                if ($marca['image'] != '') { ?>
                                    <a role="button" id="menuma-<?= $marca['ID'] ?>" class="marco-marca-m" ng-click="setMarca(<?= $marca['ID'] ?>,'<?= $marca['image'] ?>','<?= $marca['post_title'] ?>')">
                                        <img src="<?= $marca['image'] ?>" style="height:50px; width:70px" />
                                    </a>
                            <?php }
                            } ?>
                        </div>
                        <div class="col-md-6">
                            <div class="dropdown filter-dropdown text-center pt-4">
                                <select class="form-control" ng-model="tiendaSeleccionada" id="sltienda" ng-change="selectTienda()">
                                    <option value="">Tienda</option>
                                    <?php foreach ($tiendas as $tienda) {

                                    ?>
                                        <option value="<?= $tienda->metros_cuadrados ?>"><?= str_replace('-', ' ', $tienda->post_title) ?></option>
                                    <?php }

                                    ?>
                                </select>
                            </div>


                            <div class="dropdown filter-dropdown text-center pt-4">
                                <select class="form-control" ng-model="categoriaSeleccionada" id="slcategoria" ng-change="selectCategoria()">
                                    <?php foreach ($categorias as $cat) {
                                    ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->nombre ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group text-center pt-4">

                                <button type="button" class="btn btn-outline-generic" ng-click="buscarProductos(1)">
                                    <div class="cart-loader"></div> Buscar
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3 ng-if="marcaNameSel">{{marcaNameSel}}</h3>
                        </div>
                        <div class="col-md-6 text-right">

                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Formulas herrajes</a>
                                <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Materiales</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                                <div class="container">

                                    <div class="row p-2">
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3">

                                            <button ng-if="formulas.length > 0 " type="button" class="btn btn btn-outline-generic " ng-click="addCartH()">Agregar al pedido</button>
                                        </div>
                                    </div>


                                    <div ng-if="formulas.length == 0 " class="d-flex  align-items-center justify-content-center text-center" style="height: 35em;" role="alert">

                                        <img src="<?= site_url('wp-content/images/logo_1.png') ?>" alt="Logo" style="margin-bottom: 3%;">
                                        <p class="no-search"> Seleccione una tienda y una marca para obtener el listado </p>

                                    </div>

                                    <div class="row mb-1 border" ng-repeat="f in formulas">
                                        <div class="col-md-3" ng-style="{'background-color': f.color}">

                                            <b>{{f.title}}</b>


                                        </div> <!-- Columna vacía izquierda -->
                                        <div class="col-md-9">
                                            <!-- Tres filas dentro de la columna -->
                                            <div class="row mb-1 p-1" ng-repeat="mf in f.formulas">
                                                <div class="col-md-8">{{mf.title}}</div>
                                                <div class="col-md-4"><input type="text" ng-model="mf.cnt" /></div>
                                            </div>

                                              <!-- Mundos hijos y sus fórmulas -->
                                              <div ng-repeat="sm in f.submundos">
                                                        <div class="row mt-2 p-1" ng-style="{'background-color': sm.color}">
                                                            <div class="col-md-12"><b>{{sm.title}}</b></div>
                                                        </div>
                                                        <div class="row mb-1 p-1" ng-repeat="mf in sm.formulas">
                                                            <div class="col-md-8">{{mf.title}}</div>
                                                            <div class="col-md-4"><input type="text" ng-model="mf.cnt" /></div>
                                                        </div>
                                                </div>

                                        </div>
                                    </div>

                                    
                                </div>

                            </div>
                            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">



                                <div ng-if="sresult.length == 0 " class="d-flex  align-items-center justify-content-center text-center" style="height: 35em;" role="alert">

                                    <img src="<?= site_url('wp-content/images/logo_1.png') ?>" alt="Logo" style="margin-bottom: 3%;">
                                    <p class="no-search"> Seleccione una tienda y una marca para obtener el listado </p>

                                </div>


                                <div class=" mt-3" id="angresults" ng-if="sresult.length > 0 " directive-when-scrolled="cargarMas()">





                                    <div class="bg-row row mb-2 border p-2 rounded" ng-repeat="r in sresult | limitTo: limit | orderBy:'orderAsNumber'">

                                        <div class="col-md-2 text-center p-2 thumbnail-container ">

                                            <img class="thumbnail rounded" ng-src="{{ r.image_url }}" alt="Producto" />

                                        </div>
                                        <div class="col-md-8">
                                            <div class="text-item-block"><b>Código: {{r.codigo_sap}} </b></div>
                                            <div class="text-item-block"><b>Cuenta: {{r.cuenta}} </b></div>
                                            <div class="text-item-block"><b>Cosecutivo: {{r.order}} </b></div>
                                            <div class="text-item-block">{{r.post_title}}</div>
                                            <div class="text-item-block">Catégoria:
                                                <span class="lead-1" ng-repeat="c in r.categorias">
                                                    {{c.name}}
                                                </span>
                                            </div>



                                            <p class="text-justify p-1 ">{{r.post_content}} </p>

                                            <div class="text-item-block" ng-if="r.related.length > 0">Relacionados:
                                                <span class="lead-1" ng-repeat="rl in r.related" style="padding:2px; font-style:italic; font-size:11px; border-radius:2px; font-weight:400 ;margin-right:2px">
                                                    {{rl.codigo_sap}} - {{rl.post_title}} (x{{rl.cantidad_defecto}}) / 
                                                </span>
                                            </div>


                                        </div>
                                        <div class="col-md-2 cart_sel_continer">
                                            <div class=" text-item-block">


                                                <div class="w-100">

                                                    Precio: <span class="vright">{{r.price | currency: '$'}}</span>
                                                </div>
                                                <div class="w-100 dqty">
                                                    <span>Cantidad: </span> <input type="number" ng-class="{'qtyMinicartInput item-id-': r.ID}" ng-model="r.cnt" value="1">
                                                </div>
                                            </div>


                                            <div class="text-center text-item-block">
                                                <hr>
                                                <button class="btn w-80 btn-outline-generic" ng-click="addCart(r.ID,$event)">Agregar a la orden</button>
                                            </div>

                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>






            </div>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

    <?php include 'modalRelated.php' ?>

</div><!-- .container -->

<?php get_footer(); ?>