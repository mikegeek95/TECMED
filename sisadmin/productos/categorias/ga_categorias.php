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
require_once("../../clases/class.MovimientoBitacora.php");
require_once("../../clases/class.Funciones.php");





try

{

	$db= new MySQL();
	$categoria = new Categoria();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	$categoria->db = $db;	
	$md->db=$db;

	$db->begin();

	

		

	//enviamos datos a las variables de la tablas	

	

	$categoria->id_categoria = $f->guardar_cadena_utf8( $_POST['id']);
	$categoria->nombre=$f->guardar_cadena_utf8(($_POST['nombre']));
	$categoria->descripcion=  $f->guardar_cadena_utf8(($_POST['descripcion']));
	$categoria->estatus =$f->guardar_cadena_utf8( $_POST['estatus']);
	$categoria->nivel =$f->guardar_cadena_utf8( $_POST['nivel']);


		
if($categoria->id_categoria==0){
	
	$categoria->GuardarCategoria();
	$md->guardarMovimiento(utf8_decode('Categorias'),'categorias',utf8_decode('Nueva Categoria con el ID :'.$categoria->id_categoria));

}else{	

	$categoria->ModificarCategoria();
	$md->guardarMovimiento(utf8_decode('Categorias'),'categorias',utf8_decode('Modificamos la Categoría con el ID :'.$categoria->id_categoria));

}

	$db->commit();

	echo 1;

	

	

}

catch(Exception $e)

{

	 $v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
		// echo '<div class="alert_error">'. $db->m_error($n[0]).'</div>';
		 	echo $e;
	$db->rollback();

}

?>