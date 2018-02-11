<?php
include "core/init.php"; 

$celula = $_POST['celula'];
$status = $_POST['status'];
$costoxhora = $_POST['costxhora'];
$puesto = $_POST['puesto'];

updateUserDiseno(1,$celula,$status,$costoxhora,$puesto);
?>