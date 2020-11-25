<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Al incluir este header nos olvidamos de colocar el utf8_encode para visualizar caracteres especiales á ñ etc.
header("Content-Type: text/text; charset=ISO-8859-1");
    
//Importamos las clases que vamos a utilizar
require_once("../clases/conexcion.php");	 
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Campanas.php");
require_once("../clases/class.Sobrepedidos.php");
require_once("../clases/class.Fechas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$cam = new Campanas();
$client = new Clientes();
$sp = new Sobrepedidos();
$fe = new Fechas();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$client->db = $db;
$cam->db = $db;
$sp->db = $db;

//Declaramos variables a utilizar
$estatus  = array('Pendiente','Autorizado','Cancelado');
$idsucursales = $_SESSION['se_sas_Sucursal'];

//Realizamos consultas

//Obtenemos todas las campañas para el filtro
$result_campanas = $cam->todas();
$result_campanas_num = $db->num_rows($result_campanas);
$result_campanas_row = $db->fetch_assoc($result_campanas);

//Obtenemos los sobrepedidos pendientes
$result_sobrepedidos = $sp->obtener_sobrepedidos_pendientes();
$result_sobrepedidos_num = $db->num_rows($result_sobrepedidos);
$result_sobrepedidos_row = $db->fetch_assoc($result_sobrepedidos);

//Obtenemos el tipo de impresion que tenemos
$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursales'";
$result_imp = $db->consulta($sql_imp);
$result_imp_row = $db->fetch_assoc($result_imp);
$impresion = $result_imp_row['notas_print'];


//Validamos mensaje a mostrar después de finalizar algún proceso.
if(isset($_GET['ac']))
{
	if($_GET['ac']==1){
		$msj='<div id="mens" class="alert alert-success" role="alert">'.$_GET['msj'].'</div>';
	}else{
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
	   
	 var oTable = $('#d_sobrepedidos').dataTable( {		
		 	  //"ordering": false,
			"order": [[ 2, 'asc' ]],
			  "oLanguage": {
							"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
							"sZeroRecords": "Lo sentimos, no se han encontrado sobre pedidos.",
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
		<h5 class="card-title" style="float: left; margin-top: 5px;">FILTRAR SOBRE PEDIDOS</h5>
		<!--<button type="button" onClick="aparecermodulos('catalogos/fa_paqueteria.php','main');" class="btn btn-info" style="float: right;">AGREGAR PAQUETER&Iacute;A</button>
		<div style="clear: both;"></div>-->
	</div>
  	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">

				<div class="col-md-3">
					<div class="form-group">
						<label>No. Sobre pedido:</label>
						<input class="form-control" type="text" id="v_idsobrepedido" name="v_idsobrepedido" >
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
							<input class="form-control" type="text" id="n_nombre" name="nombre">
							<div class="input-group-append" onClick="L_Clientes_venta_cliente();">
								<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
							</div>
							<input type="hidden" id="nombre" />
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Campa&ntilde;as:</label>
						<select name="campanas" id="campanas" class="form-control">
							<?php
							if($result_campanas_num == 0){
							?>
								<option value="0">SELECIONE UNA CAMPA&Ntilde;A</option>
							<?php
							}else{
							?>
								<option value="0">SELECIONE UNA CAMPA&Ntilde;A</option>
							<?php
								do
								{
							?>
									<option value="<?php echo $result_campanas_row['idsobrepedido_camp'] ?>"><?php echo $result_campanas_row['nombre']; ?></option>
							<?php
								}while($result_campanas_row = $db->fetch_assoc($result_campanas));
							}
							?>
						</select>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Estatus:</label>
						<select name="estatust" id="estatust" class="form-control">
							<option value="n">SELECCIONE UN ESTATUS</option>
							<option value="0">PENDIENTE</option>
							<option value="1">AUTORIZADOS</option>
							<option value="2">CANCELADO</option>
							<option value="3">DESPACHADO</option>
						</select>
					</div>
				</div>

			</div>
		</form>
  	</div>
	
	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscarSobrepedido('filtro');" style="margin-top: 5px;" >
	</div>
</div>


<div class="card">
	<div class="card-body">
		<div id="li_modulos" class="module_content">
    		<div id="li_sobrepedidos" class="tab_container">
    			<table  class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_sobrepedidos"> 
        			<thead> 
            			<tr> 
							<th align="center" style="text-align: center;"># SOBREPEDIDO</th> 
							<th align="cealign=" style="text-align: center;">FECHA</th>
							<th align="center" style="text-align: center;">NOMBRE</th>
							<th align="center" style="text-align: center;">TOTAL</th>
							<th align="center" style="text-align: center;">ESTATUS</th>
							<th align="center" style="text-align: center;">ACCI&Oacute;N</th>
            			</tr> 
        			</thead>
					
        			<tbody> 
        			<?php
						if($result_sobrepedidos_num != 0){
	     					do
            				{
								$client->idCliente = $result_sobrepedidos_row['idcliente'];								
								$result_cliente = $client->ObtenerInformacionCliente();					
								$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
								
								$sp->idsobrepedido = $result_sobrepedidos_row['idsobrepedido'];
								$total = $sp->obtener_total_sobrepedido();
                	?>
            			<tr> 
					  		<td style="text-align:center"><?php echo $result_sobrepedidos_row['idsobrepedido']; ?></td> 
					  		<td align="center"><?php echo $fe->f_esp($result_sobrepedidos_row['fecha']); ?></td>
					  		<td align="center"><?php echo $cliente; ?></td>
					  		<td align="center">$ <?php echo number_format($total,2,'.',','); ?></td>
					  		<td align="center" style="background: #fff600; color: #000;"><?PHP echo $estatus[$result_sobrepedidos_row['estatus']]; ?></td>
              		
              				<td align="center">
								<!-- BOTONES DE IMPRESION VALIDANDO TERMICO O CARTA -->
								
								<button type="button" onClick="abrir_detalle_sobrepedido('ventas/vi_anticipos_sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="VER ANTICIPOS" class="btn btn-outline-info"><i class="mdi mdi-square-inc-cash"></i></button>
								
								<button type="button" onClick="autorizar_sobrepedido('<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="AUTORIZAR" class="btn btn-outline-info"><i class="mdi mdi-briefcase-check"></i></button>
								
								<button type="button" onClick="abrir_detalle_sobrepedido('ventas/vi_detalle_sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="VER DETALLE" class="btn btn-outline-info"><i class="mdi mdi-arrange-send-backward"></i></button>
								
																
								<!--<?php
								if($impresion == 0){ 
								?>
									<a href="#" onClick="imprimirPDF('ventas/pdf/sobrePedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
								<?php
								}else{
									if($impresion == 1){
								?>
										<a href="#" onClick="imprimirPDF('ventas/pdf/sobrePedido_termico.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
								<?php
									}else{
								?>
										<a href="#" onClick="imprimirPDF('ventas/pdf/sobrePedido_termico2.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
								<?php
									}
								}
								?>-->
								
								<button type="button" onClick="cancelarSobrePedido('<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" title="CANCELAR" class="btn btn-outline-danger"><i class="mdi mdi-block-helper"></i></button>								
							</td> 
            			</tr>
            			<?php
            				}while($result_sobrepedidos_row = $db->fetch_assoc($result_sobrepedidos));
						}
						?>
        			</tbody> 
        		</table>
			</div>
		</div>	
	</div>
</div>      