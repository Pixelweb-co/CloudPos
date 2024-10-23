<br />
<div class="container-fluid">
    <div class="row mt-20" ng-controller="cartController" id="cartController">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h2>Pedido <span ng-if="orden_id">#{{orden_id}}</span></h2>
                </div>

                <div class="col-md-4">
                    <h2>Tienda: {{tienda_name}}</h2>
                </div>
                <div class="col-md-4">
                    <h2>Marca: {{name_marca}}</span></h2>
                </div>


            </div>

        </div>

        <div class="col-lg-8">
            <div class="table-cart">
                <table id="table-cart-items">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Código sap</th>
                            <th>Total</th>
                            <th>Cantidad</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr ng-repeat="x in items | orderBy: '-x.ID'" style="position: relative;">
                            <td>

                                <div class="display-flex align-center">
                                    <div class="img-product">
                                        <img ng-src="{{x.image_url}}" alt="" class="mCS_img_loaded">
                                    </div>
                                    <div class="name-product">
                                       
                                    <p>{{x.post_title}}</p>
                                    <b>Codigo sap:</b> {{x.codigo_sap}}<br />    
                                        <b>Cuenta:</b> {{x.cuenta}}<br />
                                        <b>Categoria:</b> <span ng-repeat="cx in x.categorias" class="mr-2">{{cx.name}}</span>
                                    </div>
                                </div>
                                </div>
                                <div class="observ_field ">
                                    <b>Observación:</b>
                                    <textarea class="form-control" ng-model="x.observacion" placeholder="Escribe alguna observacíon adicional"></textarea>

                                </div>
                                </td>
                                <td class="code-product">{{x.codigo_sap}}</td>
                                <td>
                                    <div class="total">
                                        {{x.subtotal | currency: '$'}}
                                    </div>
                                </td>

                                <td class="product-count">
                                    <form action="#" class="count-inlineflex" ng-if="orden_is_send == 0">
                                        <div class="qtyminus" ng-click="setQty('minus',x.ID)" role="button">-</div>
                                        <input type="text" name="quantity" ng-model="x.cnt" class="qty" ng-blur="actualizarCantidad(x)">
                                        <div class="qtyplus" role="button" ng-click="setQty('add',x.ID)">+</div>
                                    </form>

                                    <span ng-if="orden_is_send == 1">{{x.cnt}}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn  btn-xs" ng-click="removeItem(x.ID)" ng-if="orden_is_send == 0">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="obs-toggle ml-4 btn btn-xs">
                                        <i class=" fa fa-caret-up" aria-hidden="true"></i>

                                    </button>

                                </td>

            </tr>
            </tbody>
            </table>

            <div class="total_order_d row">
                <div class="col-md-10 text-right total_order_v">Total Pedido:</div>
                <div class="col-md-2 text-center total_order_v"> {{total_order | currency: '$'}}</div>
            </div>
            <div class=" row mt-4 mb-3">
                <div class="col-md-4 text-center "><a class="btn btn-outline-generic" href="<?= site_url('/index.php/catalogo') ?>">Agregar mas productos</a></div>
                <div class="col-md-4 text-center "> <button type="button" class="btn btn-black-generic" ng-if="orden_is_send == 0" data-toggle="modal" data-target="#modalAddProduct">Agregar nuevo producto</a></div>
                <div class="col-md-4 text-center "><button class="btn btn-outline-generic" type="button" ng-click="NewOrder()">Nuevo Pedido</button></div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div style="padding-top: 20px;" ng-if="orden_is_send == 0"><b>Adjuntar documentos e imagenes:</b></div>
                    <div class="file-upload" id="file-upload">

                        <!-- ng-if err rev -->
                        <div id="box" class="animated bounceIn image-upload-wrap">
                            <div class="words">

                                <div class="drag-text">
                                    <h3>Seleccione un archivo y arrastrelo aqui</h3>
                                </div>
                            </div>

                        </div>

                        <div class="files" id="files"></div>

                        <div class="filese" id="files_edit">
                            <div class="file-name" ng-repeat="fe in files_edit"><span style="width: 20px; height:20px;"><a href="{{fe}}" target="_blank">{{getFileNameUrl(fe)}}</a></span> <button type="button" class="btn  btn-xs" ng-click="removeFileE(fe)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="enlaces-panel" style="padding-top: 20px;" ng-if="orden_is_send == 0">
                        <div class="container">
                            <div class="row " style="margin-bottom: 30px;">
                                <div class="col-md-6"><b>Agregar enlaces:</b></div>
                                <div class="col-md-6 text-right"> </div>
                            </div>

                            <div class="row" ng-repeat="l in links">
                                <div class="col-md-6"><a href="#">{{l}}</a></div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn  btn-xs" ng-click="removeLink(l)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">

                                    <input type="text" class="form-control" id="urlAdd" placeholder="Escribe o pega tu enlace aqui!" />
                                </div>
                                <div class="col-md-2 text-right">

                                    <button type="button" class="btn  btn-xs" ng-click="addLink()">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>

                                <div class="col-md-12" ng-if="linkError" style="color:red">
                                    {{linkError}}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <label>Observaciones</label>
                    <textarea name="observaciones" id="observaciones" ng-model="observaciones" cols="30" rows="5" class="form-control"></textarea>

                </div>

            </div>






        </div>
        <!-- /.table-cart -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="cart-totals">


            <?php include('panelStats.php'); ?>
            <div class="btn-cart-totals flex-d" ng-if="orden_is_send == 0">
                <button type="button" id="btnSaveOrder" class="btn btn-outline-generic ml-10" ng-click="guardarOrden()">
                    <div class="cart-loader"></div> <span class="title_btn">Guardar pedido</span>
                </button>

                <button type="button" ng-if="orden_id" id="btnSendOrder" class="btn btn-outline-generic mr-10">
                    <div class="cart-loader"></div> <span class="title_btn">Enviar</span>
                </button>
            </div>

        </div>
        <?php include('modalAddProduct.php'); ?>


    </div>
</div>