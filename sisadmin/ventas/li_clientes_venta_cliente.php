<?PHP
require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Funciones.php");


$db = new MySQL();
$cli = new Clientes();

$f = new Funciones();


$cli->db = $db;

$result_clientes = $cli->ObtenerInformacionClientes();


 

?>
<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_clientes').dataTable({		

		  "oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
						"sZeroRecords": "Nada Encontrado - Lo sentimos",
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
	});
</script>

<div id="li_modulos" class="tab_container">
	<table  border="0" cellspacing="2" cellpadding="2" class="table table-bordered"  id="d_clientes" style="color:#999" >
		<thead> 
			<tr>
				<th width="11%" align="center" style="border-top-left-radius: 5px">ID  </th>
				<th width="81%" align="center">NOMBRE CLIENTE</th>
				<th width="8%" align="center" style="border-top-right-radius: 5px">ACCION</th>
			</tr>
		</thead>    

		<tbody>
			<tr>
				<td align="center" >0</td>
				<td >Publico General</td>
				<td align="center" ><input type="button" name="button" id="button" value="Seleccionar" onClick="S_cliente_venta_cliente('0','Publico General','0','0'); CerrarModalGeneral('ModalPrincipal');"></td>
	  		</tr>

			<?php
			foreach($result_clientes as $result_clientes)
			{
				$id = $result_clientes->idcliente;
				$nombre = $f->espanol($result_clientes->nombre.' '.$result_clientes->paterno.' '.$result_clientes->materno);
				$idniveles = $result_clientes->idniveles;

				$sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
				$result_sql = $db->consulta($sql);
				$result_sql_row = $db->fetch_assoc($result_sql);

				$nivel = $result_sql_row['nombre'];		
			?>
			
			<tr>
				<td align="center" ><?php echo $id;?></td>
				<?php
				if($idniveles != 0){ 
				?>
				<td><?php echo $nombre." (Nivel: ".$nivel.")"; ?></td>
				<?php
				}else{
				?>
				<td><?php echo $nombre; ?></td>
				<?php
				}
				?>
				<td align="center" ><input type="button" name="button" id="button" value="Seleccionar" onClick="S_cliente_venta_cliente('<?php echo $id;?>','<?php echo $nombre;?>','<?php echo $nivel;?>','<?php echo $idniveles; ?>'); $('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');"></td>
	  		</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>

    