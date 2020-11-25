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
require_once("../clases/class.Ventas.php");

//Declaramos los objetos de clase
$db = new MySQL ();
$ve = new Ventas();

//Enviamos el objeto de conexión a la clase que lo requiere
$ve->db = $db;

//Recibimos parametros por metodo POST
$idnota_remision = $_POST['id'];

//Enviamos el parametro recibido a la clase sobrepedidos
$ve->id_notaremision = $idnota_remision;


try{
	
	$db->begin();
	
	//Validamos que para autorizar minimo exista un anticipo registrado
	$anticipos = $ve->obtener_img_anticipos_pedidos();
	$anticipos_num = $db->num_rows($anticipos);
	
	$depositos = $ve->obtener_depositos_pedido();
	$depositos_num = $db->num_rows($depositos);
	
	if($anticipos_num != 0){
		if($depositos_num != 0){
			$ve->autorizar_pedido();
			$db->commit();
		echo 1;
		}else{
			echo 2;
			exit();
		}
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