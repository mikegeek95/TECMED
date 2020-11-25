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
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Fechas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$ve = new Ventas();
$fe = new Fechas();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$ve->db = $db;

//Recibimos parametros enviados por GET
$idnota_remision = $_GET['id'];

$ve->id_notaremision = $idnota_remision;

//Obtenemos la lista de los depositos generados
$result_depositos = $ve->obtener_depositos_pedido();
$result_depositos_num = $db->num_rows($result_depositos);
$result_depositos_row = $db->fetch_assoc($result_depositos);

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
	$('#titulo-visor').html("DEPOSITOS DE PEDIDO # <?php echo $idnota_remision; ?>");
</script>

<div class="row">
	<div class="col-md-12">
		<button type="button" onclick="aparecermodulos('ventas/fa_depositos_pedido.php?id=<?php echo $idnota_remision; ?>','contenedor-visor-modal');" class="btn btn-info" style="float: right;">AGREGAR DEPOSITO</button>
		<div style="clear: both;"></div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-12">
		<table id="depositos_pedidos" class="table">
			<thead>
				<tr>
					<th align="center" style="text-align: center;">FECHA</th> 
					<th align="center" style="text-align: center;">REF.</th>
					<th align="center" style="text-align: center;">BANCO</th>
					<th align="center" style="text-align: center;">MONTO</th>
					<th align="center" style="text-align: center;"><i class="mdi mdi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($result_depositos_num != 0){
					do
					{
				?>	
						<tr>
							<td align="center"><?php echo $fe->f_esp($result_depositos_row['fecha_deposito']); ?></td>
							<td align="center"><?php echo $result_depositos_row['referencia']; ?></td>
							<td align="center"><?php echo $result_depositos_row['banco']; ?></td>
							<td align="center"><?php echo "$ ".number_format($result_depositos_row['monto']); ?></td>
							<td>
								<!--<a href="#" onClick="abrir_detalle_sobrepedido('ventas/fa_depositos_pedido.php?idnota_remision_depositos=<?php echo $result_depositos_row['idnota_remision_depositos']; ?>&id=<?php echo $idnota_remision; ?>');" title="EDITAR" style="font-size: 11px;"><i class="mdi mdi-table-edit"></i></a>-->
								
								<a href="#" onclick="BorrarDeposito('<?php echo $result_depositos_row['idnota_remision_depositos'] ?>','idnota_remision_depositos','nota_remision_depositos','n','ventas/vi_depositos_pedido.php?id=<?php echo $idnota_remision; ?>','contenedor-visor-modal');" title="BORRAR"><i class="mdi mdi-delete-empty"></i></a>
							</td>
						</tr>
				<?php
					}while($result_depositos_row = $db->fetch_assoc($result_depositos));
				}
				?>
			</tbody>
		</table>
	</div>
</div>


<script>
	$('#depositos_pedidos').dataTable( {	
		   "ordering": false,
        	"info":     false,
		   "lengthChange": false,
		   "pageLength": 50,	
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
						}
		} );
</script>