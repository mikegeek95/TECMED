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
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.Funciones.php");


$db = new  MySQL();
$suc = new Sucursales();
$f=new Funciones();

$suc->db = $db;


$sql_entrada = "SELECT * FROM entradas ORDER BY identradas DESC";


$result_entrada = $db->consulta($sql_entrada);
$result_entrada_row = $db->fetch_assoc($result_entrada);
$result_entrada_num = $db->num_rows($result_entrada);

$tipo = array("Venta","Devolución","Producto Fallo","Caducado");


?>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE ENTRADAS</h5>
		<button type="button" onClick="aparecermodulos('productos/entradas/vi_entradas.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i> AGREGAR ENTRADAS</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			<table id="zero_config" class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead class="px-3 py-5 bg-gradient-success text-white"> 
					<tr>
						<th width="53">FECHA</th> 
						<th width="139">DESCRIPCIÓN</th>
						<th width="60">Sucursal</th>
						<!--<th>TIPO</th>-->
						<!--<th>TOTAL</th>
						<th>TiPO PAGO</th>
						<th>ESTATUS</th>-->
						<th width="95" align="center">ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					 <?php 
					if($result_entrada_num == 0){
					}else{
						do
						{
					?>
					<tr> 
   				  		<td style="text-align:center"><?php echo $result_entrada_row['fecha_entrada']; ?></td> 
   				  		<td><?php echo $f->imprimir_cadena_utf8 ($result_entrada_row['descripcion']); ?></td>
                 
					 <?php 
						$idsucursales = $result_entrada_row['idsucursales'];
						$suc->idsucursales = $idsucursales;

						$result_sucursales = $suc->buscar_sucursal();
						$result_sucursales_row = $db->fetch_assoc($result_sucursales);

						$sucursal = $f->imprimir_cadena_utf8($result_sucursales_row['sucursal']);
					 ?>
 				                
                 		<td><?php echo $sucursal; ?></td>
                 
                 
				 	<td align="center">
						 
						<button data-toggle="modal" data-target="#modal-forms" type="button" onClick="imprimirPDF('productos/pdf/reporteEntradas.php?id=<?php echo $result_entrada_row['identradas']; ?>','REPORTE DE ENTRADA DE PRODUCTO');" title="IMPRIMIR" class="btn btn-outline-danger">
							<i class="far fa-file-pdf"></i>
					 	</button>
						 
					 	
										 
						<a href="productos/excel/excelEntradas.php?id=<?php echo $result_entrada_row['identradas']; ?>" title="EXPORTAR EXCEL" class="btn btn-outline-success">
							<i class="far fa-file-excel"></i>
					 	</a>   
					</td> 
				</tr>
                
                <?php
				}while($result_entrada_row = $db->fetch_assoc($result_entrada));
		 }
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
	   "sPaginationType": "full_numbers",
	   "sScrollX": "100%",
	   "sScrollXInner": "100%",
	   "bScrollCollapse": true,
	} );

</script>