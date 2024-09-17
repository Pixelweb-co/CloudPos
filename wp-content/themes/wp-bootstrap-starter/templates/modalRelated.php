

<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" ng-controller="relatedModalCtrl">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close w-5 h-5" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		</div>
		<div class="modal-body p-0">
			
        <div class="row">

<div class="col">
  <div class="card ">
    <div class="card-header border-0">
      <h3 class="mb-0">Items relacionados. <small>Elija cuales desea agregar al pedido</small></h3>
    </div>
    <div class="table-responsive">
      <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Código sap</th>
            <th scope="col">Cuenta</th>
            
            <th scope="col">Precio</th>
            <th scope="col">Cantidad</th>
           
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="rl in relateds">
            <th scope="row">
              <div class="media align-items-center">
                <a href="#" class="avatar rounded-circle mr-3">
                <img class="rounded" ng-src="{{ rl.image_url }}" alt="Producto" width="100" height="100"/>
                </a>
                <div class="media-body">
                  <span class="mb-0 text-sm">{{rl.post_title}}</span>
                </div>
              </div>
            </th>
            <td>
            <div class="d-flex align-items-center">
                <span class="mr-2">  
                         {{rl.codigo_sap}}
                </span>
              </div>
             
            </td>
           <td> <div class="d-flex align-items-center">
                <span class="mr-2">  
                         {{rl.cuenta}}
                </span>
              </div>
            </td>
            <td>
            <div class="d-flex align-items-center">
                <span class="mr-2">  
                    {{rl.price | currency: '$'}}
                </span>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <span class="mr-2">  
                         <input type="number" class="form-control w-50" ng-model="rl.cnt" step="0.1" ng-change="roundCantidad(rl)"/>
                </span>
              </div>
            </td>
           
          </tr>
          
        </tbody>
      </table>
    </div>

  </div>
</div>
</div>

		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-outline-generic" data-dismiss="modal"  role="button">Cerrar</button>
				</div>
			
				<div class="btn-group" role="group">
					<button type="button"  class="btn btn-outline-generic" role="button" ng-click="addRelatedsCart()">Agregar al pedido</button>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>