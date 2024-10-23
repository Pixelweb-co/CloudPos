        <!-- The Modal search-->
        <div class="modal cart" id="modalSearchProducts" style="margin-top:50px;">
        <div class="modal-dialog modal-lg-search">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Busqueda de productos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-md-2">
                            <select class="form-control" ng-model='marcaSeleccionada'>
                                <option value="">Marca</option>
                                <?php foreach($marcas as $marca){
                                
                                    ?>
                                    <option value="<?=$marca->ID?>"><?=$marca->post_title?></option>
                                <?php } 
                                
                                ?>    
                            </select>
                            
                        </div>
                        <div class="col-md-2">
                        <select class="form-control" ng-model="categoriaSeleccionada">
                                <option value="">Categoria</option>
                                <?php foreach($categorias as $cat){
                                    if($cat->name != 'Sin categorizar'){
                                    ?>
                                    <option value="<?=$cat->term_id?>"><?=$cat->name?></option>
                                <?php } 
                                }
                                ?>        
                            </select>
                        </div>

                        <div class="col-md-2">
                                
                        <select class="form-control" ng-model="tiendaf">
                        <option value="">Tienda</option>
                                <?php foreach($tiendas as $tienda){
                                
                                    ?>
                                    <option <?=$tienda->ID?>><?=$tienda->post_title?></option>
                                <?php } 
                                
                                ?>    
                        </select>        
                        </div>       
                        <div class="col-md-3">
                            <input type="search" class="form-control" ng-model="productof" placeholder="Nombre de producto"/>
                        </div>
                        <div class="col-md-3">
                        <button type="button" class="btn btn-primary" ng-click="buscarProductos()">
                        <i class="fa fa-glass" aria-hidden="true"></i> Buscar 
                        </button>

                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="container-fluid">

                         
                                
                                <div class="row">
                <div class="col-lg-12 my-3">
                    <div class="pull-right">
                        <div class="btn-group">
                            <button class="btn btn-info" id="list">
                                List View
                            </button>
                            <button class="btn btn-danger" id="grid">
                                Grid View
                            </button>
                        </div>
                    </div>
                </div>
            </div> 
            <div id="products" class="row view-group">
                        <div class="item col-xs-4 col-lg-4" ng-repeat="r in sresult">
                            <div class="thumbnail card">
                                <div class="img-event">
                                    <img class="group list-group-image img-fluid"  ng-src="{{ r.image_url }}" alt="" />
                                </div>
                                <div class="caption card-body">
                                    <h4 class="group card-title inner list-group-item-heading">
                                        {{r.post_title}}</h4>
                                    <p class="group inner list-group-item-text">
                                        {{r.post.content}}</p>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <p class="lead">
                                                ${{r.price}}</p>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <button class="btn btn-success" ng-click="addCart(r.ID)">Agregar a la orden</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                                </div>
                                


                    </div>
                </div>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

            </div>
        </div>


        </div>