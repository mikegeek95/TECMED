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

$query="SELECT usuarios.idusuarios, 
	usuarios.idperfiles, 
	usuarios.nombre, 
	usuarios.paterno, 
	usuarios.materno, 
	usuarios.telefono, 
	usuarios.celular, 
	usuarios.email, 
	usuarios.usuario, 
	usuarios.clave, 
	usuarios.estatus,
	usuarios.tipo,
	usuarios.tipo_usuario,
	IF(usuarios.estatus,'Activo','Inactivo')AS est,
	perfiles.perfil
FROM perfiles INNER JOIN usuarios ON perfiles.idperfiles = usuarios.idperfiles";

$resp=$db->consulta($query);
$rows=$db->fetch_assoc($resp);
$total=$db->num_rows($resp);

$tipo_usuario = array('INTERNO','EXTERNO');




//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



?>

<script type="text/javascript" charset="utf-8">	
	var oTable = $('#zero_config').dataTable( {		

	  "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "No Existen Usuarios en la base de datos",
					"sInfo": "Mostrar 0 a _END_ de _TOTAL_ Registros",
					"sInfoEmpty": "Mostrar 0 a _END_ de _TOTAL_ Registros",
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
		ordering: false



	});	
</script>

<div class="card">
	<div class="card-header">
		<h5 class=" m-b-0 font-weight-bold text-primary" style="float: left;">LISTA DE USUARIOS</h5>
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo Usuario";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('administrador/usuarios/fa_usuarios.php?idmenumodulo=$idmenu','main');";
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
						<th>TIPO</th>
						<th>PERFIL</th> 
						<th>USUARIO</th> 
						<th>NOMBRE</th> 
						<th>CELULAR</th>
						<th>TEL&Eacute;FONO</th> 
						<th>EMAIL</th>
						<th>SUCURSAL</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($total==0)
					{
				 	?>
						<h4 class="alert_warning">No Existen Usuarios en la base de datos</h4>
				 	<?php
					}else{
				  		do
						{
				 	?>
				   			<tr> 
								<td><?php echo $fu->imprimir_cadena_utf8($tipo_usuario[$rows['tipo_usuario']]); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['perfil']); ?></td> 
								<td><?php echo $fu->imprimir_cadena_utf8($rows['usuario']); ?></td> 
								<td><?php echo $fu->imprimir_cadena_utf8($rows['nombre']." ".$rows['paterno']." ".$rows['materno']); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['celular']); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['telefono']); ?></td>
								<td><?php echo $fu->imprimir_cadena_utf8($rows['email']); ?></td>
                    			<td><?php echo $fu->imprimir_cadena_utf8($rows['est']); ?></td> 
								<td style="text-align: center; font-size: 15px;">
									<!--<a href="#" onClick="aparecermodulos('administrador/fa_usuarios.php?id=<?php echo $rows['idusuarios'];?>','main')" title="EDITAR"><i class="far fa-edit"></i></a>-->
									
									<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('administrador/usuarios/fa_usuarios.php?id=".$rows['idusuarios']."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
									
									
									<?php
										$tipo = $rows['tipo'];		  
										if($tipo == 0){  
										}else{
									?>
											<!--<a href="#" onClick="BorrarDatos('<?php echo $rows['idusuarios'];?>','idusuarios','usuarios','n','administrador/vi_usuarios.php','main')" title="BORRAR"><i class="mdi fas fa-trash"></i></a>-->
									
											<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$rows['idusuarios']."','idusuarios','usuarios','n','administrador/usuarios/vi_usuarios.php','main',".$idmenu.")";
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