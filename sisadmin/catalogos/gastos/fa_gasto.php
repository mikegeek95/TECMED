<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Gastos.php");
require_once("../../clases/class.Funciones.php");

$db = new MySQL();
$ga = new Gastos();
$fu = new Funciones();
$ga->db = $db;

//id de gasto a modificar 
if(isset($_GET['id'])){
$ga->idgastos_categoria = $_GET['id'];
	
	$id= $_GET['id'];

$gastoscat = $ga->ObtenerInformacionGasto();
	$gasto=$db->fetch_assoc($gastoscat);
	

	$titulo=$fu->imprimir_cadena_utf8("MODIFICACIÓN DE CATEGORÍA DE GASTOS");
	$concepto=$fu->imprimir_cadena_utf8($gasto['descripcion']);
	$estatus=$fu->imprimir_cadena_utf8($gasto['estatus']);
	$tipo=$fu->imprimir_cadena_utf8($gasto['tipo']);
	$gasto=$fu->imprimir_cadena_utf8($gasto['categoria']);
	
	
	
	
	
}else{
	$titulo=$fu->imprimir_cadena_utf8("ALTA DE CATEGORÍA DE GASTOS");
	$id=0;
	$tipo="";
	$gasto="";
	$concepto="";
	$estatus="";
	
}

?>

<form id="form_cat_gastos" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; "><?php echo ($titulo);?></h5>

			<div style="">
				
				<button type="button" onClick="aparecermodulos('catalogos/gastos/vi_gastos.php?idmenumodulo=<?php echo $idmenu; ?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i> Ver Conceptos de Gastos</button>
				<div style="clear: both;"></div>
			</div>
		</div>
<div class="card-body">
			<div class="form-group m-t-20">
				<label>Tipo:</label>
				<select name="v_tipo" id="v_tipo" title="Tipo de Gasto" class="form-control">
					<option value="0" <?php if($tipo == 0){ echo 'selected';  } ?> >FIJO</option>
					<option value="1" <?php if($tipo == 1){ echo 'selected';  } ?>>&Uacute;NICO</option>
					<option value="1" <?php if($tipo == 2){ echo 'selected';  } ?>>VIATICOS</option>                                  
				</select>
			</div>

			<div class="form-group m-t-20">
				<label>Gasto:</label>
				<input name="v_gasto" id="v_gasto" title="Titulo del Gasto" type="text" class="form-control"  value="<?php echo $gasto; ?>"  >
			</div>
			
			<div class="form-group m-t-20">
				<label>Concepto del Gasto:</label>
				<input name="v_descripcion" id="v_descripcion" title="Descripcion del Gasto" type="text" class="form-control"  value="<?php echo $concepto; ?>"  >
			</div>
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select name="v_estatus" id="v_estatus" class="form-control">
				  <option value="0"  <?php if($estatus == 0){ echo 'selected'; }?> >Desactivado</option>
				  <option value="1" <?php if($estatus== 1){ echo 'selected'; }?>>Activado</option>
				</select>
			</div>
		</div>
	
	
	
		<div class="card-footer text-muted">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			
			<button type="button" onClick=" GuardarEspecial('form_cat_gastos','catalogos/gastos/ga_gasto.php','catalogos/gastos/vi_gastos.php?idmenumodulo=<?php echo ($idmenu);?>','main'); " class="btn btn-outline-success alt_btn" style="float: right;" >  <i class="far fa-save"></i>  GUARDAR</button>
		</div>
	</div>
</form>

<script type="text/javascript"	src="js/validaciones/cat_gastos.js"></script>