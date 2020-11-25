<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.ShoppingCar.php");
require_once("../clases/class.Configuracion.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once('../clases/class.Fechas.php');
require_once('../clases/class.Funciones.php');
$sesion = new Sesion();


try
{
	$db = new MySQL();
	$ven = new Ventas();
	$shoping= new ShoppingCar();
	$conf = new Configuracion();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	$fe = new Fechas();
	$ven->db = $db;
	$conf->db = $db;
	$md->db = $db;
	
	$db->begin();

	//OBTENEMOS SI EN EL CARRITO EXISTEN PRODUCTOS...

	$row_carrito = $sesion->obtenerSesion('PuntaVenta');
	
	if($row_carrito != false)	

	{
	//enviamos la informacion relevante a la clase para guardarla en la base de datos.
    $row_confi = $conf->ObtenerInformacionConfiguracion();
	$t_desc = $f->guardar_cadena_utf8($row_confi['t_descuento']);	  // 0-producto  1 - por paquete 2-ambos.
	$idcliente = $f->guardar_cadena_utf8($_POST['idcliente']);
	$subtotal = $f->guardar_cadena_utf8($_POST['v_subtotal']);
	$des_producto = $f->guardar_cadena_utf8($_POST['v_desc_producto']);
	//$des_paquete = $_POST['v_desc_paquete'];
	$iva = $f->guardar_cadena_utf8($_POST['v_iva']);
	$totalpagar = $f->guardar_cadena_utf8($_POST['v_total_pagar']);
	$idsucursales = $f->guardar_cadena_utf8($_POST['sucursal']);
	$idniveles = $f->guardar_cadena_utf8($_POST['idniveles']);
	

	//OBTENEDEMOS EL TIPO DE CONFIGURACION EN EL DESCUENTO QUE CUENTA

	$ven->idcliente = $idcliente;
	$ven->tipo_descuento = $t_desc;
	
	//$ven->desc_porc = $v_porc;

	$ven->idusuarios = $sesion->obtenerSesion('se_sas_Usuario');
	
	//generamos el md5 para la seguridad de nuestro pedido
	
	$no_seguridad = md5($fe->fecha_hora_segundos().$idcliente);
	
	$ven->no_seguridad = $no_seguridad;
	$ven->subtotal = $subtotal;
	$ven->iva = $iva;
	$ven->desc_producto = $des_producto;
	//$ven->desc_paquetes = $des_paquete;
	$ven->total = $totalpagar;
	$ven->idsucursales = $idsucursales;
	$ven->idniveles = $idniveles;
	

	/*echo "Los datos que se recibieron son los siguientes: <br>ID CLIENTE : ".$ven->idcliente." TIPO DE DESCUENTO: ".$ven->tipo_descuento."<BR> ";

	echo "SUBTOTA: ".$subtotal."<br>";
	echo "DESC. PRODUCTO: ".$des_producto."<br>";
	echo "DESC. PAQUETE: ".$des_paquete."<br>";
	echo "IVA: ".$iva."<br>";
	echo "TOTAL PAGAR: ".$totalpagar."<br>";*/
	
	//costo de la nota de remision

	
	$ven->GuardarPedido();

	$md->guardarMovimiento(utf8_decode('Nota Descripcion'),'nota_descripcion',utf8_decode('Agregamos los detalles de la Nota de remsion:'.$ven->id_NuevoNotaRemision));

	//Guardamos ahora la descripcion de la nota de remision.

	$ven->GuardarDescripcionPedido();


	$result_totales = $ven->obtenerTotalesVenta();
	
	$descuento = $result_totales['descuento'];
	$total = $result_totales['total'];
	$subtotal = number_format($result_totales['total']/1.16,2,'.',',');
	$iva = number_format(($total - $subtotal),2,'.',',');
	
	$ven->desc_producto = $descuento;
	$ven->total = $total;
	$ven->subtotal = $subtotal;
	$ven->iva = $iva;
	
	
	//Actualizamos totales
	$ven->actualizarTotales();
	
	
	//TODAS LAS BITACORAS HASTA ABAJO....

	$md->guardarMovimiento(utf8_decode('Nota Descripcion'),'nota_descripcion',utf8_decode('Agregamos los detalles de la Nota de remsion:'.$ven->id_NuevoNotaRemision));

	$md->guardarMovimiento(utf8_decode('Nota Remision'),'nota_remision',utf8_decode('Agregamos una Nota de Remision:'.$ven->id_NuevoNotaRemision));

	//eliminamos la sesion del carrito
    $sesion->eliminarSesion('PuntaVenta');

	
	
	//obtenemis el perfil del usuario
	$ven->perfil = $_SESSION['se_sas_Perfil'];
	$permiso = $ven->Verpermisos();

	$db->commit();	

	echo "1|".$ven->id_NuevoNotaRemision."|".$permiso;

	}else{
           throw new Exception('No Funciona la conexcion. El Error es el siguiente: |10000');
         }

	 }catch(Exception $e) {
		  $db->rollback();	
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo "Se hizo rollback ". $db->m_error($n[0]);   }

?>