
<div class="container-fluid"  ng-controller="cartController">
    
    <div class="row">
        <div class="col-md-9">

    <div class="card shopping-cart" >
            <div class="card-header bg-default">
                    <div class="row">
                        <div class="col-md-3 text-center"><b>Producto</b></div>
                        <div class="col-md-2 text-center"><b>Código</b></div>
                        <div class="col-md-2 text-center"><b>Valor</b></div>
                        <div class="col-md-3 text-center"><b>Cantidad</b></div>
                        <div class="col-md-2 "></div>
                    </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body" >
    
            <!-- PRODUCT -->
                    <div class="row border p-5 mb-2" ng-repeat="x in items">
                        <div class="col-12 col-sm-12 col-md-2 text-center">
                                <img class="img-responsive" ng-src="{{x.image_url}}" alt="prewiew" width="120" height="80">
                        </div>
                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-2">
                            <h4 class="product-name"><strong>{{ x.post_title }}</strong></h4>
                            <h4>
                                <small>Categoria:</small> <small ng-repeat="cx in x.categorias">{{cx.name}}</small>
                            </h4>
                            <h4>
                                <small>Marca:</small> <small ng-repeat="cx in x.categorias">{{cx.name}}</small>
                            </h4>
                        </div>
                        <div class="col-12 col-sm-12 text-sm-center col-md-8 text-left row">
                        <div class="col-2 col-sm-2 col-md-2 text-left" style="padding-top: 5px">
                            <h6><strong>${{x.sku}} 456465465</strong></h6>
                            </div>
                        
                        <div class="col-2 col-sm-2 col-md-2 text-left" style="padding-top: 5px">
                            <h6><strong>${{x.subtotal}} </strong></h6>
                            </div>
                            <div class="col-5 col-sm-5 col-md-4">
                                <div class="quantity">
                                    <input type="button" value="+" class="plus" ng-click="setQty('add',x.ID)">
                                    <input type="text" step="1" max="99" min="1" ng-value="x.cnt" title="Qty" class="qty"
                                           size="4">
                                    <input type="button" value="-" class="minus" ng-click="setQty('minus',x.ID)">
                                </div>
                            </div>
                            
                            <div class="col-4 col-sm-4 col-md-4 text-center">
                                <button type="button" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    
                        <div class="col-md-12 p-5 ">
                            <textarea class="form-control ml-20" placeholder="Observación"></textarea>
                        </div>
                    
                    
                    
                    
                    
                    </div>


                    <hr>
                    <div class="row">
                        <div class="col-md-8" style="text-align:right"><b>Total Pedido: </b></div>
                        <div class="col-md-4" style="text-align:center">$<span id="total_orden">{{total_order}}</span></div>
                    </div>
  
            </div>

    </div>

    </div>
        <div class="col-md-3">
          <?=include('panelStats.php') ?>
        </div>
    </div>


    <?=include('modalSearch.php') ?>
    <?=include('modalAddProduct.php') ?>


</div>  