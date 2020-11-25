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
require_once("../../clases/class.Categorias.php");
require_once("../../clases/class.Fechas.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Funciones.php");

try
{
	$db = new MySQL();
	$gu = new Categoria();
	$fe = new Fechas();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	$gu->db = $db;
	$md->db = $db;
	
	
	$db->begin();
	
	//enviamos datos a las variables de la tablas
	
	$nombre = $f->guardar_cadena_utf8($_POST['nombre']);
	$comentario = $f->guardar_cadena_utf8($_POST['comentario']);
	$estatus = $f->guardar_cadena_utf8($_POST['estatus']);
	$subcat = $f->guardar_cadena_utf8($_POST['subcategoria']);
	$categoria = $f->guardar_cadena_utf8($_POST['categoria']);
	


	
	$gu->nombre = $nombre;
	$gu->comentario = $comentario;
	$gu->estatus = $estatus;
	$gu->subcat = $subcat;
	$gu->categoria = $categoria;
		
	if($gu->subcat == 0){
		$gu->GuardarSubCategoria();
		$md->guardarMovimiento($f->guardar_cadena_utf8('subcategoria'),'subcategoria',$f->guardar_cadena_utf8('NuevA subcategoria creado con el ID :'.$gu->subcat));
		}else{
		$gu->ModificarSubCategoria();
		$md->guardarMovimiento($f->guardar_cadena_utf8('subcategoria'),'subcategoria',$f->guardar_cadena_utf8('Modificacion de subcategoria creado con el ID :'.$gu->subcat));
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

		 echo $db->m_error($n[0]);	
}
?>