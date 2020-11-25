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
   require_once("../clases/class.ShoppingCar.php");
   require_once("../clases/class.Productos.php"); 
   require_once("../clases/class.Categoria_Descuento.php"); 
   
   try
   {
	  $db = new MySQL();
	  $shoping = new ShoppingCar();
	  $pro = new Producto();
	  $cd = new categoria_descuento();
	  
	  $pro->db = $db;
	  $cd->db = $db;
	   
	  $id = strtoupper($_POST['id']);
	  $id = trim($id);
	  $cantidad = $_POST['cantidad'];
	  $idsucursales = $_POST['sucursal'];	
	  $idCliente = $_POST['idcliente'];
	  
	  //obtenemos el valor de la categoria del producto.
	  $pro->id_producto = $id;
	  $result_producto = $pro->ObtenerDatosProducto();
	  
	 $idcategoria_precio = $result_producto['idcategoria_precio'];
	 
	 $cd->idcategoria_precio = $idcategoria_precio;
	 
	 $result_categoria = $cd->buscarCategoriaPrecio();
	 $result_categoria_row = $db->fetch_assoc($result_categoria);
	 
	 $nombre_categoria = $result_categoria_row['nombre'];
	 
	 	
	  $shoping->addCotizacion($id,$cantidad,$idsucursales,$idcategoria_precio,$nombre_categoria);
	  $shoping->verCarritoCotizacion($idCliente);
	  
  }catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo $db->m_error($n[0]);
        }


?>