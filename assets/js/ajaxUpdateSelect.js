// función para actualizar el select del Cliente.
function updateClienteSelect() {  
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'newClient=true',
    success: function (response){
      document.getElementById("nombreCliente").innerHTML=response;      
    }
  });
}

// función para actualizar el select de cliente que NO esten ligados a u proyecto
function updateListClientsNOProject() {
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'elimClient=true',
    success: function(response){
      document.getElementById("clientNOproject").innerHTML=response;
    }
  });
}

// función para actualizar el select del Marca.
function updateMarcaSelect() {  
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'newMarca=true',
    success: function (response){
      document.getElementById("marca").innerHTML=response;      
    }
  });
}

// función para actualizar el select de marca que NO esten ligados a un proyecto
function updateListMarcaNOProject() {
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'elimMarca=true',
    success: function(response){
      document.getElementById("marcaNOproject").innerHTML=response;
    }
  });
}

// función para actualizar el select del Proyecto.
function updateProyectoSelect() {  
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'newProject=true',
    success: function (response){
      document.getElementById("proyecto").innerHTML=response;                
    }
  });
}

// función para actualizar el select de nombre proyecto que NO esten ligados a un proyecto
function updateListProjectNOProject() {
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'elimProject=true',
    success: function(response){
      document.getElementById("projectNOproject").innerHTML=response;
    }
  });
}

// función para actualizar el select de Actividad.
function updateActivitySelect() {  
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'newActivity=true',
    success: function (response){
      document.getElementById("actividad").innerHTML=response;                
    }
  });
}

// función para actualizar el select de actividad que NO esten ligados a un proyecto
function updateListActivityNOProject() {
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'elimActivity=true',
    success: function(response){
      document.getElementById("activityNOproject").innerHTML=response;
    }
  });
}

// función para actualizar el select de Actividad.
function updateCategorySelect() {  
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'newCategory=true',
    success: function (response){
      document.getElementById("tipoProyecto").innerHTML=response;                
    }
  });
}

// función para actualizar el select de categoría que NO esten ligados a un proyecto
function updateListCategoryNOProject() {
  $.ajax({
    type: 'post',
    url: 'insertBD.php',
    data: 'elimCategory=true',
    success: function(response){
      document.getElementById("categoryNOproject").innerHTML=response;
    }
  });
}