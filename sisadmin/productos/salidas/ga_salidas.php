<?php

require_once("../../clases/class.Sesion.php");
require_once("../../clases/conexcion.php");
require_once("../../clases/class.EntradasySalidas.php");
require_once("../../clases/class.MovimientoBitacora.php");
require_once("../../clases/class.ShoppingCar.php");
require_once("../../clases/class.Productos.php");



try
{
	
	$s = new Sesion();
	$db= new MySQL();
	$EyS= new EntradasySalidas();
	$md = new MovimientoBitacora();
	$carrito = new ShoppingCar();
	$productos = new Producto ();
	$md->db=$db;
	$EyS->db = $db;	
	$productos->db = $db ;
	
	$db->begin();
	
 
	
	
//echo "estoy recibiendo esto = ".$_POST['id'];
	//enviamos datos a las variables de la tablas	
if ($_POST['id'] == 0)

{
	$nota = 'vacio';
	$EyS->id_nota_remision = 0;
	

}
else 
{
	
$nota = $_POST['id'];

$EyS->id_nota_remision = $nota;
}

$sucursal = $_POST['sucursal'];
$EyS->fecha_salida =  $_POST['v_f_salida'];
$EyS->tipo = $_POST['tipo'];	
$EyS->idusuario = $s->obtenerSesion('se_sas_Usuario');
//$EyS->sucursal = $s->obtenerSesion('se_sas_Sucursal');
$EyS->sucursal = $sucursal;

//die($sucursal." todo bien");


	//verificamos si tiene productos en la cesta.
	
	  $itemsEnCesta = $_SESSION['itemsEnCestaSalidas'];
      $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
	
	if($cantidad != 0)
		{
		
		
	//guardando
	
		$EyS->GuardarSalidaInventario(); 
			
		 $md->guardarMovimiento(utf8_decode('Salidas'),'Salidas',utf8_decode('Nueva Salida con el ID : '.$EyS->identrada_detalle));
	  
//iniciamos ciclo para ver que productos tiene el carrito
	
	   

			  foreach($_SESSION['itemsEnCestaSalidas'] as $k => $v)
			  {  
			  
			  
			  if ($nota == 'vacio' )
			  {
				 /* echo "nota == vacio nota = ".$nota;
				  exit ;*/
				  
					   $valores = explode('|',$k); 
					  //echo "hola foreach";
					  $EyS->cantidad = $v;
					   $EyS->talla = $valores[1];
					  $EyS->idproducto = $valores[0];
				
					   $EyS->GuardarDetalleSalidaInventario();
					  $md->guardarMovimiento(utf8_decode('salidas_detalles'),'salidas_detalles',utf8_decode('Nueva salida de producto con el IDdesalida :'.$EyS->identrada_detalle.' IDproductos: "'.$k.'"'));
					}  //fin del if ($id == "" )
					 
				else if ($vacio != 'vacio')
				{
					/*echo "nota ES DIFERENTE DE vacio nota = ".$nota;
					exit;*/
					$productos->idnota_remision = $nota ;
					$productos->id_producto = $k;
				    
					$quepaso = $productos->revisarProductoNotaR();
					//echo "ESTO ES QUE PASO = ".$quepaso;
				
					if ($quepaso == 1)
					{
						$EyS->GuardarDetalleSalidaInventario();
					  $md->guardarMovimiento(utf8_decode('salidas_detalles'),'salidas_detalles',utf8_decode('Nueva salida de producto con el IDdesalida :'.$EyS->idsalida_detalle.' IDproductos: "'.$k.'"'));
						
						
					} //fin del if ($quepaso == 1)
					
					else 
					{
						echo '<div id="no_nota" class="alert alert-danger">El siguiente producto no pertenece a la nota de remision que usted propone idproducto = : '.$k.'</div>';
						echo '<script>setTimeout(function(){
	$("#no_nota").slideUp(1000);},3000);	</script>';
						
						
					}//fin del else
						
					
					
				}	 //fin del else if ($id != "")
				
			  }  
			
	
	//terminamos de leer los productos del carrito
	
	
	
	       $s->eliminarSesion('itemsEnCestaSalidas');
	       
		   echo '<h4 class="alert alert-success" id="d_mensaje">La Salida de Producto se Agrego correctamente.</h4>';
		   echo '<script>setTimeout(function(){
	$("#d_mensaje").slideUp(1000);},6000);	</script>';
	
		}else
		{
			
			echo '<h4 class="alert alert-danger" id="d_mensaje">No hay ningun produto en la cesta.</h4>';
		   echo '<script>setTimeout(function(){
	$("#d_mensaje").slideUp(1000);},3000);	</script>';
	
	
		}
	
	
	
	
	
	
	$db->commit();
	
	
	
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