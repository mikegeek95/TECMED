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
require_once("../clases/class.Caja.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.MovimientoBitacora.php");
require_once("../clases/class.phpmailer.php");
require_once("../clases/emails/class.EmailFondeo.php");
require_once("../clases/class.Ventas.php");

$db = new MySQL ();
$caja = new Caja ();
$cl = new Clientes();
$fe = new Fechas();
$md = new MovimientoBitacora();
$ventas = new Ventas();

$mailer = new PHPMailer();
$mail = new Email_Fondeo();

$mail->mailer = $mailer;


$caja->db = $db;
$cl->db = $db;

$desc_directo = $_POST['descuento_d'];
$total = $_POST['total'];
$monto_elect = $_POST['monto_elect'];
$regresar = 0;

//die($monto_elect);

$idnota_remision = $_POST['idorden'];

$porc_desc_directo = round((($desc_directo * 100) / $total),2);

$caja->idnota_remision = $idnota_remision;
$caja->desc_directo = $desc_directo;
$tipo = $_POST['tipo'];
$otrop = $_POST['otrop'];
$caja->no_seguridad = $otrop ;


//recibo mas valores

$caja->efectivo = $_POST['efectivo'];
$caja->t_tarjeta = $_POST['t_tarjeta'];
$caja->tarjeta = $_POST['tarjeta'];
$caja->ref_tarjeta = $_POST['num_tarjeta'];
$caja->ultDigit = $_POST['ultDigit'];
$caja->banco_transfer = $_POST['banco_transfer'];
$caja->transferencia = $_POST['transferencia'];
$caja->ref_transferencia = $_POST['ref_transferencia'];
$caja->no_transfer = $_POST['no_transfer'];
$caja->banco_deposito = $_POST['banco_deposito'];
$caja->deposito = $_POST['deposito'];
$caja->ref_deposito = $_POST['ref_deposito'];
$caja->no_deposito = $_POST['no_deposito'];
$caja->cheque = $_POST['cheque'];
$caja->ref_cheque = $_POST['ref_cheque'];
$caja->cambio = $_POST['cambio'];
$caja->porc_desc_directo = $porc_desc_directo;
$caja->comentario = trim(utf8_decode($_POST['comentario']));

//Obtengo de la session la sucursal a la que pertenece el usuario
$idsucursales = $_SESSION['se_sas_Sucursal'];


$caja->idsucursales = $idsucursales;

//echo "entro a g_pago caja con el tipo =".$tipo." descuento = ".$caja->desc_directo." y otrop =".$otrop;


try{
	
	$db->begin();

	$mes = $fe->mesAnho();
	$ano = $fe->anho();
	$total_vendido = 0;
	$total_devuelto = 0;
	$total_comprado = 0;

	//die($fecha_fin);
	
	$datos = $caja->obtenerDatosNotaRemision();

	$caja->idcliente = $datos['idcliente'];
	$caja->cantidad= $datos['total'];

	//Guardamos el id del cliente
	$idCliente = $datos['idcliente'];

	$sql_descripcion = "SELECT * FROM nota_descripcion WHERE idnota_remision = '$idnota_remision'";
	$result_descripcion = $db->consulta($sql_descripcion);
	$result_descripcion_row = $db->fetch_assoc($result_descripcion);

	$sql_nota = "SELECT * FROM nota_remision WHERE idnota_remision = '$idnota_remision'";
	$result_nota = $db->consulta($sql_nota);
	$result_nota_row = $db->fetch_assoc($result_nota);

	$idsucursales_nota = $result_nota_row['idsucursales'];

	$cadena = '';
	$nosepuede = 0;
	do
	{
		$idproducto = $result_descripcion_row['idproducto'];
		$idtallas = $result_descripcion_row['idtallas'];
		$cantidad = $result_descripcion_row['cantidad'];

		$sql_inv = "SELECT * FROM inventario WHERE idproducto = '$idproducto' AND idtallas = '$idtallas' AND idsucursales = '$idsucursales_nota'";
		$result_inv = $db->consulta($sql_inv);
		$result_inv_row = $db->fetch_assoc($result_inv);

		$existencia = $result_inv_row['existencia'];

		$validacion = $existencia - $cantidad;

		if($validacion >= 0)
		{}else{
			if($cadena == ''){
				$cadena = $idproducto;
			}else{
				$cadena = $cadena." <br> ".$idproducto;
			}

			$nosepuede = 1;
		}

	}while($result_descripcion_row = $db->fetch_assoc($result_descripcion));

	
	if($nosepuede == 0){

		if($tipo == 0)
		{

			if($monto_elect != 0){
				//Guardamos movimiento cliente monedero
				//$idCliente = $datos['idcliente'];
				$modalidad = 0;

				$sql = "INSERT INTO cliente_monedero (idcliente,monto,modalidad,idnota_remision) VALUES ('$idCliente','$monto_elect','$modalidad','$idnota_remision');";
				$db->consulta($sql);
				$idcliente_monedero = $db->id_ultimo();

				//Actualizams saldo en tabla de cliente
				$cl->idCliente = $idCliente;
				$result_cliente = $cl->ObtenerInformacionCliente();

				$saldo_cliente = $result_cliente['saldo_monedero'];

				$nuevo_saldo = $saldo_cliente - $monto_elect;

				$sql2 = "UPDATE clientes SET saldo_monedero = '$nuevo_saldo' WHERE idcliente = '$idCliente'";
				$db->consulta($sql2);

				//Actualizamos cliente_monedero en saldo anterior y actual
				$sql3 = "UPDATE cliente_monedero SET saldo_ant = '$saldo_cliente', saldo_act = '$nuevo_saldo' WHERE idcliente_monedero = '$idcliente_monedero'";
				$db->consulta($sql3);

			}else{
				$idcliente_monedero = 0;
			}

			$caja->monto_virtual = $monto_elect;
			$caja->idcliente_monedero = $idcliente_monedero;

			$caja->pagarEfectivo();

			$regresar = $regresar + 1;
		}//fin del else if (tipo = 5)


		/*else 
		{
			$caja->pagarTarjeta();
		}*/

		//echo "se pago en efectivo bien" ;

		$db->commit();

		$suc = $_SESSION['se_sas_Sucursal'];
		$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
		$result_imp = $db->consulta($sql_imp);
		$result_imp_row = $db->fetch_assoc($result_imp);
		$impresion = $result_imp_row['notas_print'];	

		echo $regresar."|".$impresion;
	}else{
		echo "10|".$cadena;
	}
	
}catch (Exception $e){
	$db->rollback();
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	//echo $result ;
	echo $regresar;
}



/*try{
	//Lanzadera de mails
	/*$email = $datos_cliente['email'];
	$var_enviar = "";
	if($email != ''){
		$ventas->id_notaremision = $idnota_remision;
		$datos = $ventas->verDatosReciboCaja();
		$cliente = $ventas->verClientePedido();
		
		$idsuc = $datos['idsucursales'];
		$sql_suc = "SELECT * FROM sucursales WHERE idsucursales = '$idsuc'";
		$result_suc = $db->consulta($sql_suc);
		$result_suc_row = $db->fetch_assoc($result_suc);
		$sucursal = $result_suc_row['sucursal'];
				
		$productos = $ventas->listarProdctosenPedido();
		$cantidaddeproductos = 0;

		foreach($productos as $p )
    	{
					
			$sql2 = "SELECT cp.nombre as cat FROM productos p, categoria_precio cp WHERE p.idproducto = '".$p->idproducto."' AND p.idcategoria_precio = cp.idcategoria_precio";
			$result_cat = $db->consulta($sql2);
			$result_cat_row = $db->fetch_assoc($result_cat);
			
			$cat = $result_cat_row['cat'];
			$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
			$tota_cantidad = ($p->cantidad * $p->pv) - $p->descuento;
			if($var_enviar == ''){
						$var_enviar = '<tr style=" border-bottom: 1px dotted #ccc;">
						<td align="center" style=" border-bottom: 1px dotted #ccc; ">'.$p->idproducto.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc; ">'.$cat.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;"> '.$p->nombre.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">'.$p->cantidad.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">$ '.$p->pv.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">'.$p->descuento_porc.' %</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">$ '.$p->descuento.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">$ '.number_format($tota_cantidad,2,'.',',').'</td>
						
					</tr>';
					}else{
						$var_enviar = $var_enviar.' <tr style=" border-bottom: 1px dotted #ccc;">
						<td align="center" style=" border-bottom: 1px dotted #ccc; ">'.$p->idproducto.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc; ">'.$cat.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;"> '.$p->nombre.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">'.$p->cantidad.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">$ '.$p->pv.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">'.$p->descuento_porc.' %</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">$ '.$p->descuento.'</td>
						<td align="center" style=" border-bottom: 1px dotted #ccc;">$ '.number_format($tota_cantidad,2,'.',',').'</td>
						
					</tr>';
					}
      }//Fin foreach
	  					
						
	  
	  
	 $totales = ' <tr><td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">TOTAL SIN DESCUENTO $'.number_format($cliente['total'] + $cliente['desc_producto'] + $cliente['desc_directo'],2,'.',',').'</td></tr>';
	 
	 if($cliente['desc_producto'] > 0){
						
			$totales = $totales.' <tr><td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">DESC NIVEL $'.number_format($cliente['desc_producto'],2,'.',',').'</td></tr>';		
		}
	 
	if($cliente['desc_directo'] > 0){	
		$totales = $totales.' <tr><td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">DESC DIRECTO $'.number_format($cliente['desc_directo'],2,'.',',').'</td></tr>';	
	}
		
	if($datos['monto_virtual'] > 0){	
		$totales = $totales.' <tr><td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">PAGO CON MONEDERO $'.number_format($datos['monto_virtual'],2,'.',',').'</td></tr>';	
	}																								
			
	$total = $datos['total'];
	if($datos['monto_virtual'] != 0){
		$total = $total - $datos['monto_virtual'];
	}										
				$totales = $totales.' <tr><td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">TOTAL A PAGAR $'.number_format($total,2,'.',',').'</td>
                                                    </tr>';
													
	if ($cliente['clientes'] != "")
	{
		utf8_decode($clientes = $cliente['clientes']);
	}else{
		$clientes = "PUBLICO GENERAL"; 
	}
	
	 $idniveles = $cliente['nivel'];
 
	 $sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
	 $result_nivel = $db->consulta($sql);
	 $result_nivel_row = $db->fetch_assoc($result_nivel);
	 
	 $nivel = utf8_encode($result_nivel_row['nombre']);
	 
	 //bUSCAMOS EL REGISTRO EN CLIENTE MONEDERO
	$sql_monedero = "SELECT * FROM cliente_monedero WHERE idnota_remision = '$idnota_remision'";
	$result_monedero = $db->consulta($sql_monedero);
	$result_monedero_row = $db->fetch_assoc($result_monedero);
	$result_monedero_num = $db->num_rows($result_monedero);
	
	if($result_monedero_num != 0){
		$saldos = '<tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; font-weight: bold;">MONEDERO ELECTRONICO</td></tr> <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ANTERIOR: $ '.$result_monedero_row['saldo_ant'].'</td></tr> <tr><td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 12px; ">SALDO ACTUAL: $ '.$result_monedero_row['saldo_act'].'</td></tr>';
	}else{
		$saldos ='';
	}

		$mail->saldos = $saldos;
		$mail->socio = strtoupper($clientes);
		$mail->nivel = $nivel;
		$mail->sucursal = strtoupper($sucursal);
		$mail->fecha = $fe->fechaadd_mm_YYYY_entre();
		$mail->no_venta = $idnota_remision;
		$mail->email_facturacion = $email;
		$mail->pedido = $var_enviar;
		$mail->totales = $totales;
		
		//Enviamos correo electronico
		$envio = $mail->Envio_Email_Nota();
		
		$regresar = $regresar + 2;
	}
	
	
	
}catch (Exception $e){
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $regresar;
}
*/
?>