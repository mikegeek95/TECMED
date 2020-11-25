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
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

$db = new MySQL();
$pag = new Paginas();
$fu = new Funciones();
$bt = new Botones_permisos();

$query="SELECT *,IF(estatus,'Activo','Inactivo')AS est FROM perfiles";
$resp=$db->consulta($query);
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
<div class="card">
	<div class="card-header">
		<h5 class=" m-b-0 font-weight-bold text-primary" style="float: left;">LISTA DE PERFILES</h5>	
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo Perfil";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('administrador/perfiles/fa_perfiles.php?idmenumodulo=$idmenu','main');";
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
						<th>ID PERFIL</th> 
						<th>PERFIL</th> 
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
									<td width="50"><?php echo $rows['idperfiles'];?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['perfil']); ?></td> 
									<td><?php echo $fu->imprimir_cadena_utf8($rows['est']); ?></td> 
									<td>
										<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "far fa-edit";
											$bt->funcion = "aparecermodulos('administrador/perfiles/fa_perfiles.php?id=".$rows['idperfiles']."&idmenumodulo=$idmenu','main');";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 2;

											$bt->armar_boton();
										?>
										
										<!--<a href="#" onClick="aparecermodulos('administrador/fc_perfiles.php?id=<?php echo $rows['idperfiles'];?>','main');" title="EDITAR"><i class="far fa-edit"></i></a>-->
										
										<!--<a href="#" onClick="BorrarDatos('<?php echo $rows['idperfiles'];?>','idperfiles','perfiles','n','administrador/vi_perfiles.php','main')" title="BORRAR"><i class="mdi fas fa-trash"></i></a>-->
										
										<?php
											//SCRIPT PARA CONSTRUIR UN BOTON
											$bt->titulo = "";
											$bt->icon = "fas fa-trash";
											$bt->funcion = "BorrarDatos('".$rows['idperfiles']."','idperfiles','perfiles','n','administrador/perfiles/vi_perfiles.php','main',".$idmenu.");";
											$bt->estilos = "";
											$bt->permiso = $permisos;
											$bt->tipo = 3;

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

<script type="text/javascript" charset="utf-8">	
		var oTable = $('#zero_config').dataTable( {		
		
		  "oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
						"sZeroRecords": "No Existen Perfiles en la base de datos.",
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
</script>