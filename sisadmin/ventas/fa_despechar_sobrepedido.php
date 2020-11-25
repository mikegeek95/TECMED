<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Al incluir este header nos olvidamos de colocar el utf8_encode para visualizar caracteres especiales á ñ etc.
header("Content-Type: text/text; charset=ISO-8859-1");
    
//Importamos las clases que vamos a utilizar
require_once("../clases/conexcion.php");	 
require_once("../clases/class.Sobrepedidos.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Tallas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$sp = new Sobrepedidos();
$fe = new Fechas();
$ta = new Tallas();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$sp->db = $db;
$ta->db = $db;

//Recibimos parametros enviados por GET
$idsobrepedido = $_GET['id'];
?>

<script type="text/javascript">
	$('#titulo-visor').html("DESPACHAR DE SOBRE PEDIDO # <?php echo $idsobrepedido; ?>");
</script>


<div class="row el-element-overlay">
	<div class="col-md-6">
		<div class="form-group">
			<label># DE PEDIDO:</label>
			<input class="form-control" id="v_no_pedido" name="v_no_pedido" value="" title="# DE PEDIDO" />
		</div>
	</div>

	<div class="col-md-6">
		<br>
		<input type="button" value="DESPACHAR" class="btn btn-primary" onClick="var resp=MM_validateForm('v_no_pedido','','R'); if(resp==1){ despachar_sobrepedido('<?php echo $idsobrepedido; ?>');}" style="margin-top: 5px;" >
	</div>
</div>