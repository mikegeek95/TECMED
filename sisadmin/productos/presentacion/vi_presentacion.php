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
	require_once("../../clases/class.Botones.php");
	require_once("../../clases/class.Funciones.php");
	 
	 $db = new MySQL();
	$bt = new Botones_permisos();
	$f= new Funciones();

	 $sql_tallas = "SELECT * FROM tallas";
	 $result_tallas = $db->consulta($sql_tallas);
	 $result_tallas_row = $db->fetch_assoc($result_tallas);
	 $result_tallas_num = $db->num_rows($result_tallas);

	$t_estatus = array('DESACTIVADO','ACTIVADO');


if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
	

 ?>
 
<script type="text/javascript" charset="utf-8">
var oTable = $('#d_modulos').dataTable( {		

  "oLanguage": {
				"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
				"sZeroRecords": "NO EXISTEN TALLAS EN LA BASE DE DATOS",
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
});
</script>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE PRESENTACIONES</h5>
		
				<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "Nueva Presentaci&oacute;n";
										$bt->icon = "fas fa-plus";
										$bt->funcion = "aparecermodulos('productos/presentacion/fa_presentacion.php?idmenumodulo=$idmenu','main');";
										$bt->estilos = "float:right;margin-right: 10px; margin-top: 6px;";
										$bt->permiso = $permisos;
										$bt->tipo = 1;

										$bt->armar_boton();
									?>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			 <table class="table table-bordered " id="d_modulos" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white">
					<tr>
						<th>ID</th> 
						<th>UNIDAD</th>
						<th>VALOR</th>
						<th>DESCRIPCI&Oacute;N</th>
						<th>ESTATUS</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
<?php
				if($result_tallas_num != 0){
					do
					{     
?>
					<tr> 
   						<td style="text-align:center"><?php echo $result_tallas_row['idtallas']; ?></td> 
						<td><?php echo $result_tallas_row['unidad']; ?></td>
                   		<td><?php echo $result_tallas_row['valor']; ?></td>
                   		<td><?php echo $result_tallas_row['descripcion']; ?></td>
                   		<td><?php echo $t_estatus[$result_tallas_row['estatus']]; ?></td>
                		<td align="center">	
							

							
							  <?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('productos/presentacion/fa_presentacion.php?idmenumodulo=$idmenu&idtallas=".$result_tallas_row['idtallas']."','main');";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
							
							
							
																						<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_tallas_row['idtallas']."','idtallas','tallas','n','productos/presentacion/vi_presentacion.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
							
                    	</td> 
					</tr>
<?php 
			   		}while($result_tallas_row = $db->fetch_assoc($result_tallas));
				}
?>
				</tbody>
			</table>
		</div>
  	</div>
</div>