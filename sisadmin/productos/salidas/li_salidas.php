<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Funciones.php");

$db = new  MySQL();
$fecha = new Fechas();
$f=new Funciones();

$sql_salida = "SELECT * FROM salidas ORDER BY idsalidas DESC";


$result_salida = $db->consulta($sql_salida);
$result_salida_row = $db->fetch_assoc($result_salida);

$tipo = array("Venta","Devolución","Producto Fallo","Caducado");

if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	
	echo $msj;
}
?>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE SALIDAS</h5>
		<button type="button" onClick="aparecermodulos('productos/salidas/vi_salidas.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i>   AGREGAR SALIDA</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			<table id="zero_config" class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead class="px-3 py-5 bg-gradient-danger text-white">
					<tr>
						<th>ID SALIDA</th> 
						<th>FECHA</th>
						<!--<th>TIPO</th>-->
						<!--<th>TOTAL</th>
						<th>TiPO PAGO</th>
						<th>ESTATUS</th>-->
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					  <?php 	     
	     				do
						{
						?>
					<tr> 
   				  		<td style="text-align:center"><?php echo $result_salida_row['idsalidas']; ?></td> 
   				  		<td><?php echo $fecha->fecha_texto($result_salida_row['fecha']); ?></td>
   				 		<!-- <td align="center"><?php /*echo $tipo[$result_salida_row['tipo']];*/ ?></td>-->
                  
                 	 	<td align="center">
							
							<button data-toggle="modal" data-target="#modal-forms" type="button" onClick="imprimirPDF('productos/pdf/reporteSalida.php?id=<?php echo $result_salida_row['idsalidas']; ?>','REPORTE DE SALIDA DE PRODUCTO');" title="IMPRIMIR" class="btn btn-outline-danger">
								<i class="far fa-file-pdf"></i>
							</button>

							<a href="productos/excel/excelSalidas.php?id=<?php echo $result_salida_row['idsalidas']; ?>" title="EXPORTAR EXCEL" class="btn btn-outline-success">
								<i class="far fa-file-excel"></i>
							</a>   													 						 
                  		</td> 
					</tr>
                
                <?php
				}while($result_salida_row = $db->fetch_assoc($result_salida));
				?>
				</tbody>
			</table>
		</div>
  	</div>
</div>


<script type="text/javascript" charset="utf-8">
	var oTable = $('#zero_config').dataTable( {	
	   "ordering": false,
	   "lengthChange": true,
	   "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "Lo sentimos - Ningun registro encontrado",
					"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty": "desde 0 a 0 de 0 records",
					"sInfoFiltered": "",
					"sSearch": "Buscar",
					"oPaginate": {
								 "sFirst":    "Inicio",
								 "sPrevious": "Anterior",
								 "sNext":     "Siguiente",
								 "sLast":     "&Uacute;ltimo"
								 }
					},
	   "sPaginationType": "full_numbers"
	} );

</script>