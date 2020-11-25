<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

require_once("../../clases/conexcion.php");

require_once("../../clases/class.Proveedores.php");

require_once("../../clases/class.MovimientoBitacora.php");
require_once("../../clases/class.Funciones.php");




try

{

	$db= new MySQL();
	$f= new Funciones();
	$proveedor = new Proveedor;

	$md = new MovimientoBitacora();

	$proveedor->db = $db;
	$md->db = $db;	

	

	$db->begin();

	

		

	//enviamos datos a las variables de la tablas	

	

	$proveedor->id_proveedores=$f->guardar_cadena_utf8($_POST['id']);

	$proveedor->nombre=$f->guardar_cadena_utf8 ($_POST['nombre']);

	$proveedor->direccion=$f->guardar_cadena_utf8($_POST['direccion']);

	$proveedor->telefono=$f->guardar_cadena_utf8($_POST['telefono']);

	$proveedor->email=$f->guardar_cadena_utf8($_POST['email']);

	$proveedor->contacto=$f->guardar_cadena_utf8 ($_POST['contacto']);
	
	$proveedor->url = $f->guardar_cadena_utf8($_POST['url']);

	

	if($proveedor->id_proveedores==0){
		//GUARDAR
		$proveedor->GuardarProveedor();
	$md->guardarMovimiento(utf8_decode('Proveedores'),'proveedores',utf8_decode('Nuevo Proveedor creado con el ID :'.$proveedor->id_proveedores));
	}	
else{
	//MODIFICADO

	$proveedor->ModificarProveedor();
	$md->guardarMovimiento(utf8_decode('Proveedores'),'proveedores',utf8_decode('Modificamos el Proveedor con el ID :'.$proveedor->id_proveedores));
}
	

	$db->commit();

	echo 1;

	

	

}

catch(Exception $e)

{

	$db->rollback();

	$v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;

}

?>