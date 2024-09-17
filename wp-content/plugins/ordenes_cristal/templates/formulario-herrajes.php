
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
    <h1><?php echo ($action == 'edit' ? 'Editar herraje' : 'Añadir Nuevo herraje'); ?></h1>
    <form method="post" id="product_form">
        <?php if ($action == 'edit'): ?>
            <input type="hidden" name="ID" value="<?php echo esc_html($herraje->ID); ?>">
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="sku">Código contable</label>
                        <input type="text" name="sku" id="sku" value="<?php echo esc_attr($herraje->sku); ?>" class="form-control" data-validation="required" value="0">
                        <div class="error-message" id="error-sku"></div>
                    </div>
                    <div class="form-group">
                        <label for="codigo_sap">Código Sap</label>
                        <input type="text" name="codigo_sap" id="codigo_sap" value="<?php echo esc_attr($herraje->codigo_sap); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-codigo_sap"></div>
                    </div>
                
                    <div class="form-group">
                        <label for="post_title">Título</label>
                        <input type="text" name="post_title" id="post_title" value="<?php echo esc_attr($herraje->post_title); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-post_title"></div>
                    </div>
                    <div class="form-group">
                        <label for="price">Precio</label>
                        <input type="text" name="price" id="price" value="<?php echo esc_attr($herraje->price); ?>" class="form-control" data-validation="required">
                        <div class="error-message" id="error-price"></div>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="marca">Marca</label>
                       <select name="marca" class="form-control w-100"> 
                      <?php
                     //   foreach ($marcas as $marca) {
                          
                        ?>
                            <option value="<?=$marca['ID']?>"><?=$marca['post_title']?></option>
                        
                        <?php
                       //  }
                        ?>
                       </select>
                       
                        <div class="error-message" id="error-marca"></div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select id="tipo_prod" name="tipo" class="form-control">
                            <option value="material">Material</option>
                            <option value="herraje">Herraje</option>
                        </select>
                        <div class="error-message" id="error-tipo"></div>
                    </div> -->
<!--                    
                    <div class="form-group" id="cat_inputS" >
                        <label for="categorias">Categorías</label><br />
                        <select name="categorias[]" id="categorias" class="form-control" multiple="multiple" data-validation="required"></select>
                        <div class="error-message" id="error-categorias"></div>
                    </div> -->
                    <input type="hidden" name="categoria" value="3"/>     
                    <input type="hidden" name="tipo" value="herraje"/>
                    <div class="form-group" id="mat_inputS" style="display: none;">
                        <label for="formulas_relacionadas">Formulas Relacionadas</label><br/>
                        <select name="formulas_relacionadas[]" id="formulas_relacionadas" class="form-control" multiple="multiple" data-validation="required"></select>
                        <div class="error-message" id="error-formulas_relacionadas"></div>
                    </div>
                    <!-- Otros campos de la primera columna -->
                 
                </div>
                <div class="col-md-6">

                    <!-- imagen herraje dede libreria de medios de wordpress      -->
                     <div id="dropzone" class="animated bounceIn image-upload-wrap w-100 h-10">

                         <div class="as" id="btnimage">
                            <h4>Agrega o arrastra una imagen para el herraje</h4>

                         </div>
                    </div>    

                    <div class="files text-center" id="files">

                <?php if(!empty($herraje->image_url)){ ?>    
                <div class="file-preview text-center" data-id="0">
                <img src="<?=$herraje->image_url ?>" alt="" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                 <button type="button" class="btn btn-default btn-xs" onclick="removeFile('0')"><i class="fa fa-trash" aria-hidden="true"></i>Eliminar</button>
                </div>
                 <?php } ?>   

                    </div>
                
                </div>
            
            <hr/>
            </div> <!-- /.row -->
    
            <div class="wrppers_parents_cnt" ng-controller="formulas_herrajes" id="formulas_herrajes">
    <h3>Fórmulas relacionadas</h3>
    <div class="form-group">
        <label for="marca">Marca</label>
        <select name="marca" class="form-control w-100" ng-model="selectedBrand" ng-change="brandChanged()" ng-options="marca.value as marca.name for marca in marcas"></select>
        <div class="error-message" id="error-marca"></div>
    </div>
    <hr/>
    <div class="container">
        <div class="row mb-1 border" ng-repeat="f in window.data">
            <div class="col-md-3" ng-style="{'background-color': f.color}">
                <b>{{f.title}}</b>
            </div>
            <div class="col-md-9">
                <div class="row mb-1 p-1" ng-repeat="mf in f.formulas">
                    <div class="col-md-8">{{mf.title}}</div>
                    <div class="col-md-4"><input type="text" ng-model="mf.cnt"/></div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
            <div class="form-group">
                        <label for="post_content">Descripcíon</label>
                        <textarea name="post_content" id="post_content" class="form-control" rows="5" data-validation="required"><?php echo esc_textarea($herraje->post_content); ?></textarea>
                        <div class="error-message" id="error-post_content"></div>
                    </div>  
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <textarea name="observacion" id="observacion" class="form-control" rows="5"><?php echo esc_textarea($herraje->observacion); ?></textarea>
                        <div class="error-message" id="error-observacion"></div>
                    </div>            
    
    
        </div> <!-- /.container-fluid -->
        <?php submit_button($action == 'edit' ? 'Actualizar herraje' : 'Añadir herraje', 'primary', 'submit_product'); ?>
    
    
    
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


var edit = 0;

<?php if($action=="edit") { ?>
                
var edit = '<?=$herraje->id?>';
<?php } ?>

jQuery(document).ready(function($) {

        


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
      sku: "required",
      codgo_sap:"required",
      post_title: "required",
      post_content: "required",
      cnt: "required",
      price: "required",
    },
    messages: {
      sku: "Por favor, ingrese el código",
      post_title: "Por favor, ingrese el nombre",
      post_content: "Por favor, ingrese la descripción",
      cnt: "Por favor, ingrese la cantidad",
      price: "Por favor, ingrese el precio",
    },
    submitHandler: function(form) { 

        var related = "";

                    if("herraje" == "herraje"){
                        
                        var scope = angular
                        .element(document.getElementById("formulas_herrajes"))
                        .scope();         

                    

                        var newItems = scope.items.map((item)=> {


                            console.log("maca item",item.marca)
                            console.log("items to send ",item.data)
                        

                            return {marca:item.marca, data:{    
                                items: item.data,
                            }}
                            });


                        console.log("to save ",newItems);
                        related = btoa(JSON.stringify(newItems));

                    }

                    const files_send = myDropzone.getFiles();
  
                    var formData = new FormData();

                    for (let x = 0; x < files_send.length; x++) {
                    formData.append("files[]", files_send[x]);
                    }


                    var formDataF = {
                        sku: jQuery("#product_form input[name='sku']").val(),
                        codigo_sap: jQuery("#product_form input[name='codigo_sap']").val(),
                        post_title: jQuery("#product_form #post_title").val(),
                        post_content: jQuery("#product_form textarea[name='post_content']").val(),
                        price:  jQuery("#product_form input[name='price']").val(),
                        observacion: jQuery("#product_form textarea[name='observacion']").val(),
                       
                        relatedformulas:related
                        };


                    formData.append("tipo", "herraje")    

                    <?php if($action=="edit") { ?>

                        formData.append("edit", '<?=$herraje->id?>');
                    <?php } ?>

                    formData.append('form',btoa(JSON.stringify(formDataF)));
                    console.log("form h ",formDataF);


                    jQuery.ajax({
                        url: base_url + "/wp-json/ordenes_cristal/v1/guardar_herraje",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false, // Evitar el procesamiento automático de datos
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("X-WP-Nonce", nonce);
                            //xhr.setRequestHeader( 'Content-Type', 'multipart/form-data; charset=utf-8; boundary=' + Math.random().toString().substr(2) );
                        },
                        success: function (response) {
                            
                            alert("Herraje Guardado");
                            location.href = base_url+'/wp-admin/admin.php?page=herrajes'
                        },
                        error: function (xhr, status, error) {
                            console.error("Error al subir el archivo:", error);
                            // Manejar el error si es necesario
                        },
                        });

            

        }
    
    });




    
    })    


angular.module('pform', [])
.controller('formulas_herrajes', function($scope, $http) {
    // Inicializar la lista de items
    $scope.items = [];
    $scope.items_b = [];
    $scope.last_brand = null;
    $scope.window = [];

    
    // Función para agregar un item
    $scope.addItem = function(item) {
        jQuery.ajax({
            type: "POST",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: { id: item.id, action: 'get_product' },
            success: function(response) {
                console.log("response", response);
                var newItem = {
                    id: item.id,
                    post_title: response.data.post_title,
                    categorias: response.data.relations_category.map((cat) => ({
                        id: cat.id,
                        nombre_padre: cat.nombre_padre,
                        nombre_hija: cat.nombre_hija,
                        cantidad_inicial: 1
                    })),
                    cnt: 0
                };
                console.log("new item", newItem);
                $scope.items.push(newItem);
                $scope.$apply();
            },
            error: function(response) {
                console.error("Error al obtener el producto:", response);
            }
        });
    };

    // Función para remover un item por su ID
    $scope.removeItem = function(itemId) {
        $scope.items = $scope.items.filter(item => item.id !== itemId);
    };


    $scope.loadFormulas = async function() {
        console.clear();
        var have_reponse = false;
        
        var loaded = $scope.items.find(item => item.marca === $scope.selectedBrand);
        if (!loaded) {
            console.log("Obteniendo fórmulas por marca...");
            try {
                let response = await $http.get(base_url + "/wp-json/ordenes_cristal/v1/get_formulas?herraje=" + edit + "&marca=" + $scope.selectedBrand);
                if (response && response) {
                    var newData = response.data;

                    console.log("respuesta: ",newData)

                  if(newData.length > 0){  
                        console.log("add result: ",newData);
                        $scope.items.push({ marca: $scope.selectedBrand, data: newData });
                        console.log("fórmulas marca: ", $scope.selectedBrand);
               
                        console.log("fórmulas:", $scope.items);
                    
                        have_reponse = true;
                    }else{
                        have_reponse = false;
                        
                        console.log("last_brand", $scope.last_brand, "selectedBrand", $scope.selectedBrand);

                        alert("Esta marca no contiene formulas relacionadas!")
                    }

                } else {
                    console.error("Error: Response data is undefined");
                }
            } catch (error) { 
                console.error("Error al obtener las fórmulas:", error);
            }
        }else{

            var ndata = loaded
            console.log("esta en la lista  ", ndata);
            have_reponse = true;

        }

        console.log("wda",$scope.window.data)

        //obtener datos en widnow
        if(!$scope.window.data){
            console.log("window vacia")
            var currentBrandItem = $scope.items.find(item => item.marca === $scope.selectedBrand);
            console.log("item marca to window ",currentBrandItem.marca)
            
            $scope.$applyAsync(()=>{
                $scope.window = {marca:$scope.selectedBrand, data:currentBrandItem.data}
            
            
            })  


        }else if(have_reponse){
            //obtengo datos window
            console.log("window actual "+$scope.window.marca,$scope.window.data[0].formulas[0].cnt)

            $scope.last_brand = $scope.window.marca;
            console.log("last_brand", $scope.last_brand, "selectedBrand", $scope.selectedBrand);


            //actalizo la lista de formulas con datos de window actual
            var dataFormulasnw = $scope.items.filter(item => item.marca !== $scope.window.marca);
            
            dataFormulasnw.push($scope.window)
            
            console.log("datos nuwvo",dataFormulasnw);
            
            $scope.items = dataFormulasnw;
            $scope.$applyAsync(()=>{
            $scope.window = $scope.items.find(item => item.marca == $scope.selectedBrand);
            }) 


            
      

        }
        
        

    }



    // Función para cargar fórmulas basado en la marca seleccionada
    $scope.loadFormulas2 = async function() {
        var loaded = $scope.items.find(item => item.marca === $scope.selectedBrand);

        if (!loaded) {
            console.log("Obteniendo fórmulas...");
            try {
                let response = await $http.get(base_url + "/wp-json/ordenes_cristal/v1/get_formulas?herraje=" + edit + "&marca=" + $scope.selectedBrand);
                if (response && response) {
                    var newData = response;
                    $scope.$applyAsync(function() {
                        $scope.items.push({ marca: $scope.selectedBrand, data: newData });
                    });
                    
                    console.log("fórmulas marca: ", $scope.selectedBrand);
                    console.log("fórmulas:", $scope.items);
                } else {
                    console.error("Error: Response data is undefined");
                }
            } catch (error) {
                console.error("Error al obtener las fórmulas:", error);
            }
        }

        console.log("last_brand", $scope.last_brand, "selectedBrand", $scope.selectedBrand);

        var ndata = $scope.items.filter(item => item.marca !== $scope.last_brand);
        if ($scope.last_brand) {
            ndata.push({ marca: $scope.last_brand, data: $scope.items_b });
        }

        console.log("ndata", ndata);

        $scope.$applyAsync(function() {
            $scope.items = ndata;
            console.log("items result", $scope.items);
            $scope.last_brand = $scope.selectedBrand;
            var currentBrandItem = $scope.items.find(item => item.marca === $scope.selectedBrand);
            $scope.items_b = currentBrandItem ? currentBrandItem.data : [];
            console.log("items_b:", $scope.items_b);
        });
    };

    // Función llamada al cambiar la marca
    $scope.brandChanged = function() {
        console.log('Marca seleccionada:', $scope.selectedBrand);
        $scope.loadFormulas();
    };


    
    // Inicializar marcas desde PHP
    $scope.marcas = [
        <?php foreach ($marcas as $marca) { ?>
            { name: "<?= $marca['post_title'] ?>", value: "<?= $marca['ID'] ?>" },
        <?php } ?>
    ];


    // Inicializar selectedBrand si marcas no está vacío
    if ($scope.marcas.length > 0) {
        $scope.selectedBrand = $scope.marcas[0].value;
        $scope.loadFormulas();
    }

});




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
