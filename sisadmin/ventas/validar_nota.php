<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");

$db = new MySQL();

$idnota_remision = $_POST['idnota_remision'];


$sql = "SELECT * FROM nota_remision WHERE estatus=1 and idnota_remision = '$idnota_remision'";

$result = $db->consulta($sql);
$result_num = $db->num_rows($result);

if($result_num == 0){
	echo 0;
}else{
	echo 1;
}