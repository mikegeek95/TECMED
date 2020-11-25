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
require_once("../../clases/class.Categoria_Descuento.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once('../../clases/class.Funciones.php');

try
{

	$db= new MySQL();
	$cd = new categoria_descuento();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	$cd->db = $db;
	$md->db = $db;

	$db->begin();
	

	//enviamos datos a las variables de la tablas

	
	$cd->nombre = $f->guardar_cadena_utf8($_POST['categoria']);
	
	$cd->estatus = $_POST['estatus'];	
	$cd->idcategoria_precio=$_POST['id'];

	if($cd->idcategoria_precio==0){
		//guardando
	$cd->guardarCategoriaPrecio();
	$md->guardarMovimiento(utf8_decode('Catalogos'),'categoriaPrecio',utf8_decode('Nueva Categoria de precio creada con el ID :'.$cd->ultimoidcategoria));

	}else{
	//MODIFICADO
	$cd->modificarCategoriaPrecio();
	$md->guardarMovimiento(utf8_decode('Categorias'),'categoriasprecio',utf8_decode('Modificamos Categorias precio con el ID :'.$cd->idcategoria_precio));
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