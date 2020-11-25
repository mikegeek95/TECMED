<?php
   header("Content-Type: text/text; charset=ISO-8859-1");
	require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

   require_once ("../clases/conexcion.php");

   require_once ("../clases/class.Etiquetas.php");

   

   $db = new MySQL ();

   $etiquetas = new Etiquetas ();

   

   $etiquetas->db = $db ;

   

   $etiquetas->idetiquetas = $_GET['id'];

   

   $sql_etiquetas = "SELECT descripcion FROM etiquetas WHERE idetiquetas =".$etiquetas->idetiquetas;   $result_etiquetas = $db->consulta($sql_etiquetas);

  

   $result_etiquetas_row = $db->fetch_assoc($result_etiquetas);

   



   

if (!isset($_SESSION)) 

{

  session_start();

}



?>


<form id="md_etiquetas" method="post" action="">
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
				<textarea name="descripcion" rows="7" id="descripcion" class="form-control" placeholder="Etiquetas Anillos" title="Campo Descripci&oacute;n"><?php echo $result_etiquetas_row['descripcion'];?></textarea>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input type="hidden" value="<?php echo $etiquetas->idetiquetas ;?>" name="id" id="id">
			<button type="button" onClick="var resp=MM_validateForm('descripcion','','R'); if(resp==1){ GuardarEspecial('md_etiquetas','productos/md_etiquetas.php','productos/vi_etiquetas.php','main');}" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>GUARDAR</button>
	  	</div>
	</div>
</form>