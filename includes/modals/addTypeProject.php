<!-- Modal agregar tipo de Proyecto -->
  <div class="modal fade" id="agregarCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Agregar categoría de proyecto</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal style-form" name="nuevoTipo" action="" method="post">
            <div class="form-group">
                <label class="col-sm-4 col-sm-4 control-label">Categoría de proyecto</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="tipo" id="tipo">                            
                </div>                                  
            </div>  
            <div class="form-group">
              <div class="col-sm-12">
                <div class="error alert alert-danger" id="tipoProyeError">¡Ingresé una categoría de Proyecto, por favor!</div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-primary" id="agregarTipo">Agregar</button>
        </div>
          </form>                                                                              
      </div>
    </div>
  </div>      
<!--Modal agregar tipo de Proyecto end--> 