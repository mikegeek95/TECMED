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

try

{

	$db= new MySQL();
	$cd = new categoria_descuento();
	$md = new MovimientoBitacora();
	
	$cd->db = $db;
	$md->db = $db;

	$db->begin();

	$idcategoria_precio = $_POST['id1'];
	$idniveles = $_POST['id2'];
	
	$cd->idniveles = $idniveles;
	$cd->idcategoria_precio = $idcategoria_precio;
			
	//guardando
	$cd->eliminarCategoriaPrecioNiveles();
	$md->guardarMovimiento(utf8_decode('Catalogos'),'categoriaPrecioNiveles',utf8_decode('Elimino Categoria de precio por nivel creada con el IDCAT :'.$idcategoria_precio." Y idniveles: ".$idniveles));

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