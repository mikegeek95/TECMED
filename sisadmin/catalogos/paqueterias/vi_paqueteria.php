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
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");
	 
	 $db = new MySQL();
	$f = new Funciones();
	$bt = new Botones_permisos();
	 
	 $sql_paqueterias = "SELECT * FROM paqueterias";
	 $result_paqueterias = $db->consulta($sql_paqueterias);
	 $result_paqueterias_row = $db->fetch_assoc($result_paqueterias);
	 $result_paqueterias_row_num = $db->num_rows($result_paqueterias);

	$estatus = array('DESACTIVADO','ACTIVADO');



//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



 
 ?>
<script type="text/javascript" charset="utf-8">

	//$(document).ready(function() {

		var oTable = $('#zero_config').dataTable( {		

			  "oLanguage": {
							"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
							"sZeroRecords": "Lo sentimos, no se han encontrado registros.",
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
			   "bScrollCollapse": true



		} );
		//} );
</script>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-b-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE PAQUETER&Iacute;AS</h5>
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nueva Paqueter&iacute;a";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('catalogos/paqueterias/fa_paqueteria.php?idmenumodulo=$idmenu','main');";
			$bt->estilos = "float: right;";
			$bt->permiso = $permisos;
			$bt->tipo = 1;
		
			$bt->armar_boton();
		?>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="zero_config" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
					<tr>
						<th>ID</th> 
						<th>NOMBRE</th>
						<th>DIRECCI&Oacute;N</th>
						<th>TEL&Eacute;FONO</th>
						<th>E-MAIL</th>
						<th>URL RASTREO</th>
						<th>ESTATUS</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($result_paqueterias_row_num == 0){
					}else{
            			do
						{
					?>
            
					<tr> 
   				  		<td style="text-align:center"><?php echo $f->imprimir_cadena_utf8($result_paqueterias_row['idpaqueterias']); ?></td>  
					  	<td><?php echo  $f->imprimir_cadena_utf8($result_paqueterias_row['nombre']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($result_paqueterias_row['direccion']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($result_paqueterias_row['tel']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($result_paqueterias_row['email']); ?></td>
						<td><?php echo $f->imprimir_cadena_utf8($result_paqueterias_row['urlrastreo']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($estatus[$result_paqueterias_row['estatus']]); ?></td>
						<td align="center">
							
							
							<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('catalogos/paqueterias/fa_paqueteria.php?idpaqueterias=".$result_paqueterias_row['idpaqueterias']."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
							<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_paqueterias_row['idpaqueterias']."','idpaqueterias','paqueterias','n','catalogos/paqueterias/vi_paqueteria.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
													
						</td> 
					</tr>
					<?php 
					}while($result_paqueterias_row = $db->fetch_assoc($result_paqueterias));
					}
					?>
				</tbody>
			</table>
		</div>
  	</div>
</div>