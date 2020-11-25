<?php
require_once("../clases/class.Sesion.php");
$s = new Sesion();

require_once("../clases/conexcion.php");
require_once ("../clases/class.Etiquetas.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once('../clases/class.ShoppingCar.php');


try

{
	
	$db= new MySQL();
	$etiquetas = new Etiquetas (); 
	$md = new MovimientoBitacora();

	$carrito = new ShoppingCar();
    $etiquetas->db = $db;	
	$md->db = $db;

	

	$db->begin();

	

	//enviamos datos a las variables de la tablas	

	

	 $etiquetas->idetiquetas = $_POST['id'];

	/*echo "fecha = ".$compras->fecha_compra."descripcion =".$compras->descripcion." prioridad =".$compras->prioridad ;

	exit;

	*/

	

	   $itemsEnCesta = $_SESSION['itemsEnCestaEtiquetas'];

    $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion

	

	if($cantidad != 0)

		{

		

		

	//iniciamos ciclo para ver que productos tiene el carrito

	

	   



			  foreach($_SESSION['itemsEnCestaEtiquetas'] as $k => $v)

			  {  

				  	//echo $v."  " ;

					//echo "esto es k =".$k."";

					

					    

					 	$d=explode("|",$v);

					   

					   //$compras->costo = $valores[1];

					   

					   $etiquetas->idproducto = $d[0];
				  		$etiquetas->unidad = $d[1];

					   //$compras->estatus=0;

					   //$EyS->total_detalle = $EyS->subtotal;

					  $etiquetas->guardarEtiquetaDetalle();

					  $md->guardarMovimiento(utf8_decode('etiqueta_detalles'),'etiqueta_detalles',utf8_decode('Nueva etiqueta detalle con el id :'.$etiquetas->idetiquetas.' IDproducto: '.$k));


				echo 1;

			  }  

			

	

	//terminamos de leer los productos del carrito

	

	

	

	       $s->eliminarSesion('itemsEnCestaEtiquetas');

	       

		   echo '

		   <div style=" margin-left:25%; width:800px; position:fixed; margin:auto;">

		   <div style="margin-top:-10px;" onclick="cerrarModal()"  id="x">

                	X

                </div>

		   <div  style="text-align:center; " class="alert_success">

		   

				<h4 >La lista se genero correctamente </h4>

		   			

		   

		   </div>

		   </div>

		   ';

		   

		}else

		{

			

			throw new Exception(' <div style=" padding:0px; margin-top:-20px;"  id="x">

                	<span style="margin-left:-40px;">X</span>

                </div>

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