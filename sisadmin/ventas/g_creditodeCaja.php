<?php

require_once("../clases/conexcion.php");

require_once("../clases/class.caja.php");



$db = new MySQL();

$caja = new Caja();



$caja->db = $db ;

try



{

	$db->begin();

$caja->idnota_remision = $_POST['id_nota_remision'];



$datos = $caja->obtenerDatosNotaRemision();



$caja->idcliente = $datos['idcliente'];

$caja->cantidad= $datos['total'];

$result = $caja->generarCreditodeCaja();





if( $result == "bb" )



{

	echo '<div id="bien" class="alert_success"> el credito se guardo correctamente</div>';

	echo '<script type="text/javascript">

				setTimeout(function(){

						$("#bien").slideUp();

					},3000);

	</script>';

}

else                            

{

	echo '<div id="error" class="alert_error">el credito no se pudo guardar porfavor intentelo mas tarde</div>';

	echo '<script type="text/javascript">

				setTimeout(function(){

						$("#error").slideUp();

					},3000);

	</script>';

}


	$db->commit();
}//fin del try

catch(Exception $e)

	    {

		  $db->rollback();

		  $v = explode ('|',$e);

		  $n = explode ("'",$v[1]);

		  echo  $db->m_error($n[0]);

	   

        }	



?>