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
   require_once("../../clases/class.Tallas.php");
require_once("../../clases/class.Funciones.php");
   
   $db = new MySQL();
   $ta = new Tallas();
   $f = new Funciones();

   $ta->db = $db; 

	if(isset($_GET['idtallas'])){
		$idtallas = $_GET['idtallas'];
		
		$ta->idtallas = $idtallas;
		
		$result_tallas = $ta->buscarTalla();
		$result_tallas_row = $db->fetch_assoc($result_tallas);
		$titulo=$f->imprimir_cadena_utf8("MODIFICACIÓN DE PRESENTACIÓN");
		$id=$f->imprimir_cadena_utf8($result_tallas_row['idtallas']);
		$estatus=$f->imprimir_cadena_utf8($result_tallas_row['estatus']);
		$descripcion=$f->imprimir_cadena_utf8($result_tallas_row['descripcion'] );
		$unidad=$f->imprimir_cadena_utf8($result_tallas_row['unidad']);
		$valor=$f->imprimir_cadena_utf8($result_tallas_row['valor']);
		
	}else{
		
		$titulo=$f->imprimir_cadena_utf8("ALTA DE PRESENTACIÓN");
		$id=0;
		$estatus="";
		$descripcion="";
		$unidad="";
		$valor="";
	}

?>


<form id="form_presentacion" method="post" action="">
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; "><?php echo ($titulo);?></h5>
			
			
			<button type="button" onClick="aparecermodulos('productos/presentacion/vi_presentacion.php?idmenumodulo=<?php echo $idmenu; ?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i>  VER PRESENTACIONES</button>
			
			<div style="clear: both;"></div>
		</div>


		
		<div class="card-body">
			<div class="form-group m-t-20">
						<label>Unidad:</label>
						<select id="v_unidad" name="v_unidad" class="form-control">
							<option value="PZ" <?php if($unidad == "PZ"){ echo "selected"; } ?> >PZ</option>
							<option value="TALLA" <?php if($unidad == "TALLA"){ echo "selected"; } ?> >TALLA</option>
							<option value="LT" <?php if($unidad == "LT"){ echo "selected"; } ?>>LT</option>
							<option value="ML" <?php if($unidad == "ML"){ echo "selected"; } ?>>ML</option>
							<option value="KG" <?php if($unidad == "KG"){ echo "selected"; } ?>>KG</option>
							<option value="MG" <?php if($unidad == "MG"){ echo "selected"; } ?>>MG</option>
						</select>
					</div>
			<div class="form-group m-t-20">
				<label>Valor:</label>
				<input type="text" name="talla" id="talla" class="form-control" value="<?php echo $valor; ?>" title="Campo valor" onkeypress="bloquearMas(event.keyCode);"  />
			</div>

			<div class="form-group m-t-20">
				<label>Descripci&oacute;n:</label>
				<textarea name="descripcion" rows="7" id="descripcion" class="form-control"  title="Campo Descripci&oacute;n"><?php echo $descripcion; ?></textarea>
			</div>
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control" title="Estatus">
					<option <?php if($estatus == 0){ echo "selected"; } ?> value="0">DESACTIVADO</option>
					<option <?php if($estatus == 1){ echo "selected"; } ?> value="1">ACTIVADO</option>
				</select>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
			<button type="button" onClick="var resp=MM_validateForm('nombre','','R'); if(resp==1){ GuardarEspecial('form_presentacion','productos/presentacion/ga_presentacion.php','productos/presentacion/vi_presentacion.php?idmenumodulo=<?php echo $idmenu; ?>','main');}" class="btn btn-outline-success alt_btn" style="float: right;" >  <i class="far fa-save"></i>  GUARDAR</button>
	  	</div>
	</div>
</form>

<script type="text/javascript"	src="js/validaciones/presentacion.js"></script>