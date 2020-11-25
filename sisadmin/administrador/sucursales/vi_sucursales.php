<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

$idmenu=$_GET['idmenumodulo'];

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Paginas.php");
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

$db= new MySQL();
$pag= new Paginas();
$suc = new Sucursales();
$bt = new Botones_permisos();
$f = new Funciones();

$suc->db = $db;

$resp=$suc->todasSucursales();
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);


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
						"sZeroRecords": "No Existen Sucursales en la base de datos",
						"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
						"sInfoEmpty": "desde 0 a 0 de 0 records",
						"sInfoFiltered": "",
						"sSearch": "Buscar",
						"oPaginate": {
									 "sFirst":    "Inicio",
									 "sPrevious": "Anterior",
									 "sNext":     "Siguiente", "sLast":     "&Uacute;ltimo"
									 }
						},
		   "sPaginationType": "full_numbers",
		   "sScrollX": "100%",
		   "sScrollXInner": "100%",
		   "bScrollCollapse": true
		  
		  
			
		} );
	//});
	
</script>


<div class="card">
	<div class="card-header">
		<h5 class=" m-b-0 font-weight-bold text-primary" style="float: left;">LISTA DE SUCURSALES</h5>
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nueva Sucursal";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('administrador/sucursales/fa_sucursales.php?idmenumodulo=$idmenu','main');";
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
						<th>SUCURSAL</th> 
						<th>DIRECCI&Oacute;N</th>
						<th>TELEFONO</th>
						<th>EMAIL</th> 
						<th>ESTATUS</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($total==0)
						{
						}else{
							do{
								$tipo = array('DESACTIVADO','ACTIVADO');
					?>
					<tr> 
						<td width="50"><?php echo $f->imprimir_cadena_utf8($rows['idsucursales']);?></td> 
						<td><?php echo $f->imprimir_cadena_utf8($rows['sucursal']);?></td> 
						<td><?php echo $f->imprimir_cadena_utf8($rows['direccion']);?></td> 
						<td><?php echo $f->imprimir_cadena_utf8($rows['tel']);?></td> 
						<td><?php echo $f->imprimir_cadena_utf8($rows['email']);?></td> 
						<td><?php echo $f->imprimir_cadena_utf8($tipo[$rows['estatus']]); ?></td>
						<td>
							<!-- Inicia Editar -->
							<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('administrador/sucursales/fa_sucursales.php?id=".$rows['idsucursales']."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
							
							<!-- Inicia Borrar -->
							<?php
							//Validamos que sea principal para bloquear la eliminacion
							if($rows['tipo'] == 0){

							?>
							<?php
							}else{
							?>
							<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$rows['idsucursales']."','idsucursales','sucursales','n','administrador/sucursales/vi_sucursales.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
							
							<?php
							}
							?>

						</td> 
					</tr>
					<?php
							}while($rows=$db->fetch_assoc($resp));
						}
					?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>