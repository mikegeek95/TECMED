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
require_once("../clases/class.Ventas.php");


try
{
	$db = new MySQL();
	$ven = new Ventas();
	
	$ven->db = $db;	
	
	//enviamos datos a las variables de la tablas
	$referencia = utf8_decode($_POST['referencia']);
	$banco = utf8_decode($_POST['banco']);
	
	$ven->referencia = $referencia;
	$ven->banco = $banco;
	
	$validar = $ven->validar_referencia();
	$validar_num = $db->num_rows($validar);
	$validar_row = $db->fetch_assoc($validar);
	
	
	if($validar_num == 0){
		echo '1';
		exit();
	}else{
		echo '0|'.$validar_row['idnota_remision'];
		exit();
	}
	
	
}
catch(Exception $e)
{
	$db->rollback();
	     $v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

		 echo $db->m_error($n[0]);	
}
?>