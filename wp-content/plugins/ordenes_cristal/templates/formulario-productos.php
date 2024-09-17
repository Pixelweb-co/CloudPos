<?php $cats =  get_categories_relation_data();   ?>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet" id="bootstrap-css">

  <!-- jQuery Validation -->
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
   <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

<div class="wrap" ng-app="pform">
    <h1><?php echo ($action == 'edit' ? 'Editar Material' : 'Añadir Nuevo Material'); ?></h1>
    <form method="post"  id="product_form">
        <?php if ($action == 'edit'): ?>
            <input type="hidden" name="ID" value="<?php echo esc_html($material_edit->ID); ?>">
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                <!-- <div class="form-group">
                        <label for="sku">Cuenta contable</label>
                        <input type="text" name="sku" id="sku" value="<?php echo esc_attr($material_edit->sku); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-sku"></div>
                    </div> -->
                    <div class="form-group">
                        <label for="codigo_sap">Código SAP</label>
                        <input <?php if ($action == 'edit'){ ?> disabled <?php } ?>type="text" name="codigo_sap" id="codigo_sap" value="<?php echo esc_attr($material_edit->codigo_sap); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-sap"></div>
                    </div>
                
                    <div class="form-group">
                        <label for="cuenta">Cuenta</label>
                        <input type="text" name="cuenta" id="cuenta" value="<?php echo esc_attr($material_edit->cuenta); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-cuenta"></div>
                    </div>

                    <div class="form-group">
                        <label for="post_title">Título</label>
                        <input type="text" name="post_title" id="post_title" value="<?php echo esc_attr($material_edit->post_title); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-post_title"></div>
                    </div>
                    <div class="form-group">
                        <label for="price">Precio</label>
                        <input type="text" name="price" id="price" value="<?php 
                        
                        if(isset($material_edit->price)) {
                            echo $material_edit->price; 
                        }else{
                            echo 0;
                        }



                        ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-price"></div>
                    </div>


                    
                    <div class="form-group">
                        <label for="marca">Marca</label><br/>
                       <select name="marca[]" id="marca_sel" class="form-control w-100" multiple="multiple"> 
                      <?php
                        foreach ($marcas as $marca) {
                          
                        ?>
                            <option value="<?=$marca['ID']?>" <?php 
                            if(in_array($marca['ID'] ,explode(',',$material_edit->marca))){
                                echo " selected";
                            }

                            ?>><?=$marca['post_title']?></option>
                        
                        <?php
                         }
                        ?>
                       </select>
                       
                        <div class="error-message" id="error-marca"></div>
                    </div>

                    <?php if($action=="edit") { ?>
                        <input type="hidden" name="tipo" id="tipo_prod" value="<?=$material_edit->tipo?>" />
                    <?php } else { ?>
                        <input type="hidden" name="tipo" id="tipo_prod" value="material" />   
                    <?php } ?>
                    
                    <!-- <div class="form-group">
                        <label for="tipo">Tipo</label>

                        <select id="tipo_prod" name="tipo" class="form-control">
                            <option value="material">Material</option>
                            <option value="herraje">Herraje</option>
                        </select>
                        <div class="error-message" id="error-tipo"></div>
                    </div> -->
                   
                    <div class="form-group" id="cat_inputS" >
                        <label for="categorias">Categorías</label><br />
                        <select name="categorias[]" id="categorias" class="form-control" multiple="multiple" data-validation="required">

                        <?php foreach (explode(',',$material_edit->categorias) as $categoria){ 
                            
                         $catda = findCategorytById($categoria,$cats);       
                            
                        ?>
                    
                            <option value="<?=$catda->id?>" selected><?=$catda->nombre?></option>
                    
                        <?php } ?> 
                        
                    </select>
                        <div class="error-message" id="error-categorias"></div>
                    </div>
                    <div class="form-group" id="mat_inputS" >
                        <label for="materiales_relacionados">Materiales relacionados</label><br/>
                        <select name="materiales_relacionados[]" id="materiales_relacionados" class="form-control" multiple="multiple" data-validation="required">

                        
                        <?php foreach ($materiales_data as $material){ ?>
                       
                               <option value="<?=$material->id?>" selected><?=$material->post_title?></option>
                       
                           <?php } ?> 

                        </select>
                        <div class="error-message" id="error-materiales_relacionados"></div>
                    </div>
                    <!-- Otros campos de la primera columna -->

                    
                 
                </div>
                <div class="col-md-6">

                    <!-- imagen producto dede libreria de medios de wordpress      -->
                     <div id="dropzone" class="animated bounceIn image-upload-wrap w-100 h-10">

                         <div class="as" id="btnimage">
                            <h4>Agrega o arrastra una imagen para el material</h4>

                         </div>
                    </div>    

                    <div class="files text-center" id="files">

                        <?php if(!empty($material_edit->image_url)){ ?>    
                            <div class="file-preview text-center" data-id="0">
                           
                            <img src="<?=$material_edit->image_url ?>" alt="" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                        
                            </div>
                        <?php } ?>   


                    </div>
                     
                    

                    
                   <hr/>

                    <!-- <div class="form-group">
                        <label for="thumbnail_prod">URL de la Miniatura</label>
                        <input type="text" name="thumbnail_prod" id="thumbnail_prod" value="<?php echo esc_attr($material->thumbnail_prod); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-thumbnail_prod"></div>
                    </div>
                     -->
                    <div class="form-group">
                        <label for="post_content">Especificaciones</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="5" data-validation="required"><?php echo esc_textarea($material->post_content); ?></textarea>
                        <div class="error-message" id="error-post_content"></div>
                    </div>  
                    
                </div>
            </div> <!-- /.row -->
    
            <div class="wrppers_parents_cnt" ng-controller="materiales_categoria" id="materiales_categoria">
               
                        <h3>Materiales relacionados</h3>            
                        <hr/>             
                        <div class="row">
                            <div class="col-md-8"><h5>Material</h5></div>          
                            <div class="col-md-4 ">
                                    <h5>Cantidad por defecto</h5>
                            </div>
                                    
                        </div>
                        
                        <div class="row mb-2" ng-repeat="item in items">
                            <div class="col-md-8"><b>{{item.post_title}}</b></div>          
                            <div class="col-md-4 ">
                                    <input type="text" ng-model="item.cantidad_defecto"/>
                            </div>
                                    
                        </div>          
            </div>     
            
            <div class="wrppers_parents_cnt" ng-controller="consecutivo_marca" id="consecutivo_marca">
               
               <h3>Consecutivo por marca</h3>            
               <hr/>             
               <div class="row">
                   <div class="col-md-8"><h5>Marca</h5></div>          
                   <div class="col-md-4 ">
                           <h5>Consecutivo</h5>
                   </div>
                           
               </div>
               
               <div class="row mb-2" ng-repeat="item in items">
                   <div class="col-md-8"><b>{{item.text}}</b></div>
                   <div class="col-md-4">
                           <input type="text" ng-model="item.consecutivo"/>
                   </div>
               </div>          
   </div>     
            
                  
    
    
    
          
    
        </div> <!-- /.container-fluid -->
        
    
        <?php submit_button($action == 'edit' ? 'Actualizar Producto' : 'Añadir Producto', 'primary', 'submit_product'); ?>
    
    </form>
</div>

<style>
    .itemcls{
        border-bottom: 1px solid #CCC;
        margin-bottom: 10px;
    }
</style>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
 


<script>
                var base_url = '<?= get_site_url() ?>'
                var nonce = '<?php echo wp_create_nonce('wp_rest'); ?>'
            </script>


<script>
    jQuery(document).ready(function($) {


        $("#tipo_prod").change(function() {

            if($(this).val() == 'herraje'){
                $("#mat_inputS").show()
                $("#cat_inputS").hide()
                $("#materiales_categoria").show()
            }else{
                $("#mat_inputS").hide()
                $("#cat_inputS").show()
                $("#materiales_categoria").hide()
            }

        })




    var myDropzone = new FileDropzone({
    target: "#dropzone",
    fileHoverClass: "entered",
    clickable: true,
    multiple: true,
    forceReplace: true,
    paramName: "my-file",
    accept: "",
    onChange: function () {
      var files = this.getFiles();
      var elem = jQuery("#files");
      elem.empty();

        

      files.forEach(function (item) {
        // Crear una URL de objeto para la vista previa de la imagen
        var objectURL = URL.createObjectURL(item);
        
        elem.append(
            '<div class="file-preview text-center" data-id="' + item.id + '">' +
                '<img src="' + objectURL + '" alt="' + item.name + '" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">' +
                ' <button type="button" class="btn btn-default btn-xs" onclick="removeFile(' + item.id + ')"><i class="fa fa-trash" aria-hidden="true"></i>Eliminar</button>' +
                '</div>'
        );
      });

      console.log("files multi", files);

      jQuery("#dropzone").hide();
   
   
    },
    onEnter: function () {
      console.log("enter");
    },
    onLeave: function () {
      console.log("leave");
    },
    onHover: function () {
      console.log("hover");
    },
    onDrop: function () {
      console.log("drop");
    },
    onFolderFound: function (folders) {
      console.log(
        "" +
          folders.length +
          " folders ignored. Change noFolder option to true to accept folders."
      );
    },
    onInvalid: function (files) {
      console.log("file invalid");
      console.log(files);
    },
    beforeAdd: function (files) {
      for (var i = 0, len = files.length; i < len; i++) {
        let file = files[i];
        file.id = new Date().getTime();
        if (/fuck/.test(file.name)) {
          return false;
        }
      }
      return true;
    },
  });




  
// Función para eliminar el archivo seleccionado
function removeFile(id) {
    var files = myDropzone.getFiles();
    files = files.filter(function(file) {
        return file.id !== id;
    });

    jQuery("#dropzone").show();

    myDropzone.setFiles(files);
}





$("#product_form").submit(function (e) {
    e.preventDefault();
  })  
  
    $("#product_form").validate({
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
    rules: {
        codigo_sap: {
                required: true,
                
                <?php if ($action != 'edit'){ ?>
                
                remote: {
                    url: '<?php echo admin_url('admin-ajax.php'); ?>', // URL de AJAX desde la localización de script
                    type: "post",
                    data: {
                        action: 'validate_codigo_sap', // Acción definida en el servidor
                        codigo_sap: function() {
                            return $("#codigo_sap").val();
                        }
                    },
                    complete: function(response) {
                        console.log(response.responseJSON   ); // Verifica la respuesta en la consola
                        if(!response.responseJSON.success){
                            alert(response.responseJSON.data)
                        }
                    }
                }

                <?php } ?>
            
            },
      order:"required",
      cuenta:"required",
      post_title: "required",
      post_content: "required",
      categorias: "required",
      cnt: "required",
      price: "required",
    },
    messages: {
     
      codigo_sap:"Este código SAP es requerido o ya existe en la base de datos.",
      cuenta:"Ingrese el número de cuenta",
      order:"Se requiere un consecutivo",
      post_title: "Por favor, ingrese el nombre",
      post_content: "Por favor, ingrese la descripción",
      categorias: "Por favor, seleccione una categoría",
      cnt: "Por favor, ingrese la cantidad",
      price: "Por favor, ingrese el precio",
    },
    submitHandler: function(form) { 

        var related = "";
        var formData = new FormData();
                        
                        var scope = angular
                        .element(document.getElementById("materiales_categoria"))
                        .scope();         


                        scope.items.map((item)=> {
                    
                            formData.append('relatedcants[]','id='+item.id+',post_title='+item.post_title+',cantidad_defecto='+(item.cantidad_defecto ? item.cantidad_defecto : 1));
                    
                            });


                        var scopec = angular
                        .element(document.getElementById("consecutivo_marca"))
                        .scope();         


                        scopec.items.map((item)=> {
                    
                            formData.append('consecutivos_marca[]','id_marca='+item.id+',text='+item.text+',consecutivo='+item.consecutivo);
                    
                            });    

                        
                       

                    const files_send = myDropzone.getFiles();

                 

                    

                    for (let x = 0; x < files_send.length; x++) {
                    formData.append("files[]", files_send[x]);
                    }


                    formData.append('cuenta',jQuery("#product_form input[name='cuenta']").val());

                    //formData.append('sku',jQuery("#product_form input[name='sku']").val());
                    formData.append('codigo_sap',jQuery("#product_form input[name='codigo_sap']").val());
                    //formData.append('order',jQuery("#product_form input[name='order']").val());
                    formData.append('post_title',jQuery("#product_form #post_title").val());
                    formData.append('post_content',jQuery("#product_form textarea[name='post_content']").val());
                  //  formData.append('cnt',jQuery("#product_form input[name='cnt']").val());
                    formData.append('categorias',jQuery("#product_form #categorias").val());
                    formData.append('marca',jQuery("#product_form #marca_sel").val());
                    formData.append('price',jQuery("#product_form input[name='price']").val());
                  
//                    formData.append('observacion',jQuery("#product_form textarea[name='observacion']").val());
                    
                    
                    formData.append("tipo", jQuery("#product_form #tipo_prod").val())    



                    <?php if($action=="edit") { ?>

                        formData.append("edit", '<?=$parent_id?>');
                    <?php } ?>


                    jQuery.ajax({
                        url: base_url + "/wp-json/ordenes_cristal/v1/guardar_material",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false, // Evitar el procesamiento automático de datos
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("X-WP-Nonce", nonce);
                            //xhr.setRequestHeader( 'Content-Type', 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2) );
                        },
                        success: function (response) {
                            alert("Material guardado correctamente")
                            location.href = base_url+'/wp-admin/admin.php?page=materiales'
                        },
                        error: function (xhr, status, error) {
                            console.error("Error al subir el archivo:", error);
                            // Manejar el error si es necesario
                        },
                        });

            

        }
    
    });




    
    })    



    $('#categorias').select2({
        placeholder: 'Seleccione categorías',
        theme: "bootstrap",
        ajax: {
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // término de búsqueda
                    action: 'get_categories_relations' // acción AJAX
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                
                        return {
                            text: item.nombre,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    

    $('#marca_sel').select2({
        placeholder: 'Seleccione marcas relacionados',
        theme: "bootstrap",
    }).on('select2:selecting', function(e) {
    console.log('Selecting: ' , e.params.args.data);
            
            var scope = angular
            .element(document.getElementById("consecutivo_marca"))
            .scope();

            scope.$apply(function () {
                scope.addItem({id:e.params.args.data.id,text:e.params.args.data.text});
            });


    })


    $('#materiales_relacionados').select2({
        placeholder: 'Seleccione materiales relacionados',
        theme: "bootstrap",
        ajax: {
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // término de búsqueda
                    action: 'get_materials_relations', // acción AJAX
                    parent_id:'<?=$parent_id?>'
                };
            },
            processResults: function(data) {

                console.log("scc",data)

                return {
                    results: $.map(data, function(item) {
                
                        if(item.post_title){
                        return {
                            text: item.codigo_sap+' - '+item.post_title,
                            id: item.id
                        }
                        }
                    })
                };
            },
            cache: true
        }
    }).on('select2:selecting', function(e) {
    console.log('Selecting: ' , e.params.args.data);
    
    
    var scope = angular
      .element(document.getElementById("materiales_categoria"))
      .scope();
    // Aplica los cambios en el alcance y llama a la función addNewProduct
    console.log("ds ",scope)
    scope.$apply(function () {
      scope.addItem(e.params.args.data);
    });
    

}).on('select2:unselecting',function(e){
    console.log('UnSelecting: ' , e.params.args.data);
    var scope = angular
      .element(document.getElementById("materiales_categoria"))
      .scope();
    // Aplica los cambios en el alcance y llama a la función addNewProduct
    console.log('Alcance',scope)

    scope.$apply(function () {
      scope.removeItem(e.params.args.data.id);
    });

  })


    // app.js
const app = angular.module('pform', [])

app.controller('materiales_categoria', ['$scope', function($scope) {
    // Inicializar la lista de items
    $scope.items = <?=json_encode($materiales_data);?>

    console.log('items:', $scope.items);
    // Función para agregar un item
    $scope.addItem = function(item) {

        jQuery.ajax({
                        type: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {id:item.id,action:'get_product'},
                        
                        success: function(response) {

                            console.log("rs ",response);

                            var data_r = JSON.parse(response);

                            var newItem = {
                                id: item.id, 
                                post_title: data_r.codigo_sap+' - '+data_r.post_title,
                                cantidad_defecto : 1
                            };

                            console.log("new item",newItem);
                            $scope.items.push(newItem);
                            $scope.$apply();
                        },
                        error: function(response) {
                            
                        }
            });

    }

    
    // Función para remover un item por su ID
    $scope.removeItem = function(itemId) {
        $scope.items = $scope.items.filter(function(item) {
            return item.id !== itemId;
        });
    }

    $scope.getItems = function() {
            return $scope.items;
    }

}]);


app.controller('consecutivo_marca', ['$scope', function($scope) {

    $scope.items =  <?=json_encode($consecutivos_final);?>;

    $scope.addItem = function(item) {

        console.log("item", item)

        jQuery.ajax({
                        type: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {id_marca:item.id,action:'get_last_consecutivo'},
                        
                        success: function(response) {

                            console.log("cons ",response);
                            var newItem = {
                                id: item.id, 
                                text: item.text,
                                consecutivo : response.data.consecutivo_max ? parseInt(response.data.consecutivo_max) + 1 : 1
                            };

                            console.log("new item",newItem);
                            $scope.items.push(newItem);
                            $scope.$apply();
                        },
                        error: function(response) {
                            
                        }
            });


    }

    $scope.removeItem = function(itemId) {
        $scope.items = $scope.items.filter(function(item) {
            return item.id !== itemId;
        });
    }

    $scope.getItems = function() {
            return $scope.items;
    }


}]);






</script>
<style>

#dropzone{
    border: 1px dashed black;
    text-align: center!important;
    padding: 10px;
    border-radius: 5px;
}

.file-preview {
    display: inline-block;
    margin: 10px;
    position: relative;
    border: 1px solid #CCC;
}

.file-preview img {
    max-width: 300px;
    max-height: 300px;
}

.file-preview button {
    position: absolute;
    top: 5px;
    right: 5px;
}

.error{
    color: red;
}

</style>
