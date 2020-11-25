<?php
// load dependencies
require '../mensajes/vendor/autoload.php';

//use Pushbots\PushbotsClient;
//use GuzzleHttp\Exception\ClientException;
//use GuzzleHttp\Exception\ServerException;
//use GuzzleHttp\Psr7;

//$client = new PushbotsClient("5cc0751e0540a307ff4a4354", "e32eacd2bd1aed40447ffd362675974a");


require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Guias_pedidos.php");
require_once("../clases/class.MensajesPush.php");
require_once("../clases/class.Fechas.php");
require_once('../clases/class.MovimientoBitacora.php');


try
{
	$db = new MySQL();
	$gu = new Guias_pedido();
	$mp = new MensajesPush();
	$fe = new Fechas();
	$md = new MovimientoBitacora();
	
	$gu->db = $db;
	$md->db = $db;
	$mp->db = $db;
	
	$db->begin();
	
	//enviamos datos a las variables de la tablas
	$idpaqueterias = $_POST['idpaqueterias'];
	$no_guia = $_POST['no_guia'];
	$fecha_envio = $_POST['fecha_envio'];
	$comentario = utf8_decode($_POST['comentario']);
	$estatus = $_POST['estatus'];
	$idguias = $_POST['idguias'];
	$idnota_remision = $_POST['idnota_remision'];
	
	$gu->idpaqueterias = $idpaqueterias;
	$gu->fecha_envio = $fecha_envio;
	$gu->comentario = $comentario;
	$gu->estatus = $estatus;
	$gu->idguias = $idguias;
	$gu->idnota_remision = $idnota_remision;
	$gu->no_guia = $no_guia;
		
	if($gu->idguias == '0'){
		$gu->guardar_guia();
		$md->guardarMovimiento(utf8_decode('guias'),'guias',utf8_decode('Nuevo guia creado con el ID :'.$gu->idguias));
		
		//VALIDACION PARA ENVIO DE PUSH
		/*$sql_val = "SELECT * FROM push_registro WHERE idusuario = '$idcliente'";
		$result_val = $db->consulta($sql_val);
		$result_val_num = $db->num_rows($result_val);
		//die('todo bienss'.strtolower($email)." - ".$t_tipo[$tipo]."- ".$mensaje_envio);*/
		
		$datos_cliente = $gu->email_cliente_nota();
		$datos_cliente_num = $db->num_rows($datos_cliente);
		$datos_cliente_row = $db->fetch_assoc($datos_cliente);
		
		$paqueteria = $gu->nombre_paqueteria();
		
		if($datos_cliente_num != 0){
			$email = strtolower($datos_cliente_row['email']);
			$para = $datos_cliente_row['nombre']." ".$datos_cliente_row['paterno']." ".$datos_cliente_row['materno'];
			
			$fecha = $fe->fecha_hora_segundos();
			$de = "ventas@calzadodayanara.com";
			$tipo = 2;
			$mensaje = utf8_decode("GUIAS- Datos de rastreo.  No. pedido #".$idnota_remision."\n\r No. Guía: ".$no_guia." Paquetería: ".$paqueteria);
			$mensaje_envio = "GUIAS- Datos de rastreo.  No. pedido #".$idnota_remision."\n\r No. Guía: ".$no_guia." Paquetería: ".$paqueteria;

			$mp->email = $email;
			$mp->fecha = $fecha;
			$mp->de = $de;
			$mp->para = $para;
			$mp->tipo = $tipo;
			$mp->mensaje = $mensaje;
			$mp->estatus = 0;

			$mp->guardar_push_mensaje();
			
			//if($result_val_num != 0){
				//$client->campaign->alias($email,$mensaje_envio);
			//}
		}
		
	}else{
		$gu->modificar_guia();
		$md->guardarMovimiento(utf8_decode('guias'),'guias',utf8_decode('Modificacion de guia creado con el ID :'.$gu->idguias));
	}	
	
	$db->commit();
	echo 1;
}
catch(Exception $e)
{
	$db->rollback();
	     $v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

		 echo $db->m_error($n[0]);	
}
?>