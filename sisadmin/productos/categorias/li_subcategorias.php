<?php


//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];
    
//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categorias.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");

//Declaramos los objetos de clase
$db = new MySQL();
$gu = new Categoria();
$fe = new Fechas();
$fu = new Funciones();
$bt = new Botones_permisos();
//Enviamos el objeto de la conexión a las clases que lo requieren.
$gu->db = $db;

//Recibimos parametros enviados por GET
$idcategoria = $_GET['id'];

$gu->id_categoria = $idcategoria;

$result = $gu->obtenersubcategorias($gu->id_categoria);
$result_num = $db->num_rows($result);
$result_row = $db->fetch_assoc($result);




$t_estatus = array('DESACITVADO','ACTIVADO');


//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



?>

<script type="text/javascript">
		$('#titulo-modal-forms').html("SUBCATEGOR&IacuteAS DE LA CATEGOR&IacuteA # <?php echo $idcategoria; ?>");
</script>
<div class=" card">


	

	<div class="card-header col-md-12">
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nueva Subcategor&iacute;a";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('productos/categorias/fa_subcategorias.php?idmenumodulo=$idmenu&id=$idcategoria','contenedor-modal-forms');";
			$bt->estilos = "float: right;";
			$bt->permiso = $permisos;
			$bt->tipo = 1;
		
			$bt->armar_boton();
		?>
		<div style="clear: both;"></div>
	</div>


<div class="card-body row">
	<div class="col-md-12">
		<table class="table table-bordered " id="guias_pedidos" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
					<tr>
					<th align="center" style="text-align: center;">ID</th> 
					<th align="center" style="text-align: center;">NOMBRE</th> 
					<th align="center" style="text-align: center;">DESCRIPCION</th>
					
					<th align="center" style="text-align: center;">ESTATUS</th>
					<th align="center" style="text-align: center;"><i class="mdi mdi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($result_num != 0){
					do
					{
				?>	
						<tr>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['idsubcategoria']); ?></td>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['nombre']); ?></td>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['descripcion']); ?></td>
							
							<td align="center"><?php echo $t_estatus[$result_row['estatus']]; ?></td>
							<td>
								
								
								<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('productos/categorias/fa_subcategorias.php?subcategoria=".$result_row['idsubcategoria']."&idmenumodulo=$idmenu&id=$idcategoria','contenedor-modal-forms')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
								
								
								
								<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos2('".$result_row['idsubcategoria']."','idsubcategoria','subcategoria','n','productos/categorias/li_subcategorias.php','contenedor-modal-forms','".$idmenu.'&id='.$idcategoria."')";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
							</td>
						</tr>
				<?php
					}while($result_row = $db->fetch_assoc($result));
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</div>


<script type="text/javascript" charset="utf-8">
var oTable = $('#guias_pedidos').dataTable( {		
"pageLength": 5,	
  "oLanguage": {
				"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
				"sZeroRecords": "NO EXISTEN CATEGORIAS EN LA BASE DE DATOS",
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