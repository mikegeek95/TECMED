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
	  
	  
	  
	  //obtenemos todos los clientes.
	  
	  $row_clientes = $client->ObtenerInformacionClientesResult();
	  $row_result_clientes = $db->fetch_assoc($row_clientes);
	  $row_num_clientes = $db->num_rows($row_clientes);
	  
	  
	  
	  
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

 <script>
	 
	  jQuery('#inicio').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
	 
	 jQuery('#f_fin').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
 
		var oTable = $('#d_modulos').dataTable( {		
					
					  "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "Nada Encontrado - Disculpa",
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
					   "sScrollX": "100%",
		               "sScrollXInner": "100%",
		               "bScrollCollapse": true
					  
					  
						
				} );
	 
  </script>
 
<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">DEVOLUCIONES</h5>
		<button type="button" onClick="aparecermodulos('ventas/fa_devolucion.php','main');" class="btn btn-info" style="float: right;">AGREGAR DEVOLUCI&Oacute;N</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>No. Devoluci&oacute;n:</label>
							<input class="form-control" type="text" id="v_iddevolucion" name="v_iddevolucion" >
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>No. de Orden:</label>
							<input class="form-control" type="text" id="v_idorden" name="v_idorden" >
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Fecha Inicio:</label>
							<input class="form-control" type="text" id="inicio" name="inicio" >
						</div>
					</div>
				
					<div class="col-md-3">
						<div class="form-group">
							<label>Fecha Fin:</label>
							<input class="form-control" type="text" id="f_fin" name="f_fin">
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Nombre:</label>
							<div class="input-group">
								<input type="text" name="n_cliente" id="n_cliente" title="Campo Cliente" class="form-control"  />
                   				
								<div class="input-group-append" onClick="L_Clientes_devo();">
									<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
								</div>
								<input type="hidden" name="v_idcliente" id="v_idcliente" />
							</div>
						</div>
					</div>
			</div>
		</form>
  	</div>
	
	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscarDevolucion('filtro');" style="margin-top: 5px;" >
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div id="li_modulos" class="module_content">
    		<div id="li_devolucion" class="tab_container">
    			
			</div>
		</div>	
	</div>
</div>