<?php

if (!isset($_SESSION)) 
{
  session_start();
}
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Gastos.php");
require_once("../../clases/class.Funciones.php");


$db = new MySQL();
$fe = new Fechas();
$ga = new Gastos();
$f= new Funciones();

$ga->db = $db;


$idmenu=$_GET['idmenumodulo'];

$sqlgastos = "SELECT * FROM gastos_categorias";
$result_gastos = $db->consulta($sqlgastos);
$result_gastos_row = $db->fetch_assoc($result_gastos);
$result_gastos_row_num = $db->num_rows($result_gastos);




//obtenemos los valores de la busqueda

if(isset($_GET['id'])){
	
	$gasto = $ga->VerGastosDatos($_GET['id']);
	
	 $titulo=$f->imprimir_cadena_utf8("MODIFICACI&Oacute;N DE GASTO POR EMPRESA");
	
$idgasto = $f->imprimir_cadena_utf8($gasto['idgastos_detalles']);
$cod_gasto = $f->imprimir_cadena_utf8($gasto['idgastos_categorias']);
$fecha_gasto = $f->imprimir_cadena_utf8($fe->fechaaYYYY_mm_dd_guion($gasto['fecha']));
$cantidad = $f->imprimir_cadena_utf8($gasto['monto']);
$descripcion = $f->imprimir_cadena_utf8($gasto['descripcion']);
$estatus = $f->imprimir_cadena_utf8($gasto['estatus']);
}
else{
	 $titulo=$f->imprimir_cadena_utf8("ALTA DE GASTO POR EMPRESA");
	$idgasto = "0";
	$cod_gasto  = "";
	$fecha_gasto  = "";
	$cantidad = "";
	$descripcion  = "";
	$estatus = "";
	
}


?>

<form id="f_gasto" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;"><?php echo ($titulo);?></h5>

				
				<button type="button" onClick="aparecermodulos('compras/gastos/vi_ingreso_gastos.php?idmenumodulo=<?php echo $idmenu;?>','main');" class="btn btn-outline-primary" style="float: right;"><i class="fas fa-undo"></i> Ver Gastos</button>
	
			
			</div>
			<div class="card-body">
			<div class="form-group m-t-20">
				<label>FECHA DE GASTO:</label>
				<input name="v_fechaingreso" type="text" id="v_fechaingreso"  class="form-control" title="Fecha del Gasto" value="<?php echo $fecha_gasto; ?>">
			</div>

			<div class="form-group m-t-20">
				<label>CONCEPTO DE GASTO:</label>
				<select class="form-control" id="v_cod_gasto" name="v_cod_gasto">
					<?php
					do{								
					?>
					<option value="<?php echo $result_gastos_row['idgastos_categorias']; ?>" <?php if($cod_gasto == $result_gastos_row['idgastos_categorias'] ){ echo 'selected="selected"'; }?> ><?php echo $result_gastos_row['descripcion']; ?></option>
					<?php
					}while($result_gastos_row = $db->fetch_assoc($result_gastos));
					?>
				</select>
			</div>
			
			<div class="form-group m-t-20">
				<label>DESCRIPCION DE GASTO:</label>
				<textarea name="v_descripcion"  rows="5" id="v_descripcion" class="form-control" title="Descripcion del Gasto" resizable="none"><?php echo $descripcion; ?></textarea>
			</div>
			
			<div class="form-group m-t-20">
				<label>Monto Gastado:</label>
				<input name="v_monto" type="text" id="v_monto" class="form-control" value="<?php echo $cantidad; ?>" size="200px"  title="Monto Gastado"  />
			</div>
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="v_estatus" name="v_estatus" class="form-control">
                    <option value="0" <?php if(0 == $estatus ){ echo 'selected="selected"'; }?> >PENDIENTE</option>
                    <option value="1" <?php if(1 == $estatus ){ echo 'selected="selected"'; }?> >PAGADO</option>
                    <option value="2" <?php if(2 == $estatus ){ echo 'selected="selected"'; }?> >CANCELADO</option>
                 </select> 
			</div>
			
		</div>

		<div class="card-footer">
			<input type="hidden" name="idgasto" id="idgasto" value="<?PHP echo $idgasto; ?>" />
			
			
			<button type="button" onClick=" GuardarEspecial('f_gasto','compras/gastos/ga_ingreso_gasto.php','compras/gastos/vi_ingreso_gastos.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" >  <i class="far fa-save"></i>  GUARDAR</button>
		</div>
	</div>
</form>

<script>
	jQuery('#v_fechaingreso').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
</script>

<script type="text/javascript"	src="js/validaciones/gastos.js"></script>