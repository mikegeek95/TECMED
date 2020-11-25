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
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.MovimientoBitacora.php");
require_once("../../clases/class.Funciones.php");


try
{
	$db= new MySQL();
	$producto = new Producto();
	$md = new MovimientoBitacora();
	$producto->db = $db;	
	$md->db = $db;
	$f = new Funciones();
	
	$db->begin();
	
		
	//enviamos datos a las variables de la tablas
	$tipo =  trim($_POST['id']);
	$producto->id_producto =  trim($_POST['idproducto']);
	$producto->cod_proveedor =  trim($_POST['cod_proveedor']);
	$producto->id_categoria = trim($_POST['idcategoria']);
	$producto->nombre = trim(utf8_decode($_POST['nombre']));
	$producto->pc = trim($_POST['p_costo']);
	$producto->pv = trim($_POST['p_venta']);
	$producto->pm = trim($_POST['p_mayoreo']);
	$producto->descuento = trim($_POST['v_descuento']);
	$producto->estatus = trim($_POST['v_estatus']);
	$producto->cantidadmin = trim($_POST['v_stock']);
	$producto->unidad = trim($_POST['v_unidad']);
	$producto->descripcion = trim(utf8_decode($_POST['descripcion']));
	$producto->idcategoria_precio = $_POST['idcategoria_precio'];
	$producto->sms = trim($_POST['sms']);
	$producto->depende = trim($_POST['depende']);
	$producto->idsobrepedido_camp = trim($_POST['idsobrepedido_camp']);
	
	//die($_POST['idproducto'].$_POST['cod_proveedor'].$_POST['idcategoria']);
	//MODIFICADO
	if($tipo==0){
		
	}
	else if ($tipo==1){
	$producto->ModificarProducto();
	$md->guardarMovimiento(utf8_decode('Productos'),'productos',utf8_decode('Modificamos el producto con el ID :'.$producto->id_producto));
	}
   $ruta="imagenes/";


	//Como no sabemos cuantos archivos van a llegar, iteramos la variable $_FILES
    

	foreach ($_FILES as $key) 
	  {
		if($key['error'] == UPLOAD_ERR_OK )
		{//Verificamos si se subio correctamente
		  $nombre = $producto->id_producto."-".$f->conver_especial($key['name']);//Obtenemos el nombre del archivo
		  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
		  $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
		  
		   //obtenemos el nombre del archivo anterior para ser eliminado si existe
		  
		  $sql = "SELECT foto FROM productos WHERE idproducto='".$producto->id_producto."'";
		  $result_borrar = $db->consulta($sql);
		  $result_borrar_row = $db->fetch_assoc($result_borrar);
		  $nombreborrar = $result_borrar_row['foto'];		  
		  
		  if($nombreborrar != "")
		  {
			  unlink($ruta.$nombreborrar); 
		  }
		  
		  
		  move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
		  //El echo es para que lo reciba jquery y lo ponga en el div "cargados"
		  
		 
		  $sql = "UPDATE productos SET foto = '$nombre' WHERE idproducto='".$producto->id_producto."'";
		   
		  $result = $db->consulta($sql);	 
		}
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
		 echo '<div class="alert_error">'. $db->m_error($n[0]).'</div>';
		 	
	$db->rollback();
}
?>