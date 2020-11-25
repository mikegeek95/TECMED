<?php
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Funciones.php");
//creamos nuestra sesion.
$se = new Sesion();
$fu = new Funciones();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Paginas.php");
require_once("../../clases/class.ModulosMenu.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$db = new MySQL();
$fu = new Funciones();
$bt = new Botones_permisos();

//$pag= new Paginas();

$mm= new ModulosMenu();
$mm->db=$db;


$query="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM modulos ORDER BY nivel";
$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);




//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



?>

 

		<script type="text/javascript" charset="utf-8">
				
				var oTable = $('#zero_config').dataTable( {		
					"pageLength": 5,
					  "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "NO EXISTEN M&Oacute;DULOS EN LA BASE DE DATOS",
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
				
				var oTable = $('#submenus').dataTable( {
					"pageLength": 5,
					
					  "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "NO EXISTEN MEN&Uacute;S EN LA BASE DE DATOS.",
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
				
				
				/*new FixedColumns( oTable, {
 		             
		              
					  "iLeftColumns": 0,
		              "iRightColumns": 1
					   });*/
		</script>


<div class="card">
	<div class="card-header">
		<h5 class=" m-b-0 font-weight-bold text-primary" style="float: left;">LISTA DE M&Oacute;DULOS</h5>
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo M&oacute;dulo";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('administrador/modulos/fa_modulos.php?idmenumodulo=$idmenu','main');";
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
						<th>ID M&Oacute;DULO</th> 
						<th>M&Oacute;DULOS</th>
						<th>NIVEL</th> 
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
					?>
								<tr> 
									<td><?php echo $rows['idmodulos'];?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['modulo']);?></td>
									<td align="center"><?php echo $fu->imprimir_cadena_utf8($rows['nivel']);?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['est']);?></td> 
									<td>
										<!--<a href="#" onClick="aparecermodulos('administrador/modulos/fc_modulos.php?id=<?php echo $rows['idmodulos'];?>','main');" title="EDITAR"><i class="far fa-edit"></i></a>-->
										
										
										<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "far fa-edit";
											$bt->funcion = "aparecermodulos('administrador/modulos/fa_modulos.php?id=".$rows['idmodulos']."&idmenumodulo=".$idmenu."','main');";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 2;

											$bt->armar_boton();
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

<br>

<?php

	//sacando los menus del sistema
	$queryMenu="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM  modulos_menu ORDER BY nivel";
	$respmenu=$db->consulta($queryMenu);
	$rowsmenu=$db->fetch_assoc($respmenu);
	$totalmenu=$db->num_rows($respmenu);
	
	
?>

<div class="card">
	<div class="card-header">
		<h5 class=" m-b-0 font-weight-bold text-primary" style="float: left;">LISTA DE MEN&Uacute;S</h5>
		
		<div style="padding: 20px;">			
			<?php
				//SCRIPT PARA CONSTRUIR UN BOTON
				$bt->titulo = "Nuevo Men&uacute;";
				$bt->icon = "fas fa-plus";
				$bt->funcion = "aparecermodulos('administrador/modulos/fa_menu.php?idmenumodulo=$idmenu','main');";
				$bt->estilos = "float: right;";
				$bt->permiso = $permisos;
				$bt->tipo = 1;

				$bt->armar_boton();
			?>
			
			<div style="clear: both;"></div>
		</div>
	</div>	
	<div class="card-body">
             	
		 <div class="table-responsive">
                <table class="table table-bordered" id="submenus" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
					<tr>
						<th>ID MEN&Oacute;</th>
						<th>M&Oacute;DULO</th>
						<th>MEN&Uacute;</th>
						<th>ARCHIVO</th>
						<th>UBICACI&Oacute;N</th>
						<th>NIVEL</th>
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
					?>
					<tr> 
						<td><?php echo $rowsmenu['idmodulos_menu'];?></td> 
						<td><?php $mm->idmodulo=$rowsmenu['idmodulos']; $datos=$mm->ObtenerInfoModulo(); echo $fu->imprimir_cadena_utf8($datos['modulo']);?></td>
						<td><?php echo $fu->imprimir_cadena_utf8($rowsmenu['menu']);?></td> 
						<td><?php echo $fu->imprimir_cadena_utf8($rowsmenu['archivo']);?></td> 
						<td><?php echo $fu->imprimir_cadena_utf8($rowsmenu['ubicacion_archivo']);?></td>
						<td><?php echo $fu->imprimir_cadena_utf8($rowsmenu['nivel']);?></td> 
						<td><?php echo $fu->imprimir_cadena_utf8($rowsmenu['est']);?></td> 
						<td>
							
							
							<?php
								//SCRIPT PARA CONSTRUIR UN BOTON
								$bt->titulo = "";
								$bt->icon = "far fa-edit";
								$bt->funcion = "aparecermodulos('administrador/modulos/fa_menu.php?id=".$rowsmenu['idmodulos_menu']."&idmenumodulo=".$idmenu."','main');";
								$bt->estilos = "";
								$bt->permiso = $permisos;
								$bt->tipo = 2;

								$bt->armar_boton();
							?>
							
						</td> 
					</tr>
					<?php
							}while($rowsmenu=$db->fetch_assoc($respmenu));
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>