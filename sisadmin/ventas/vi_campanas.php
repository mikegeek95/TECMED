<?php
require_once("../clases/class.Sesion.php");

$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


header("Content-Type: text/text; charset=ISO-8859-1");
    
	 require_once("../clases/conexcion.php");	 
     require_once("../clases/class.Ventas.php");
	 require_once("../clases/class.Clientes.php");

	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
		
	  $vent->db = $db;
	  $client->db = $db;
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');
	  
	  $tipo = $_SESSION['se_sas_Tipo'];
	  
if(isset($_GET['ac']))
	{
		if($_GET['ac']==1)
		{
			$msj='<div id="mens" class="alert alert-success" role="alert">'.$_GET['msj'].'</div>';
		}
		else
		{
			$msj='<div id="mens" class="alert alert-danger" role="alert">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
		}

		echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';

		echo $msj;
	}



 ?>
  


<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">FILTRAR CAMPA&Ntilde;AS</h5>
		<button type="button" onClick="aparecermodulos('ventas/fa_campanas.php','main');" class="btn btn-info" style="float: right;">AGREGAR CAMPA&Ntilde;A</button>
		<div style="clear: both;"></div>
	</div>

	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Nombre:</label>
						<input class="form-control" type="text" id="v_nombre" name="v_nombre" >
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Fecha Inicio:</label>
						<input class="form-control" type="text" id="v_f_inicio" name="v_f_inicio" >
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Fecha Fin:</label>
						<input class="form-control" type="text" id="v_f_fin" name="v_f_fin">
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscarCampana('filtro');" style="margin-top: 5px;" >
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div id="li_campanas" class="tab_container">
			<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
				<thead> 
					<tr> 
						<th align="center">NOMBRE</th> 
						<th align="cealign=">F. INICIO</th>
						<th align="center">F. FIN</th>
						<th align="center">ACCI&Oacute;N</th>
					</tr> 
				</thead>

				<tbody> 
					<tr>
						<td align="center" colspan="4">Lo sentimos - Ningun registro encontrado</td>
					</tr>
				</tbody> 
			</table>
		</div>
	</div>
</div>      


<script>

 jQuery('#v_f_inicio').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayHighlight: true,
		orientation: "bottom"
	});

 jQuery('#v_f_fin').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayHighlight: true,
		orientation: "bottom"
	});
</script>