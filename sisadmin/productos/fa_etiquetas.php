<?php

   header("Content-Type: text/text; charset=ISO-8859-1");


if (!isset($_SESSION)) 

{

  session_start();

}


?>

<form id="alta_etiquetas" method="post" action="">
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">ALTA DE ETIQUETAS</h5>
			<button type="button" onClick="aparecermodulos('productos/vi_etiquetas.php','main');" class="btn btn-info" style="float: right;">VER ETIQUETAS</button>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">DATOS GENERALES</h5>
		</div>
		
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>Descripci&oacute;n de la Etiqueta:</label>
				<textarea name="descripcion" rows="7" id="descripcion" class="form-control" placeholder="Etiquetas Anillos" title="Campo Descripci&oacute;n"></textarea>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<button type="button" onClick="var resp=MM_validateForm('descripcion','','R'); if(resp==1){ GuardarEspecial('alta_etiquetas','productos/ga_etiquetas.php','productos/vi_etiquetas.php','main');}" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>GUARDAR</button>
	  	</div>
	</div>
</form>