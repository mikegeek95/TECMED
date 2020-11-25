<?php

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Funciones.php");

$idmenu=$_GET['idmenumodulo'];
//creamos los objeos
$db = new MySQL();
$f=new Funciones();
$id = $_GET['id'];

try 
{  
	$sql_compras = "SELECT * FROM compras WHERE idcompras =".$id;
	$result_compras = $db->consulta($sql_compras);
	$result_compras_row = $db->fetch_assoc($result_compras);

if(!isset($_SESSION)) 
{
  session_start();
}
?>


<form id="modificar_compras" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;">ALTA DE COMPRAS</h5>

			
				<button type="button" onClick="aparecermodulos('compras/compras/vi_compras.php?idmenumodulo=<?php echo $idmenu;  ?>','main');" class="btn btn-outline-primary" style="float: right;"><i class="fas fa-undo"></i> Ver Compras</button>
				<div style="clear: both;"></div>
			</div>
			<div class="card-body">
				<div class="col-12 row">
			<div class="form-group m-t-20 col-md-3">
				<label>Fecha de Compra:</label>
				<input type="text" name="fecha_c" id="fecha_c" class="form-control" title="Fecha de Compra"  value="<?php echo $result_compras_row['fecha_compra']?>"/>
			</div>

			<div class="form-group m-t-20 col-md-3">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
				   
					 <option <?php if ($result_compras_row['estatus'] == 0){echo 'selected="selected"';} ?> value="0">Activo</option>
					 <option <?php if ($result_compras_row['estatus'] == 1){echo 'selected="selected"';} ?> value="1">Cancelado</option> 
					 <option <?php if ($result_compras_row['estatus'] == 2){echo 'selected="selected"';} ?> value="2">Comprado</option>
          	 	</select>
			</div>
					
			<div class="col-md-3">
					<label>Sucursal:</label>
				<select id="sucursal" class="form-control" name="sucursal">
					<?php
						$sql="select * from sucursales";
						$suc=$db->consulta($sql);
						$suc_row=$db->fetch_assoc($suc);
						do{
					?>
					<option value="<?php echo ($suc_row['idsucursales']);?>" <?php if ($result_compras_row['idsucursales'] == $suc_row['idsucursales']){echo 'selected="selected"';} ?>><?php echo $f->imprimir_cadena_utf8($suc_row['sucursal']);?></option>
					<?php }while($suc_row=$db->fetch_assoc($suc)); ?>
				</select>
					</div>
			
			<div class="form-group m-t-20 col-md-3">
				<label>Prioridad:</label>
				<select id="prioridad" name="prioridad" class="form-control">
           		<?php
		   			if ($resuls_usuario_row['prioridad'] == 0)
		   			{
					   $normal = 'selected="selected"';
					   $urgente = "";
					   $alta = "";
		   			}

		   			if ($result_compras_row['prioridad'] == 1)
		   			{
					   $normal = "";
					   $urgente = 'selected="selected"';
					   $alta = "";
		   			}

		   			if ($result_compras_row['prioridad'] == 2)
		   			{
					   $normal = "";
					   $urgente = "";
					   $alta = 'selected="selected"';
		   			}

           			echo $result_compras_row['prioridad']." normal = ".$normal." urgente = ".$urgente." alta = ".$alta;

		   		?>
				 	<option <?php echo $normal; ?>  value="0">Normal</option>
				 	<option <?php echo $urgente; ?> value="1">Urgente</option>
             		<option <?php echo $alta ;?> value="2">Alta</option>
           		</select>
			</div>
			</div>
			<div class="form-group m-t-20">
				<label>Descripci&oacute;n de la Compra:</label>
				<textarea name="descripcion" rows="7" id="descripcion" class="form-control" placeholder="color media etc." title="Campo Descripci&oacute;n"><?php echo $result_compras_row['descripcion']?></textarea>
			</div>

			<input type="hidden" id="id" name="id" value="<?php echo $result_compras_row['idcompras'] ?>" />
			<button type="button" onClick="var resp=MM_validateForm('fecha_c','','R'); if(resp==1){ GuardarEspecial('modificar_compras','compras/compras/md_compras.php','compras/compras/vi_compras.php?idmenumodulo=<?php echo $idmenu;?>','main');}" class="btn btn-outline-success alt_btn" style="float: right;" ><i class="far fa-save"></i> Guardar</button>
		

		</div>
	</div>
	
	
			
	
</form>

   

<script>
	jQuery('#fecha_c').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
</script>
<script type="text/javascript"	src="js/validaciones/compras.js"></script>

<?php

 }

 catch (Exception $e)

{

	echo "Error :".$e;

}



?>