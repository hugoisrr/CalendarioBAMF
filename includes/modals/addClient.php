<!-- Modal agregar cliente -->
  <div class="modal fade" id="agregarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Agregar cliente</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal style-form" name="nuevoCliente" action="" method="post">
            <div class="form-group">
                <label class="col-sm-4 col-sm-4 control-label">Nombre del Cliente</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="cliente" id="cliente" onkeypress="validate(event)">
                    <span class="help-block">Ej. Coca-Cola, Altex, Nestle, etc.</span>
                </div>                                  
            </div> 
            <div class="form-group">
              <div class="col-sm-12">
                <div class="error alert alert-danger" id="clienteError">¡Ingresé un cliente, por favor!</div>
                <div class="alert alert-warning" id="aparecer"><b>¡Precaución!</b> No insertar acentos o caracteres especiales. Sólo se permite: <b>-_ </b></div>
              </div>
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-primary" id="agregarC">Agregar</button>
        </div>
          </form>                                                                              
      </div>
    </div>
  </div>      
<!--Modal agregar cliente end-->