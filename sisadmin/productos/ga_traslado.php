<?php
require_once("../clases/class.Sesion.php");
require_once ("../clases/conexcion.php");
require_once("../clases/class.Traspaso.php");
require_once('../clases/class.MovimientoBitacora.php');

try

{



$db = new MySQL ();
$tra = new Traspaso();
$s = new Sesion();
$md = new MovimientoBitacora();



$tra->db = $db;
$md->db = $db;

$db->begin();


$idusuarios = $s->obtenerSesion('se_sas_Usuario');
//$de = $_POST['de'];
//$para = $_POST['para'];
//$idproducto = $_POST['producto'];
//$cantidad = $_POST['cantidad'];

//$datos = $idusuarios." ".$de." ".$para." ".$idproducto." ".$cantidad;

$tra->idusuarios = $idusuarios;
//$tra->idsucursal1 = $de;
//$tra->idsucursal2 = $para;
//$tra->idproducto = $idproducto;
//$tra->cantidad = $cantidad;

$row_carrito = $s->obtenerSesion('Traspaso');

	
	if($row_carrito != false)
	{
		//die("traspaso");
		//Aqui se hará todo el proceso de traslado
		
		$contador = 1;		  
		$itemsEnCesta = $_SESSION['Traspaso'];
		$cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		$para = $_SESSION['para'];
		$de = $_SESSION['de'];
		$observaciones = utf8_decode(trim($_SESSION['observaciones']));
		 
		 
		
		
		//echo "La cantidad de productos en el array es ".$cantidad ;
					   
		if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		{
			$tra->idsucursal1 = $de;
			$tra->idsucursal2 = $para;
			$tra->observaciones = $observaciones;
		
			//Guardamos el traspaso
			$tra->guardarTraspaso();
		
		  	foreach($itemsEnCesta as $k => $v)
		   		{
				   //echo "El ID PRODUCTO ".$k;
				  
				   
				   //$this->productos->id_producto = $k;  //enviamos el valor del id producto a la clase de productos
				   //$row_productos = $this->productos->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					//echo "REGRESO EL ARREGLO DE PRODUCTOS ".$row_productos;
				   
				   	$array_k = explode('|',$k);
					$array_v = explode('|',$v);
					   
					$cantidad_produ =$array_v[0];  //obtemos la cantidad de producto en el carrito
					$idtallas = $array_k[1];
																			         					
					
					if($de != $para){
						
						//die($k." ".$cantidad_produ." ".$de." ".$para);
						
						$tra->idproducto = $array_k[0];
						$tra->cantidad = $cantidad_produ;
						$tra->idtallas = $idtallas;
	
						//Validamos que el producto ya este en inventario
						$result_inventario = $tra->yaenInventario();
						$result_inventario_num = $db->num_rows($result_inventario);
						$result_inventario_row = $db->fetch_assoc($result_inventario);
						
						//Obtenemos la existencia que tiene la sucursal que va a dar para restar
						$result_validar = $tra->validarenInventario();
						$result_validar_row = $db->fetch_assoc($result_validar);
	
						//die("todo bien ");
	
						if($result_inventario_num == 0){
							
							//Agregamos a inventario de esa sucursal
							$tra->agregarExistencia();
														
						}else{
							$existencia = $result_inventario_row['existencia'];
							
							$nva_existencia = $existencia + $cantidad_produ;
							$tra->existencia = $nva_existencia;
							
							//Hacemos el Update del inventario a esa sucursal
							$tra->actualizarExistencia();
							
						}
	
						
						$tra->guardarDetalle();
						
	
						//Restamos la existencia de la sucursal que esta dando el producto
						$exis = $result_validar_row['existencia'] - $cantidad_produ;
						$tra->existencia = $exis;
						$tra->actualizarExistenciados();						
						
						$md->guardarMovimiento(utf8_decode('traspaso'),'traspaso',utf8_decode("Nuevo Traspaso de Producto con el id :".$idproducto." de sucursal con id:".$de." a sucursal con id:".$para));

						
					}else{
						echo "No es posible traspasar un producto a la misma sucursal.";
					}		
					
             	}// fin de foreach
				   
				   
		      } 
			  //die("integrar");
			 
			  //eliminamos la sesion del carrito
    		  $s->eliminarSesion('Traspaso');
			  $s->eliminarSesion('para');
			  $s->eliminarSesion('de');
			  	
				$ultimotraspaso = $tra->idultimotraspaso;
				
			 $db->commit();
			echo "1|".$ultimotraspaso;
		
		
	}

}//fin del try

catch (Exception $e)

{

	echo '<h4 class="alert_error" id="errorcarrito">'.$e->getMessage().'</h4>';

	echo "

	

			<link type='text/css' rel='stylesheet' href='css/modal.css' />

			<script>

	        

				//$('#errorcarrito').slideUp('slow')

				$('#x').bind('click' , function ()

		{

			$('#fondo').slideUp('fast');

			$('#modal').slideUp(2000,function ()

			{

				$('#modal').html('');

			});

		});



		   </script>";	

	$db->rollback();

}

?>