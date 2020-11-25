<?php
require_once("../clases/class.Sesion.php");

$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}
    
require_once("../clases/conexcion.php");
require_once("../clases/class.Paqueterias.php");
require_once("../clases/class.Guias_pedidos.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Funciones.php");

$db = new MySQL();
$pa = new Paqueterias();
$gu = new Guias_pedido();
$ve = new Ventas();
$cl = new Clientes();
$fu = new Funciones();

$pa->db = $db;
$gu->db = $db;
$ve->db = $db;
$cl->db = $db;

$paqueterias = $pa->obtener_activas();
$paqueterias_num = $db->num_rows($paqueterias);
$paqueterias_row = $db->fetch_assoc($paqueterias);

$t_estatus = array('Pendiente','En curso','Entregado','Cancelado');


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
		<h5 class="card-title" style="float: left; margin-top: 5px;">FILTRAR GU&Iacute;AS</h5>
		<button type="button" onClick="aparecermodulos('ventas/fa_guias.php','main');" class="btn btn-info" style="float: right;">AGREGAR GU&Iacute;A</button>
		<div style="clear: both;"></div>
	</div>

	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>No. PEDIDO:</label>
						<input class="form-control" type="text" id="v_no_pedido" name="v_no_pedido" >
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Nombre:</label>
						<div class="input-group">
							<input class="form-control" type="text" id="n_nombre" name="nombre">
							<div class="input-group-append" onClick="L_Clientes_venta_cliente();">
								<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
							</div>
							<input type="hidden" id="nombre" />
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscarGuias('filtro');" style="margin-top: 5px;" >
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div id="li_guias" class="tab_container">
			<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
				<thead> 
					<tr> 
						<th align="center=">No. PEDIDO</th>
						<th align="center">CLIENTE</th>
						<th align="center">DIRECCI&Oacute;N DE ENV&Iacute;O</th>
						<th align="center">ACCI&Oacute;N</th>
					</tr> 
				</thead>

				<tbody> 
					<tr>
						<td align="center" colspan="4">LO SENTIMOS, NO EXISTEN PEDIDOS DISPONIBLES</td>
					</tr>
				</tbody> 
			</table>
		</div>
	</div>
</div>      