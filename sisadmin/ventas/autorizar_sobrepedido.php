<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Importamos las clases que se van a utilizar
require_once("../clases/conexcion.php");
require_once("../clases/class.Sobrepedidos.php");

//Declaramos los objetos de clase
$db = new MySQL ();
$sp = new Sobrepedidos();

//Enviamos el objeto de conexión a la clase que lo requiere
$sp->db = $db;

//Recibimos parametros por metodo POST
$idsobrepedido = $_POST['id'];

//Enviamos el parametro recibido a la clase sobrepedidos
$sp->idsobrepedido = $idsobrepedido;


try{
	
	$db->begin();
	
	//Validamos que para autorizar minimo exista un anticipo registrado
	$anticipos = $sp->obtener_img_anticipos();
	$anticipos_num = $db->num_rows($anticipos);
	
	if($anticipos_num != 0){
		$sp->autorizar_sobrepedido();
		
		$db->commit();
		echo 1;
	}else{
		echo 0;
		exit();
	}
	
	
		
}catch(Exception $e){
	
	$db->rollback();
	$v = explode ('|',$e);
	// echo $v[1];
    $n = explode ("'",$v[1]);
	$n[0];
	$result = $db->m_error($n[0]);
	echo $result;
	
}
?>