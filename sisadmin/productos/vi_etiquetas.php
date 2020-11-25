<?php
   // header("Content-Type: text/text; charset=ISO-8859-1");
   require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

    require_once("../clases/conexcion.php");
	 
	$db = new MySQL();
	 
	$sql_etiquetas = "SELECT * FROM etiquetas ORDER BY idetiquetas DESC";
	$result_etiquetas = $db->consulta($sql_etiquetas);
	$result_etiquetas_row = $db->fetch_assoc($result_etiquetas);
	$result_etiquetas_row_num = $db->num_rows($result_etiquetas);


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

<script type="text/javascript" charset="utf-8">


	var oTable = $('#d_modulos').dataTable( {	
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

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">LISTA DE ETIQUETAS</h5>
		<button type="button" onClick="aparecermodulos('productos/fa_etiquetas.php','main');" class="btn btn-info" style="float: right;">AGREGAR LISTA DE ETIQUETA</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			<table id="d_modulos" class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr> 
						<th>ID LISTA</th> 
						<th>FECHA</th>
						<th>DESCRIPCI&Oacute;N</th>
						<th>ACCI&Oacute;N</th>
					</tr> 
				</thead>
				<tbody>
<?php
				if($result_etiquetas_row_num == 0){
				}else{
            		do
					{  
?>
					<tr> 
   						<td style="text-align:center"><?php echo $result_etiquetas_row['idetiquetas']; ?></td> 
                   		<td><?php echo $result_etiquetas_row['fecha'] ?></td>
                   		<td><?php echo $result_etiquetas_row['descripcion']; ?></td>
                   		<td align="center">
							
							<button type="button" onClick="aparecermodulos('productos/fa_lista_etiquetas.php?id=<?php echo $result_etiquetas_row['idetiquetas']; ?>','main');" title="AGREGAR" class="btn btn-outline-info"><i class="mdi mdi-tooltip-outline-plus"></i></button>
							
							<button type="button" onClick="imprimirPDF('productos/etiquetas.php?id=<?php echo $result_etiquetas_row['idetiquetas']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
							
							<button type="button" onClick="aparecermodulos('productos/fc_etiquetas.php?id=<?php echo $result_etiquetas_row['idetiquetas']; ?>','main');" title="EDITAR" class="btn btn-outline-info"><i class="mdi mdi-table-edit"></i></button>
							
							
							
							<button type="button" onClick="BorrarDatos('<?php echo $result_etiquetas_row['idetiquetas'];?>','idetiquetas','etiquetas','n','productos/vi_etiquetas.php','main')" title="BORRAR" class="btn btn-outline-danger"><i class="mdi mdi-delete-empty"></i></button>
																												
                    	</td> 
					</tr>
 <?php 
			   		}while($result_etiquetas_row = $db->fetch_assoc($result_etiquetas));
				}
			?>
				</tbody>
			</table>
		</div>
  	</div>
</div>