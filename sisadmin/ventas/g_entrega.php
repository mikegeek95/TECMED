<?php

require_once("../clases/conexcion.php");

require_once("../clases/class.Entregas.php");

require_once("../clases/class.Sesion.php");

require_once("../clases/class.ShoppingCar.php");





	 

	





$db = new MySQL ();

$entrega = new Entregas ();

$s = new Sesion ();

$carrito = new ShoppingCar ();



$entrega->db = $db; 



try

{

	$db->begin();

	$entrega->idnota_remision = $_POST['idnota_remision'];

	

	

	//guardo la entrega 

	$entrega->guardarEntrega();

	

	//obtengo el arreglo de la consulta para el foreach

	

	$productos = $entrega->verProductos();

	

	

	//obtengo el total de campos en la cesta y hago un foreach con la cesta para validar si los productos estan completos

 $cesta =	$s->obtenerSesion('itemsEnCestaEntrega');

 $cantidadCesta = count ($cesta);

$incompleto=0 ;

$exedido = 0;



//echo "este es el totalcesta= ".$totalCesta = count($cesta);



if( $cesta != false){

	//en el foreach valido los campos si estan completos o exedidos

	foreach($cesta as $c => $v)

	{

		foreach ($_SESSION['vi_productos_entrega'] as $p => $k)

		

		{

			if ($c == $p)

			{

				if ($k < $v)

				{

					$incompleto = 1 ;

				}

			}

		}

		

		/*

//		echo "este es el codigo del producto =".$c." y se esta llevando = ".$v."";

		$entrega->idproduto = $c ;

		

		

		$que = $entrega->obtenerCantidadProducto($v);

		

		//echo"hola soy que y este es mi valor = ".$que." ";

		

		if($que == 0)

		{

			$incompleto = $incompleto +1 ;

		}

		

		if ($que == 2)

		{

			$exedido = $exedido +1 ;

		}*/

		

	}

 

 //echo "total de exedido = ".$exedido." ";

 //echo "total de incompleto = ".$incompleto." ";

	$totalProductos = $entrega->totalProductos();

	//echo "esto es la cantidad cesta = ".$cantidadCesta." y esto es totalproductos = ".$totalProductos['total'];

	

	if ($incompleto == 0 && $totalProductos['total'] == $cantidadCesta  )

	{

		//echo "entro a $exedido == 0 && $incompleto == 0 ";

	//hago un foreach con larreglo de verproductos y guardo en la tabla nota_entrega_detalle

	foreach ($cesta as $c => $v )

	{

		//echo "aqui estoy guardandpo";

		$entrega->idproduto = $c ;

		$entrega->cantidad = $v ;

		

		$entrega->guardarEntregaDetalle();

		//$entrega->restarProducto();

		

		/*$md->guardarMovimiento(utf8_decode('Nota entrega detalle'),'nota_entrega_detalle',utf8_decode('Agregamos una Nota de entrega detalle:'.$entrega->idnota_entrega));*/

		

		

		

	}//fin del foreach

	//echo "salio del foreach";

	

	

		

		

		echo '<div id="succses" class="alert_success" >EN UN MOMENTO GENERAREMOS LA ORDEN DE ENTREGA  CON EL ID: '.$entrega->idnota_entrega.'</div><br>';

		echo '<script type="text/javascript">

		

				setTimeout(function(){

					$("#reporteEntrega").slideUp();

					

					  reporteEntrega(); },4000);

				

		

		</script>' ;

		$s->eliminarSesion('itemsEnCestaEntrega');

		

		$md->guardarMovimiento(utf8_decode('Nota entrega'),'nota_entrega',utf8_decode('Agregamos una Nota de entrega:'.$entrega->idnota_entrega));

		

		

	}//fin del if incompleto == 0 && exede == 0

	

	

	else 

	{

		echo '<div id="error" class="alert_error">UN PRODUCTO O MAS ESTAN INCOMPLETOS, PORFAVOR REVISE LA LISTA DE ARRIBA SI TIENE DUDA DE LA CANTIDAD DE   <br>   PRODUCTOS</div><br>';

		echo '<script type="text/javascript">

		

				setTimeout(function(){$("#error").slideUp();},4000);

		

		</script>' ;

	}

	

}//fin del if ($cesta != 0)



else 

{

	echo '<div id="error" class="alert_error">NO HAY NINGUN PRODUCTO EN LA CESTA</div><br>';

		echo '<script type="text/javascript">

		

				setTimeout(function(){$("#error").slideUp();},4000);

		

		</script>' ;

		

}

	

	 $carrito->verCarritoEntrega();

	
	$db->commit();
}//fin del try



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