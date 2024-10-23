      <!-- The Modal search-->
<div class="modal cart" id="modalAddProduct" style="margin-top:50px;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <style>
    .error {
        color: red;
    }
</style>
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar nuevo producto a la orden</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="prdForm" class="row">

                   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código sap</label>
                                <input type="text" name="codigo_sap" class="form-control">
                            </div>
                            <div class="form-group"> 
                                <label>Tipo imputación</label>
                                <input type="text" name="tipo_imputacion" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Cuenta</label>
                                <input type="text" name="cuenta" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="post_title">Nombre</label>
                                <input type="text" name="post_title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="post_content" class="form-control"></textarea>
                            </div>

                            
                            <!-- <div class="form-group">
                                <label>Marca

                              
                                </label>
                                <select name="categorias" class="form-control" ng-model="categoriaSeleccionada">
                                    <option value=""></option>
                                    <?php foreach ($marcas as $marca) {
                                       
                                    ?>
                                            <option value="<?= $marca['ID'] ?>"><?= $marca['post_title'] ?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Categoria</label>

                                <select name="categorias" class="form-control" ng-model="categoriaSeleccionada">
                                    <option value="">Seleciona una categoria</option>
                                    <?php foreach ($categorias as $cat) {
                                     
                                    ?>
                                            <option value="<?= $cat->id ?>"><?= $cat->nombre ?></option>
                                    <?php }
                                  
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" name="cnt" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea name="observacion" class="form-control"></textarea>
                            </div>
                        </div>
                   

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-generic" onclick="AddNewProduct()">Guardar</button>
                <button type="button" class="btn btn-outline-generic" data-dismiss="modal">Cerrar</button>
            </div>

            </form>

        </div>
    </div>
</div>
