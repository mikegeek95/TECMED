<?php 
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Configuracion.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once('../clases/class.Fechas.php');

$sesion = new Sesion();


try
{
	$db = new MySQL();
	$ven = new Ventas();
	$conf = new Configuracion();
	$md = new MovimientoBitacora();
	$fe = new Fechas();
	$ven->db = $db;
	$conf->db = $db;
	$md->db = $db;
	
	$db->begin();
	
	//Recibimos idcotizacion
	$idcotizacion = $_POST['id'];
	$ven->idcotizacion = $idcotizacion;
		
	//Obtenemos los datos de la tabla de cotizacion
	$result_cotizacion = $ven->verDatosReciboCotizacion();
	
	$subtotal = number_format($result_cotizacion['total']/1.16,2,'.',',');
	$idcliente = $result_cotizacion['idcliente'];
	$idniveles = $result_cotizacion['idniveles'];
	$idsucursales = $result_cotizacion['idsucursales'];
	
	
	//OBTENEDEMOS EL TIPO DE CONFIGURACION EN EL DESCUENTO QUE CUENTA
	$row_confi = $conf->ObtenerInformacionConfiguracion();
	$t_desc = $row_confi['t_descuento'];	  // 0-producto  1 - por paquete 2-ambos.
	
	//generamos el md5 para la seguridad de nuestro pedido
	$no_seguridad = md5($fe->fecha_hora_segundos().$idcliente);

	
	$ven->idcliente = $idcliente;
	$ven->idniveles = $idniveles;
	$ven->idusuarios = $sesion->obtenerSesion('se_sas_Usuario');
	$ven->no_seguridad = $no_seguridad;
	$ven->tipo_descuento = $t_desc;
	$ven->idsucursales = $idsucursales;
	
	$ven->GuardarPedido();

	//Obtenemos el listado de productos de la cotizacion
	$result_Productos = $ven->obtProductosCotizacion();
	$result_Productos_row = $db->fetch_assoc($result_Productos);
	
	
	//Guardamos ahora la descripcion de la nota de remision.
	do
	{
		$idproducto = $result_Productos_row['idproducto'];
		$cantidad = $result_Productos_row['cantidad'];
		$costo = $result_Productos_row['costo'];
		$sub = $result_Productos_row['subtotal'];
		$descuento_porc = $result_Productos_row['descuento_porc'];
		$desc = $result_Productos_row['descuento'];
		$tot = $result_Productos_row['total'];
		
		$sql = "INSERT INTO nota_descripcion (idnota_remision, idproducto, cantidad, costo, subtotal, descuento_porc, descuento, total) VALUES ('$ven->id_NuevoNotaRemision','$idproducto','$cantidad','$costo','$sub','$descuento_porc','$desc','$tot')";
				
		$db->consulta($sql);
		
	}while($result_Productos_row = $db->fetch_assoc($result_Productos));
	
	
	
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


	//Cancelamos cotizacion
	$ven->cancelarCotizacion();
	
	
	$db->commit();
	
	//obtenemis el perfil del usuario
	$ven->perfil = $_SESSION['se_sas_Perfil'];
	$permiso = $ven->Verpermisos();
	
	$suc = $_SESSION['se_sas_Sucursal'];
	$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
	$result_imp = $db->consulta($sql_imp);
	$result_imp_row = $db->fetch_assoc($result_imp);
	$impresion = $result_imp_row['notas_print'];	
		
	echo "1|".$ven->id_NuevoNotaRemision."|".$permiso."|".$impresion;

}catch(Exception $e) {
	  $db->rollback();	
	  $v = explode ('|',$e);
	  $n = explode ("'",$v[1]);
	  echo "Se hizo rollback ". $db->m_error($n[0]);   
}


?>