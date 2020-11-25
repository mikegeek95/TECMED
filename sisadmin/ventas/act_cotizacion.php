<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.ShoppingCar.php");
require_once("../clases/class.Configuracion.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once('../clases/class.Fechas.php');

$sesion = new Sesion();


try
{
	$db = new MySQL();
	$ven = new Ventas();
	$shoping= new ShoppingCar();
	$conf = new Configuracion();
	$md = new MovimientoBitacora();
	$fe = new Fechas();
	$ven->db = $db;
	$conf->db = $db;
	$md->db = $db;
	
	$db->begin();

	//OBTENEMOS SI EN EL CARRITO EXISTEN PRODUCTOS...

	$row_carrito = $sesion->obtenerSesion('Cotizacion');
	
	if($row_carrito != false)	

	{
	//enviamos la informacion relevante a la clase para guardarla en la base de datos.
    $row_confi = $conf->ObtenerInformacionConfiguracion();
	$t_desc = $row_confi['t_descuento'];	  // 0-producto  1 - por paquete 2-ambos.
	$idcliente = $_POST['idcliente'];
	$subtotal = $_POST['v_subtotal'];
	$des_producto = $_POST['v_desc_producto'];
	//$des_paquete = $_POST['v_desc_paquete'];
	$iva = $_POST['v_iva'];
	$totalpagar = $_POST['v_total_pagar'];
	$idsucursales = $_POST['sucursal'];
	$idniveles = $_POST['idniveles'];
	$abono = $_POST['abono'];
	$f_fin = $_POST['f_fin'];
	$idCotizacion = $_POST['id'];
		
	//die($des_producto.' desc');
	
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
	$ven->f_fin = $f_fin;
	$ven->abono = $abono;
	$ven->idcotizacion = $idCotizacion;

	
	$ven->actualizarCotizacion();
	
	
	//Borramos los productos anteriores
	$ven->borrarProductosCotizacion();

	//Guardamos ahora la descripcion de la nota de remision.
	$ven->GuardarDescripcionCotizacion(); 

	//TODAS LAS BITACORAS HASTA ABAJO....

	$md->guardarMovimiento(utf8_decode('Detalle Cotizacion'),'detalle_cotizacion',utf8_decode('Agregamos los detalles de la cotizacion no.:'.$ven->idcotizacion));

	$md->guardarMovimiento(utf8_decode('Cotizacion'),'cotizacion',utf8_decode('Agregamos una cotizacion:'.$ven->idcotizacion));

	//eliminamos la sesion del carrito
    $sesion->eliminarSesion('Cotizacion');

	
	
	//obtenemis el perfil del usuario
	$ven->perfil = $_SESSION['se_sas_Perfil'];
	$permiso = $ven->Verpermisos();

	$db->commit();	

	echo "1|".$ven->idcotizacion."|".$permiso;

	}else{
           throw new Exception('No Funciona la conexcion. El Error es el siguiente: |10000');
         }

	 }catch(Exception $e) {
		  $db->rollback();	
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo "Se hizo rollback ". $db->m_error($n[0]);   }

?>