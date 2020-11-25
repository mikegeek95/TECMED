<?php
//*============ INICIA IMPORTACION DE CLASES A UTILIZAR ================= *//

require_once("../../clases/class.Sesion.php");
require_once("../../clases/conexcion.php");
require_once("../../clases/class.EntradasySalidas.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once('../../clases/class.ShoppingCar.php');
require_once('../../clases/class.Fechas.php');

//*============ TERMINA IMPORTACION DE CLASES A UTILIZAR =============== *//

try
{
	
	//DECLARACIÓN DE OBJETOS DE CLASE
	$s = new Sesion();
	$db= new MySQL();
	$EyS= new EntradasySalidas();
	$md = new MovimientoBitacora();
	$carrito = new ShoppingCar();
	$fec = new Fechas();
	
	//ENVIAMOS CONEXIÓN A LAS CLASES A UTILIZAR
	$md->db = $db;
	$EyS->db = $db;	
	
	
	//INICIAMOS TRANSACCIÓN
	$db->begin();

	
	$f = $_POST['v_f_ingreso'];
	$h = $fec->hh_mm_ss();
	
	//enviamos datos a las variables de la tablas	
	$EyS->idusuario = $s->obtenerSesion('se_sas_Usuario');
	$EyS->fecha_compra =  $f." ".$h;
	$EyS->tipo = $_POST['tipo_com'];
	//$EyS->idfactura = $_POST['v_no_factura'];
	//$EyS->idproveedor = $_POST['v_idproveedor'];
	//$EyS->montototal = $_POST['v_monto'];
	$EyS->id_nota_remision = $_POST['tipo_entrada_dev'];	
	$EyS->id_compra = $_POST['tipo_entrada_compra'];
	$EyS->descripcion = utf8_decode ($_POST['descripcion']);
	$EyS->sucursal = $_POST['sucursal'];

	/*echo 'id nota de remision ='.$EyS->id_nota_remision.' id compra = '.$EyS->id_compra;

	exit ;*/

	//verificamos si tiene productos en la cesta.	

  	 if(isset( $_SESSION['itemsEnCestaEntrada'])){
		  $itemsEnCesta = $_SESSION['itemsEnCestaEntrada'];
		  }
		   else{
			 $itemsEnCesta=array ();  
		   }
  	$cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion

	if(isset($itemsEnCesta) && $cantidad>0)
	{
		//guardando
		$EyS->GuardarEntradaInventario(); 	
		$md->guardarMovimiento(utf8_decode('entradas'),'entradas',utf8_decode('Nueva entrada con el ID :'.$EyS->identrada_detalle));

		//iniciamos ciclo para ver que productos tiene el carrito
		$identradas = $EyS->identrada_detalle;
		
		foreach($_SESSION['itemsEnCestaEntrada'] as $k => $v)
	  	{  		  
			$valores = explode('|',$v); 
			$array_k = explode('|',$k);		 					  
			
		   	$EyS->cantidad = $valores[0];
		   	$EyS->costo = $valores[1];
		   	$EyS->talla = $array_k[1];
		   	$EyS->idproducto = $array_k[0];
		   	$EyS->subtotal = intval($EyS->cantidad) * intval($EyS->costo);
		   	$EyS->descuento = 0;
		   	$EyS->total_detalle = $EyS->subtotal;
		   	$EyS->identrada_detalle = $identradas;

		   	$EyS->GuardarDetalleInventario();			
	   		$md->guardarMovimiento(utf8_decode('entradas_detalles'),'entradas_detalles',utf8_decode('Nueva entrada de producto con el IDdeentrada :'.$EyS->identrada_detalle.' IDproducto: '.$array_k[0]));

	  	}//terminamos de leer los productos del carrito

   		$_SESSION['itemsEnCestaEntrada']=array();   
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                       <!-- <img src="images/shoppingcart_empty.png"/><br />-->
                          La Lista de entradas esta vac&iacute;a<br />
                      </td>
                  </tr>
                  
            </table>

<script>
   		swal("Registro de Entrada Guardado", {
							      icon: "success",
							    });
</script>
<?php		
		$db->commit();
		
	}else{		
		
		?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                       <!-- <img src="images/shoppingcart_empty.png"/><br />-->
                          La Lista de entradas esta vac&iacute;a<br />
                      </td>
                  </tr>
                  
            </table>
<script>
swal("No existe ningún producto en la cesta", {
							   	icon: "error",
							    });
</script>
<?php
	}
	
}catch(Exception $e){

?>
<script>
swal("Error al Guardar", {
							   	icon: "error",
							    });
</script>
<?php

	$db->rollback();

}
?>