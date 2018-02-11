<!-- Modal agregar proyecto -->
  <div class="modal fade" id="agregarProyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Agregar proyecto</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal style-form" name="nuevoPro" action="" method="post">
            <div class="form-group">
                <label class="col-sm-4 col-sm-4 control-label">Nombre del proyecto</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="proyectoCal" id="proyectoCal" onkeypress="validate(event)">
                    <span class="help-block">Ej. Retail, Empaque, Newsletter, etc.</span>
                </div>                                  
            </div> 
            <div class="form-group">
              <div class="col-sm-12">
                <div class="error alert alert-danger" id="proyectoError">¡Ingresé un proyecto, por favor!</div>
                <div class="alert alert-warning" id="aparecer"><b>¡Precaución!</b> No insertar acentos o caracteres especiales. Sólo se permite: <b>-_ </b></div>
              </div>
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-primary" id="agregarP">Agregar</button>
        </div>
          </form>                                                                       
      </div>
    </div>
  </div>      
<!--Modal agregar proyecto end--> 