<?php
require_once("../../clases/class.Sesion.php");
require_once("../../clases/conexcion.php");
require_once ("../../clases/class.Compras.php");
require_once ("../../clases/class.Funciones.php");
require_once("../../clases/class.MovimientoBitacora.php");
require_once("../../clases/class.ShoppingCar.php");

try
{
	$s = new Sesion();
	$db= new MySQL();
	$compras = new Compras (); 
	$md = new MovimientoBitacora();
	$carrito = new ShoppingCar();
	$f= new Funciones();
	

	$compras->db = $db;	
	$md->db = $db;
	$db->begin();

	//enviamos datos a las variables de la tablas	
	$compras->fecha_compra = $f->guardar_cadena_utf8(date("Y-M-d"));
	$compras->prioridad = $f->guardar_cadena_utf8($_POST['prioridad']);
	$compras->descripcion = $f->guardar_cadena_utf8($_POST['descripcion']);
	$compras->sucursal = $f->guardar_cadena_utf8($_POST['sucursal']);

	/*echo "fecha = ".$compras->fecha_compra."descripcion =".$compras->descripcion." prioridad =".$compras->prioridad ;

	exit;

	*/

	  $itemsEnCesta = $_SESSION['itemsEnCestaCompras'];
      $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion

		if($cantidad != 0)
		{
			//guardando
			$compras->guardarCompra();	
			$md->guardarMovimiento(utf8_decode('compras'),'compras',utf8_decode('Nueva compra con el ID :'.$compras->id_compra));


			//iniciamos ciclo para ver que productos tiene el carrito
			foreach($_SESSION['itemsEnCestaCompras'] as $k => $v)
			  {  

				  	//echo $v."  " ;
					//echo "esto es k =".$k."";
					   //$valores = explode('|',$v); 
					   $compras->cantidad = $v;
					   //$compras->costo = $valores[1];
					   $compras->id_producto = $k;
					   //$compras->estatus=0;
					   //$EyS->total_detalle = $EyS->subtotal;
					   $compras->guardaCompraDetalle();
					   $md->guardarMovimiento(utf8_decode('compras_detalles'),'compras_detalles',utf8_decode('Nueva compra de producto con el IDcompras :'.$compras->id_compra.' IDproducto: '.$k));
			  }  
	//terminamos de leer los productos del carrito
	       $s->eliminarSesion('itemsEnCestaCompras');

		   echo '

		   <div style=" margin-left:25%; width:800px; position:fixed; margin:auto;">

		   <div style="margin-top:-10px;" onclick="cerrarModal()"  id="x">

                	X

                </div>

		   <div  style="text-align:center; " class="alert_success">

		   

				<h4 >La compra de Producto se Agrego correctamente. El Id de Compra es: '.$compras->id_compra.'</h4>

		   			<center>	<a onclick="setTimeout (function (){cerrarModal()},2000)" target="_blank"" href="compras/ordenCompra.php?id='.$compras->id_compra.'">Imprimir Orden de Compra  </a></center>

		   

		   </div>

		   </div>

		   ';

		   

		}else

		{

			

			throw new Exception(' <div style=" padding:0px; margin-top:-20px;"  id="x">

                	<span style="margin-left:-40px;">X</span>

                </div>

				No Existe Ningún Producto en la Cesta ');

		}

	$db->commit();

}

catch(Exception $e){

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





