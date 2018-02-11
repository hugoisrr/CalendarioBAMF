<!-- Modal quitar actividad -->
  <div class="modal fade" id="quitarActividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Quitar Actividad</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal style-form" action="" method="post">
            <div class="form-group">
                <label class="col-sm-4 col-sm-4 control-label">Lista de actividades</label>
                <div class="col-sm-6">
                    <?php
                      $result = activitiesListNOTINproyect();
                        $num_rows = mysql_num_rows($result);
                        if ($num_rows < 1) {
                          echo "<div class='alert alert-danger'><b>¡Upps!</b> No hay actividades que NO esten vinculados a un proyecto.</div> ";
                        }else {
                    ?>
                        <select class="form-control" name="activityNOproject" id="activityNOproject">
                          <option value=""></option>
                          <?php                        
                            while ($row = mysql_fetch_array($result)) {
                          ?>
                          <option value="<?=$row['idActividadProyecto']?>"><?=$row['actividadProyecto']?></option>
                          <?php
                            }
                          ?>
                        </select> 
                    <?php    
                        }
                    ?>                    
                </div>                                  
            </div> 
            <div class="form-group">
              <div class="col-sm-12">
                <div class="error alert alert-danger" id="actividadError">¡Seleccione una actividad, por favor!</div>
                <div class="alert alert-warning">¡Sólo puede eliminar elementos que no estén ligados a un proyecto!</div>
              </div>
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-danger" id="quitarA">Quitar</button>
        </div>
          </form>                                                                              
      </div>
    </div>
  </div>      
<!--Modal quitar actividad end-->