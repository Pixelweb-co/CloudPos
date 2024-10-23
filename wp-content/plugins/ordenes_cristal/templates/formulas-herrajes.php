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
                <div class="col-md-12">
                    <?php if ($action != 'edit') { ?>
                        <div class="form-group">
                            <label for="codigo_sap">Código Sap / Nombre</label>

                            <input type="search" name="search_material" id="search_material" class="form-control w-100" data-validation="required">

                        </div>

                    <?php } ?>



                </div>


                <hr />
            </div> <!-- /.row -->


            <div class="row border p-4 m-4 rounded rsf" ng-controller="material_controller" id="material_controller" style="display: none;">

                <div class="col-md-2 p-2"><img src="{{material_select.image_url}}" style="height:80px; box-shadow: 7px 5px 5px #ccc;"></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6"><b>Codigo SAP:</b> {{material_select.codigo_sap}}</div>
                        <div class="col-md-6"><b>Material:</b> {{material_select.post_title}}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"><b>Categoria:</b></div>

                    </div>

                    <div class="row" ng-if="material_select.related.length > 0">
                        <div class="col-md-6"><b>Relacionados:</b><span ng-repeat="rl in material_select.related" class="relatedItem">{{rl.post_title}} (X{{rl.cantidad_defecto}})</span></div>

                    </div>

                </div>

            </div>



            <hr />
            <div class="wrppers_parents_cnt rsf" ng-controller="formulas_herrajes" id="formulas_herrajes" style="display: none;">

                <h3>Fórmulas relacionadas</h3>
                

                <div class="form-group">
                    <label for="marca">Marca</label>
                    <select name="marca" class="form-control w-100" ng-model="selectedBrand" ng-change="brandChanged()" ng-options="marca.value as marca.name for marca in marcas"></select>
                    <div class="error-message" id="error-marca"></div>
                </div>

                
                <hr />
                <div class="container">

                <div class="row" ng-if="window.data.length > 0">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="holgura_fija">Holgura fija</label>
                            <input type="text" class="form-control" id="holgura_fija" value="0" name="holgura_fija" ng-model="window.holguras.holgura_f">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="holgura_fija_p">Holgura %</label>
                            <input type="text" class="form-control" id="holgura_fija_p" value="0" name="holgura_fija_p" ng-model="window.holguras.holgura_p">

                        </div>

                    </div>
                </div>
    



                    <div class="row mb-1 border" ng-repeat="f in window.data">
                        <div class="col-md-3" ng-style="{'background-color': f.color}">
                            <b>{{f.title}}</b>
                        </div>
                        <div class="col-md-9">
                            <div class="row mb-1 p-1" ng-if="f.formulas.length > 0" ng-repeat="mf in f.formulas">
                                <div class="col-md-8">{{mf.title}}</div>
                                <div class="col-md-4"><input type="text" ng-model="mf.cnt" /></div>
                            </div>

                            <!-- Mundos hijos y sus fórmulas -->
                            <div ng-repeat="sm in f.submundos" ng-if="f.submundos.length > 0">
                                <div class="row mt-2 p-1" ng-style="{'background-color': sm.color}">
                                    <div class="col-md-12"><b>{{sm.title}}</b></div>
                                </div>
                                <div class="row mb-1 p-1" ng-repeat="smf in sm.formulas">
                                    <div class="col-md-8">{{smf.title}}</div>
                                    <div class="col-md-4"><input type="text" ng-model="smf.cnt" /></div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>



        </div> <!-- /.container-fluid -->
        <?php submit_button($action == 'edit' ? 'Actualizar herraje' : 'Añadir herraje', 'primary', 'submit_product'); ?>



    </form>
</div>

<style>
    .itemcls {
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

    <?php if ($action == "edit") { ?>

        var edit = '<?= $herraje->id ?>';

    <?php }else{ ?>

        var edit = '0';

    <?php } ?>    

    jQuery(document).ready(function($) {


        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('post_title'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            identify: function(obj) {
                return obj.id;
            },
            // prefetch: base_url + "/wp-json/ordenes_cristal/v1/guardar_herraje?all",
            remote: {
                url: base_url + "/wp-json/ordenes_cristal/v1/buscar_material?q=%QUERY",
                wildcard: '%QUERY'
            }
        });

        $('#search_material').typeahead(null, {
            name: 'materiales',
            display: 'post_title',
            source: bestPictures,
            templates: {
                suggestion: function(data) {
                    return '<p><img src="' + data.image_url + '" style="height:50px; box-shadow: 3px 1px 1px #ccc; margin-right:5px"/>  <strong>' + data.codigo_sap + ' - ' + data.post_title + '</strong></p>';
                }
            }
        });


        <?php

        if ($action == 'edit') {

        ?>


            var material = '<?= json_encode($herraje) ?>';

            console.log("mterial edit ", material)

            const material_decoded = JSON.parse(material);

            edit = material_decoded.id;
            jQuery(".rsf").fadeIn();

            var scope = angular
                .element(document.getElementById("material_controller"))
                .scope();
            // Aplica los cambios en el alcance y llama a la función 

            scope.$apply(function() {
                scope.material_select = material_decoded;
            });




            var scope2 = angular
                .element(document.getElementById("formulas_herrajes"))
                .scope();
            // Aplica los cambios en el alcance y llama a la función 

            scope2.$apply(function() {
                scope2.init(material_decoded);
            });

        <?php
        }

        ?>


        $('#search_material').bind('typeahead:select', function(ev, suggestion) {
            console.log('Selection2: ', suggestion);


            edit = suggestion.id;

            jQuery(".rsf").fadeIn();

            var scope = angular
                .element(document.getElementById("material_controller"))
                .scope();
            // Aplica los cambios en el alcance y llama a la función 

            scope.$apply(function() {
                scope.material_select = suggestion;
            });




            var scope2 = angular
                .element(document.getElementById("formulas_herrajes"))
                .scope();
            // Aplica los cambios en el alcance y llama a la función 

            scope2.$apply(function() {
                console.log("init ")
                scope2.init(suggestion);
            });

        });


        function encodeToUTF8JSON(obj) {
    // Función para convertir una cadena a UTF-8
    function toUTF8(str) {
        return unescape(encodeURIComponent(str));
    }

    // Recorre todas las propiedades del objeto y convierte las cadenas a UTF-8
    function recursiveUTF8Encode(item) {
        if (typeof item === 'string') {
            return toUTF8(item);
        } else if (Array.isArray(item)) {
            return item.map(recursiveUTF8Encode);
        } else if (typeof item === 'object' && item !== null) {
            let encodedObject = {};
            for (let key in item) {
                if (item.hasOwnProperty(key)) {
                    encodedObject[key] = recursiveUTF8Encode(item[key]);
                }
            }
            return encodedObject;
        }
        return item;
    }

    // Codifica el objeto en JSON después de convertirlo a UTF-8
    const utf8EncodedObject = recursiveUTF8Encode(obj);
    return JSON.stringify(utf8EncodedObject);
}


        $("#product_form").submit(function(e) {
            e.preventDefault();
        })

        $("#product_form").validate({
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            rules: {
                holgura_fija: 'required',
                holgura_fija_p: 'required'
            },
            messages: {
                holgura_fija: 'Valor requerido',
                holgura_fija_p: 'Valor requerido'
            },
            submitHandler: function(form) {

                var related = "";

                var scope = angular
                    .element(document.getElementById("formulas_herrajes"))
                    .scope();


                    console.log("mapa",scope.items);

                    
                var newItems = scope.items.map((item) => {
                  
                    console.log("item to send ", item)

                    return {
                        marca: item.marca,
                        holguras: item.holguras ? item.holguras : {}, 
                        data: {
                            items: item.data.map((item,index) =>{

                                return {
                                    ID:item.ID,
                                    submundos:item.submundos,
                                    formulas:item.formulas.map((itemf,index) =>{
                                        return {
                                            ID:itemf.ID,
                                            cnt:itemf.cnt,
                                            
                                        }

                                    })
                                }


                            }),
                        },
                       
                    }
                });


                console.log("to save ", newItems);

                if (newItems.length > 0) {

                    

                    var formData = new FormData();


                    console.log("holgura ", document.getElementById('holgura_fija').value);

                    formData.append("holgura_fija", document.getElementById('holgura_fija').value)
                    formData.append("holgura_fija_p", document.getElementById('holgura_fija_p').value)


                    formData.append("tipo", "herraje")

                    formData.append("edit", edit);

                    formData.append('form', btoa(JSON.stringify(newItems)));


                    jQuery.ajax({
                        url: base_url + "/wp-json/ordenes_cristal/v1/guardar_herraje?d=1",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false, // Evitar el procesamiento automático de datos
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader("X-WP-Nonce", nonce);
                          //  xhr.setRequestHeader( 'Content-Type', 'charset=utf-8; boundary=' + Math.random().toString().substr(2) );
                        },
                        success: function(response) {

                            alert("Herraje Guardado Correctamente!");
                            location.href = base_url + '/wp-admin/admin.php?page=herrajes'
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al subir el archivo:", error);
                            // Manejar el error si es necesario
                        },
                    });

                }else{

                    alert("Se debe ingresar cantidades almenos en una marca.");
                }

            }

        });





    })


    const app = angular.module('pform', []);


    app.controller('material_controller', function($scope, $http) {
        $scope.material_select = null;

    })

    app.controller('formulas_herrajes', function($scope, $http) {
        // Inicializar la lista de items
        $scope.items = [];
        $scope.items_b = [];
        $scope.last_brand = null;
        $scope.window = [];
        $scope.holguras = null;
        $scope.total_items = 0;
        
        
        $scope.$watch("window", function (newVal, oldVal) {
      
            console.log("mov window")


        });





        // Función para agregar un item
        $scope.addItem = function(item) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    id: item.id,
                    action: 'get_product'
                },
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

                        console.log("respuesta: ", newData)

                        if (newData.dataf.length > 0) {
                            console.log("add result: ", newData);
                            $scope.items.push({
                                marca: $scope.selectedBrand,
                                data: newData.dataf,
                                holguras: newData.holguras,
                            });
                            console.log("fórmulas marca: ", $scope.selectedBrand);

                            console.log("fórmulas:", $scope.items);

                            have_reponse = true;
                        } else {
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
            } else {

                var ndata = loaded
                console.log("esta en la lista  ", ndata);
                have_reponse = true;

            }

            console.log("wda", $scope.window.data)

            //obtener datos en widnow
            if (!$scope.window.data) {
                console.log("window vacia")
                var currentBrandItem = $scope.items.find(item => item.marca === $scope.selectedBrand);
                console.log("item marca to window ", currentBrandItem.marca)
                console.log("data to window ", currentBrandItem.data)
                $scope.$applyAsync(() => {
                    $scope.window = {
                        marca: $scope.selectedBrand,
                        data: currentBrandItem.data,
                        holguras:currentBrandItem.holguras,
                    }


                })


            } else if (have_reponse) {
                //obtengo datos window

                console.log("have response ", $scope.window.data[0].formulas)

                //   console.log("window actual " + $scope.window.marca, $scope.window.data[0].formulas[0].cnt)

                $scope.last_brand = $scope.window.marca;
                console.log("last_brand", $scope.last_brand, "selectedBrand", $scope.selectedBrand);


                //actalizo la lista de formulas con datos de window actual
                var dataFormulasnw = $scope.items.filter(item => item.marca !== $scope.window.marca);

                dataFormulasnw.push($scope.window)

                console.log("datos nuwvo", dataFormulasnw);

                $scope.items = dataFormulasnw;
                $scope.$applyAsync(() => {
                    $scope.window = $scope.items.find(item => item.marca == $scope.selectedBrand);
                })





            }



        }




        // Función llamada al cambiar la marca
        $scope.brandChanged = function() {
            console.log('Marca seleccionada:', $scope.selectedBrand);
            $scope.loadFormulas();
        };



        $scope.init = (material) => {



            // Inicializar marcas desde PHP
            $scope.marcas = [
                <?php foreach ($marcas as $marca) {

                ?> {
                        name: "<?= $marca['post_title'] ?>",
                        value: "<?= $marca['ID'] ?>"
                    },
                <?php


                } ?>
            ];

            console.log("Material init ", material);


            const marcas_material_ids = material.marca.split(',');

            console.log("Marcas: ", $scope.marcas);

            let marcas_material = [];



            marcas_material_ids.map(function(id) {
                marcas_material.push($scope.marcas.find((marca) => marca.value == id));
            })

            $scope.marcas = marcas_material;


            // Inicializar selectedBrand si marcas no está vacío
            if ($scope.marcas.length > 0) {
                $scope.selectedBrand = $scope.marcas[0].value;
                $scope.loadFormulas();
            }

        }


    });
</script>
<style>
    #dropzone {
        border: 1px dashed black;
        text-align: center !important;
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

    .error {
        color: red;
    }

    .twitter-typeahead {
        width: 100%;
    }

    .twitter-typeahead .empty-message {
        padding: 5px 10px;
        text-align: center;
    }

    .tt-menu {
        border: 1px solid #ccc;
        width: 100%;
        background-color: white;
        padding: 9px;
    }

    .tt-suggestion {
        padding: 2px;
    }

    .tt-suggestion:hover {
        background-color: blue;
        color: white;
    }

    .relatedItem {
        color: white;
        background-color: blue;
        padding: 2px 5px 2px 5px;
        margin: 2px;
        border-radius: 2px;
    }
</style>