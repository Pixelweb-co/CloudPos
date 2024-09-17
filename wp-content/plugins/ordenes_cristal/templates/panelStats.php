            <div id="statsPanel" class="statsPanel">
            
            <ul class="list-group mt-3 list-stats">
                <li class="list-group-item" ng-repeat="st in stats">
                    <span class="text-item-title-cat"> <b>{{st.title}}:</b> {{st.total_cat  | currency: '$'}}</span>
                    <div class="chart1">
                    <div class="progress">
                      <div class="progress-bar bg-stats-vi" role="progressbar" ng-style="{'width': st.porcentaje_utilizado + '%'}" ng-aria-valuenow="{'width': st.porcentaje_utilizado + '%'}" aria-valuemin="0" aria-valuemax="100"><span>{{st.metro_cuadrado_total_categoria  | currency: '$'}}</span></div>
                      <div class="progress-bar " ng-class="{'progress-bar bg-stats-da': st.overvalue, 'bg-stats-do': !st.overvalue}" role="progressbar" ng-style="{'width': st.porcentaje_restante + '%'}" ng-aria-valuenow="{'width': st.porcentaje_restante + '%'}" aria-valuemin="0" aria-valuemax="100"><span>{{st.valor_restante  | currency: '$'}}</span></div>
                    </div>
                    </div>
                    <div class="price2 text-item-general" style="float: right;">{{st.valor_ideal  | currency: '$'}}</div>
                </li>

            </ul>
            <div style="margin-left:44%"><div class="cart-loader"></div></div>

            </div>
        
