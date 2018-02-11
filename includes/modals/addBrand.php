<!-- Modal agregar marca -->
  <div class="modal fade" id="agregarMarca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Agregar marca</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal style-form" name="nuevaMarca" action="" method="post">
            <div class="form-group">
                <label class="col-sm-4 col-sm-4 control-label">Marca ó Departamento</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="marca" id="marca" onkeypress="validate(event)">
                    <span class="help-block">Ej. Fanta, Corporativo, Sabor-Mango, etc.</span>
                </div>                                  
            </div> 
            <div class="form-group">
              <div class="col-sm-12">
                <div class="error alert alert-danger" id="marcaError">¡Ingresé una marca, por favor!</div>
                <div class="alert alert-warning" id="aparecer"><b>¡Precaución!</b> No insertar acentos o caracteres especiales. Sólo se permite: <b>-_ </b></div>
              </div>
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-primary" id="agregarM">Agregar</button>
        </div>
          </form>                                                                    
      </div>
    </div>
  </div>      
<!--Modal agregar marca end-->