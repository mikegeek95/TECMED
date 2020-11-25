<?php

require_once("../clases/class.Sesion.php");

require_once("../clases/conexcion.php");

require_once("../clases/class.Etiquetas.php");

require_once('../clases/class.MovimientoBitacora.php');

require_once('../clases/class.ShoppingCar.php');



try

{

	$s = new Sesion();

	$db= new MySQL();

	$etiquetas = new Etiquetas ();

	$md = new MovimientoBitacora();
    $md->db = $db;

	$carrito = new ShoppingCar();

	

	 $etiquetas->db = $db;	

	

	$db->begin();

	

	//enviamos datos a las variables de la tablas	

	

	$etiquetas->idetiquetas = $_POST['id'];

	

	

	  $itemsEnCesta = $_SESSION['itemsEnCestaEtiquetas'];

      $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion

	

	if($cantidad != 0)

		{

		

		

	//guardando

		

		

//iniciamos ciclo para ver que productos tiene el carrito

	

	   



			  foreach($_SESSION['itemsEnCestaEtiquetas'] as $k => $v)

			  {  

				  	//echo $v."  " ;

					//echo "esto es k =".$k."";

					

					   //$valores = explode('|',$v); 

					 					  

					   

					   //$compras->costo = $valores[1];

					  $etiquetas->idproducto = $k;

					   

					   //$compras->estatus=0;

					   //$EyS->total_detalle = $EyS->subtotal;

					   $etiquetas->guardarEtiquetaDetalle();

					   $md->guardarMovimiento(utf8_decode('etiqueta_detalles'),'etiqueta_detalles',utf8_decode('Se guardo la lista de las etiquetas en etiqueta detalle con el id :'.$etiquetas->idetiquetas_detalle.' IDproducto: '.$k));

					   

					 

				

			  }  

			

	

	//terminamos de leer los productos del carrito

	

	

	

	       $s->eliminarSesion('itemsEnCestaCompras');

	       

		   echo '

		   

				<h4 class="alert_success" >Los productos se agregaron correctamente a su lista</h4>

		   			';

		   

		}else

		{

			

			throw new Exception('

				No Existe Ningún Producto en la lista ');

		}

	

	

	

	

	

	

	$db->commit();

	

	

	

}

catch(Exception $e)

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