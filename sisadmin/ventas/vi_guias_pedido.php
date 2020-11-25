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

    
//Importamos las clases que vamos a utilizar
require_once("../clases/conexcion.php");
require_once("../clases/class.Guias_pedidos.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Funciones.php");


//Declaramos los objetos de clase
$db = new MySQL();
$gu = new Guias_pedido();
$fe = new Fechas();
$fu = new Funciones();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$gu->db = $db;

//Recibimos parametros enviados por GET
$idnota_remision = $_GET['id'];

$gu->idnota_remision = $idnota_remision;

$result = $gu->todas_guias_pedido();
$result_num = $db->num_rows($result);
$result_row = $db->fetch_assoc($result);

$sql = "SELECT idcliente FROM nota_remision WHERE idnota_remision = '$idnota_remision'";
$result_pedido = $db->consulta($sql);
$result_pedido_row = $db->fetch_assoc($result_pedido);

$sql_cliente = "SELECT * FROM clientes WHERE idcliente = '".$result_pedido_row['idcliente']."'";
$result_cliente = $db->consulta($sql_cliente);
$result_cliente_row = $db->fetch_assoc($result_cliente);


$t_estatus = array('Pendiente','En curso','Entregado','Cancelado');


if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert alert-success">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert alert-danger">Error. Intentar mas Tarde '.$_GET['ac'].'</div>';
	}

	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
    echo $msj;
}

?>

<script type="text/javascript">
	$('#titulo-visor').html("GUIAS DE PEDIDO # <?php echo $idnota_remision; ?>");
</script>

<div class="row">

	<div class="col-md-12">
    	<div class="row">
        	<div class="col-md-3">
            	<label style="font-weight:bold;">No. Pedido: </label>
                <span># <?php echo $idnota_remision; ?></span>
            </div>
            
            <div class="col-md-9">
            	<label style="font-weight:bold;">Cliente: </label>
                <span><?php echo $fu->imprimir_cadena_utf8($result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno']); ?></span>
            </div>
            
            <div class="col-md-12">
            	<label style="font-weight:bold;">Direcci&oacute;n env&iacute;o:</label>
                <span><?php echo $fu->imprimir_cadena_utf8($result_cliente_row['direccion_envio']); ?></span>
            </div>
        </div>
    </div>

	<div class="col-md-12">
		<button type="button" onclick="aparecermodulos('ventas/fa_guias_pedidos.php?id=<?php echo $idnota_remision; ?>','contenedor-visor-modal');" class="btn btn-info" style="float: right;">AGREGAR GU&Iacute;A</button>
		<div style="clear: both;"></div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-12">
		<table id="guias_pedidos" class="table">
			<thead>
				<tr>
					<th align="center" style="text-align: center;">PAQUETER&Iacute;A</th> 
					<th align="center" style="text-align: center;">No. GU&Iacute;A</th> 
					<th align="center" style="text-align: center;">FECHA</th>
					<th align="center" style="text-align: center;">COMENTARIOS</th>
					<th align="center" style="text-align: center;">ESTATUS</th>
					<th align="center" style="text-align: center;"><i class="mdi mdi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($result_num != 0){
					do
					{
				?>	
						<tr>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['nombre']); ?></td>
							<td align="center"><?php echo $result_row['idguias']; ?></td>
							<td align="center"><?php echo $fe->f_esp($result_row['fecha_envio']); ?></td>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['comentario']); ?></td>
							<td align="center"><?php echo $t_estatus[$result_row['estatus']]; ?></td>
							<td>
								<a href="#" onClick="abrir_detalle_sobrepedido('ventas/fa_guias_pedidos.php?idguias=<?php echo $result_row['idguias']; ?>&id=<?php echo $idnota_remision; ?>');" title="EDITAR" style="font-size: 11px;"><i class="mdi mdi-table-edit"></i></a>
								
								<a href="#" onclick="BorrarGuias('<?php echo $result_row['idguias'] ?>','idguias','guias','v','ventas/vi_guias_pedido.php?id=<?php echo $idnota_remision; ?>','contenedor-visor-modal');" title="BORRAR"><i class="mdi mdi-delete-empty"></i></a>
							</td>
						</tr>
				<?php
					}while($result_row = $db->fetch_assoc($result));
				}
				?>
			</tbody>
		</table>
	</div>
</div>


<script>
	$('#guias_pedidos').dataTable( {	
		   "ordering": false,
        	"info":     false,
		   "lengthChange": false,
		   "pageLength": 50,	
		   "oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
						"sZeroRecords": "Lo sentimos, no se han encontrado guias.",
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
						}
		} );
</script>