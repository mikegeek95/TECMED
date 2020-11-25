<?php

require_once ("../clases/conexcion.php");
require_once ("../clases/class.Etiquetas.php");
require_once('../clases/class.MovimientoBitacora.php');

try

{



$db = new MySQL ();
$etiquetas = new Etiquetas ();
$md = new MovimientoBitacora();



$etiquetas->db = $db ;
$md->db = $db;

$db->begin();


$etiquetas->descripcion = $_POST['descripcion'];



$etiquetas->guardarEtiqueta();

 $md->guardarMovimiento(utf8_decode('etiqueta'),'etiqueta',utf8_decode('Nueva Lista de etiqetas con el id :'.$etiquetas->idetiquetas));

$db->commit();

}//fin del try

catch (Exception $e)

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