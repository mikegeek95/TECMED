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
	 require_once("../clases/class.Clientes.php");

	  $db = new MySQL();
	  $client = new Clientes();
		
	  $vent->db = $db;
	  $client->db = $db;
	  
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');
	  
	  $tipo = $_SESSION['se_sas_Tipo'];
	  
if(isset($_GET['ac']))
{
	if($_GET['ac']==1){
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}else{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	echo $msj;
}



 ?>
  



<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">FILTRAR ENTREGAS</h5>
		<!--<button type="button" onClick="aparecermodulos('catalogos/fa_paqueteria.php','main');" class="btn btn-info" style="float: right;">AGREGAR PAQUETER&Iacute;A</button>
		<div style="clear: both;"></div>-->
	</div>
  	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Estatus:</label>
						<select name="estatus" id="estatus" class="form-control">
							<option value="t">TODOS</option>
							<option value="0">PENDIENTE DE PAGO</option>
							<option value="1">PAGADOS</option>
						</select>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>TIPO DE ENTREGA:</label>
						<select name="tipo_entrega" id="tipo_entrega" class="form-control">
							<option value="t">TODOS</option>
							<option value="1">ENVIO A DIRECCI&Oacute;N</option>
							<option value="0">RECOGER EN TIENDA</option>
						</select>
					</div>
				</div>
			</div>
		</form>
  	</div>
	
	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscar_entregas('filtro');" style="margin-top: 5px;" >
	</div>
</div>


<div class="card">
	<div class="card-body">
		<div id="li_entregas" class="tab_container">
			<table  class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_entregas"> 
				<thead> 
					<tr> 
						<th align="center"># PEDIDO</th> 
						<th align="center">CLIENTE</th>
						<th align="center">T. ENTREGA</th>
						<th align="center">TOTAL</th>
						<th align="center">ACCI&Oacute;N</th>
					</tr> 
				</thead>

				<tbody> 
				</tbody> 
			</table>
		</div>
	</div>
</div>      



<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_entregas').dataTable( {	
	   "ordering": false,
	   "lengthChange": true,
	   "pageLength": 100,	
	   "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "Lo sentimos - Ningun registro encontrado",
					"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty": "desde 0 a 0 de 0 records",
					"sInfoFiltered": "(filtered desde _MAX_ total Registros)",
					"sSearch": "Buscar",
					"oPaginate": {
								 "sFirst":    "Inicio",
								 "sPrevious": "Anterior",
								 "sNext":     "Siguiente",
								 "sLast":     "&Uacute;ltimo"
								 }
					},
	   "sPaginationType": "full_numbers",
	} );
</script>