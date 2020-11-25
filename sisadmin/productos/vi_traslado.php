<?php
  header("Content-Type: text/text; charset=ISO-8859-1");
   require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}
    require_once("../clases/conexcion.php");
	require_once("../clases/class.Traspaso.php");
	 
	$db = new MySQL();
	$tra = new Traspaso();
	
	$tra->db = $db;
	 
	$result_traspaso = $tra->todos();
	$result_traspaso_row = $db->fetch_assoc($result_traspaso);
	$result_traspaso_num = $db->num_rows($result_traspaso);
 
 
 
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
	   "sPaginationType": "full_numbers",
	   "sScrollX": "100%",
	   "sScrollXInner": "100%",
	   "bScrollCollapse": true,
	} );

</script>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">LISTA DE TRASPASOS A SUCURSAL</h5>
		<button type="button" onClick="aparecermodulos('productos/fa_traslado.php','main');" class="btn btn-info" style="float: right;">AGREGAR TRASPASO</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			<table id="d_modulos" class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr> 
						<th>ID</th> 
						<th>USUARIO</th>
						<th>DE</th>
						<th>PARA</th>
						<!--<th>PRODUCTO</th>
						<th>CANTIDAD</th>-->
						<th>FECHA</th>
						<th>OBSERVACIONES</th>
						<th>ACCI&Oacute;N</th>
					</tr> 
				</thead>
				<tbody>
<?php
			if($result_traspaso_num != 0){
            do
			{  
				$idtraspaso = $result_traspaso_row['idtraspaso'];
				$idusuarios = $result_traspaso_row['idusuarios'];
				$de = $result_traspaso_row['de'];
				$para = $result_traspaso_row['para'];
				
				//Buscamos el detalle
				$tra->idtraspaso = $idtraspaso;
				$result_detalle = $tra->buscarDetalle();
				$result_detalle_row = $db->fetch_assoc($result_detalle);
			
				//Buscamos al usuario
				$sql = "SELECT * FROM usuarios WHERE idusuarios = '$idusuarios'";
				$result_usuarios = $db->consulta($sql);
				$result_usuarios_row = $db->fetch_assoc($result_usuarios);
			
				//Buscamos las sucursales
				$sql_de = "SELECT * FROM sucursales WHERE idsucursales = '$de'";
				$result_de = $db->consulta($sql_de);
				$result_de_row = $db->fetch_assoc($result_de);
				
				$sql_para = "SELECT * FROM sucursales WHERE idsucursales = '$para'";
				$result_para = $db->consulta($sql_para);
				$result_para_row = $db->fetch_assoc($result_para);
				
			?>
				<tr> 
   					<td style="text-align:center"><?php echo $idtraspaso; ?></td> 
   				 
                   <td><?php echo $result_usuarios_row['usuario'] ?></td>
                 
                   <td><?php echo $result_de_row['sucursal']; ?></td>
                   <td><?php echo $result_para_row['sucursal']; ?></td>
                  <!-- <td><?php echo $result_detalle_row['idproducto']; ?></td>
                   <td><?php echo $result_detalle_row['cantidad']; ?></td>-->
                   <td><?php echo $result_traspaso_row['fecha'];?></td>
                 	<td><?php echo utf8_encode($result_traspaso_row['observaciones']); ?></td>
                   <td align="center">
                    <!--<input type="image" src="images/icn_categories.png" title="VER DETALLE" onclick="aparecermodulos('productos/vi_traspasos_lista.php?id=<?php echo $result_traspaso_row['idtraspaso']; ?>','main')">-->
                    <!--<input type="image" src="images/icn_edit.png" title="EDITAR" onclick="aparecermodulos('productos/fc_etiquetas.php?id=<?php echo $result_etiquetas_row['idetiquetas']; ?>','main')">-->
					   
					   <button type="button" onClick="imprimirPDF('productos/pdf/OrdenTraslado.php?id=<?php echo $result_traspaso_row['idtraspaso']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
					   
                  <!-- <input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarDatos('<?php echo $$result_etiquetas_row['idetiquetas'];?>','idetiquetas','etiquetas','n','productos/vi_etiquetas.php','main')">-->
                    </td> 
				</tr>
            <?php 
			   }
			   while($result_traspaso_row = $db->fetch_assoc($result_traspaso));
			}
			?>
				</tbody>
			</table>
		</div>
  	</div>
</div>
