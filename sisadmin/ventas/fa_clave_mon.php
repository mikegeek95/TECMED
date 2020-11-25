<?php
 require_once("../clases/class.Sesion.php");
   $se = new Sesion();
   require_once("../clases/conexcion.php");
   require_once("../clases/class.Caja.php");
   require_once("../clases/class.Clientes.php");

//creamos nuestra sesion.

$db = new MySQL ();
$caja = new Caja ();
$cl = new Clientes();

$caja->db = $db;
$cl->db = $db;

$idorden = $_POST['idNotaremision'];  

?>

<script type="text/javascript">
	$('#v_clave').focus();
</script>

<div style="margin:auto; font-size:14px; padding:5px; color:#000;">
	<div id="mensaje" style="width:100%;"></div>
	<p>Para poder introducir todo el monedero electronico a la venta, introduzca la clave de confirmaci&oacute;n</p>
    <span style="color:#F00; margin-right: 5px;">*Introducir Clave</span>
    <input type="password" id="v_clave" name="v_clave" onkeypress="if (event.keyCode==13){validar_clave_mon();}" />
    <!--<span id="mensaje" style="color:#F00; font-size:11px;"></span>-->
    <input type="hidden" id="v_idnota" name="v_idnota" value="<?php echo $idorden; ?>" />
</div>