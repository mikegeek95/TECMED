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
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Fechas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$ve = new Ventas();
$fe = new Fechas();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$ve->db = $db;


$id = $_GET['id'];


//Validamos si recibimos parametro por GET
if(isset($_GET['idnota_remision_depositos'])){
	//Si viene el id recibimos el parametro y cargamos los datos en el formulario
	$idnota_remision_depositos = $_GET['idnota_remision_depositos'];
	
	$ve->idnota_remision_depositos = $idnota_remision_depositos;
	$result_deposito = $ve->buscar_deposito();
	$result_deposito_row = $db->fetch_assoc($result_deposito);
	
	$fecha_deposito = explode(" ",$result_deposito_row['fecha_deposito']);
	$fecha = $fecha_deposito[0];
	$referencia = utf8_encode($result_deposito_row['referencia']);
	$banco = utf8_encode($result_deposito_row['banco']);
	$monto = $result_deposito_row['monto'];
	
	$horas = explode(":",$fecha_deposito[1]);
	
	$hora = $horas[0];
	$minuto = $horas[1];
	
}else{
	
	$fecha_deposito = "";
	$fecha = "";
	$referencia = "";
	$banco = "";
	$monto = "";
	
	$horas = "";
	$hora = "";
	$minuto = "";
	
	$idnota_remision_depositos = 0;
}

?>

<script type="text/javascript">
	$('#titulo-visor').html("DEPOSITOS DE PEDIDO # <?php echo $id; ?>");
</script>

<div class="row">
	<div class="col-md-12">
		<button type="button" onclick="aparecermodulos('ventas/vi_depositos_pedido.php?id=<?php echo $id; ?>','contenedor-visor-modal');" class="btn btn-info" style="float: right;">REGRESAR</button>
		<div style="clear: both;"></div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-12">
		<div class="form-group m-t-20">
			<label>FECHA DE DEPOSITO:</label>
			<div class="input-group">
				<input type="text" class="form-control" name="fecha_deposito" id="fecha_deposito" placeholder="yyyy-mm-dd" value="<?php echo $fecha; ?>">
				<div class="input-group-append">
					<span class="input-group-text"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group m-t-20">
					<label>HORA:</label>
					<select id="hora" name="hora" class="form-control">
						<?php
						for($x=0;$x<24;$x++){
							if($x<10){
								$h = "0".$x;
							}else{
								$h = $x;
							}
						?>
						<option <?php if($h == $hora){ echo "selected"; } ?> value="<?php echo $h; ?>"><?php echo $h; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group m-t-20">
					<label>MINUTOS:</label>
					<select id="minutos" name="minutos" class="form-control">
						<?php
						for($a=0;$a<60;$a++){
							if($a<10){
								$m = "0".$a;
							}else{
								$m = $a;
							}
						?>
						<option <?php if($m == $minuto){ echo "selected"; } ?> value="<?php echo $m; ?>"><?php echo $m; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="form-group m-t-20">
			<label>BANCO:</label>
			<!--<input name="banco" id="banco" title="BANCO" type="text" class="form-control" placeholder="BANCO" value="<?php echo $banco; ?>"  required>-->
			<select id="banco" name="banco" class="form-control" onChange="validar_referencia();" onBlur="validar_referencia();">
				<option <?php if($banco === 'Banamex'){ echo "selected"; } ?> value="Banamex">Banamex</option>
				<option <?php if($banco === 'HSBC'){ echo "selected"; } ?> value="HSBC">HSBC</option>
				<option <?php if($banco === 'Bancoppel'){ echo "selected"; } ?> value="Bancoppel">Bancoppel</option>
				<option <?php if($banco === 'Santander'){ echo "selected"; } ?> value="Santander">Santander</option>
				<option <?php if($banco === 'Banorte'){ echo "selected"; } ?> value="Banorte">Banorte</option>
			</select>
			
		</div>
		
		<div class="form-group m-t-20">
			<label>REFERENCIA:</label>
			<input name="referencia" id="referencia" title="REFERENCIA" type="text" onBlur="validar_referencia();" class="form-control" placeholder="REFERENCIA" value="<?php echo $referencia; ?>" required>
			<span id="mensaje-ref" style="font-size: 11px; display: none; color:#F00;"></span>
		</div>
		
		
		
		<div class="form-group m-t-20">
			<label>MONTO:</label>
			<input name="monto" id="monto" title="MONTO" type="text" class="form-control" placeholder="MONTO" value="<?php echo $monto; ?>"  required>
		</div>
		
		<div style="width: 100%;">
			<input type="hidden" id="idnota_remision" name="idnota_remision" value="<?php echo $id; ?>" />
			<input type="hidden" id="idnota_remision_depositos" name="idnota_remision_depositos" value="<?php echo $idnota_remision_depositos; ?>" />
			<button id="btn_deposito" type="button" onclick="var resp=MM_validateForm('fecha_deposito','','R','referencia','','R','banco','','R','monto','','R isNum'); if(resp==1){ guardar_deposito(); }" class="btn btn-success alt_btn btn_deposito" style="float: right;">GUARDAR</button>				
		</div>
	</div>
</div>

<script>
	jQuery('#fecha_deposito').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
</script>