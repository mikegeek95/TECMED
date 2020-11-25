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
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");
	 
	 $db = new MySQL();
	$bt = new Botones_permisos();
$f= new Funciones();
	 
	 $sql_cliente = "SELECT * FROM clientes";
	// $result_cliente = $db->consulta($sql_cliente);
	 $result_row = $db->fetch_assoc($sql_cliente);
	 $result_row_num = $db->num_rows($sql_cliente);


if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
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
					"sZeroRecords": "Nada Encontrado - Disculpa",
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
});
//});

</script>
  

<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE PACIENTES</h5>
		
		<button data-toggle="modal" data-target="#buscar-paciente"  class="btn btn-outline-primary"  style="margin-top: 5px; float:right;" >  <i class="fas fa-sliders-h"></i>  BUSCAR</button>
		
		<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "Nuevo Paciente";
										$bt->data_toggle='data-toggle="modal"';
										$bt->data_target='data-target="#modal-forms"';
										$bt->icon = "fas fa-plus";
										$bt->funcion = "AbrirModalGeneral2('ModalPrincipal','900','560','catalogos/pacientes/fa_pacientes.php?idmenumodulo=$idmenu')";
										$bt->estilos = "float:right;margin-right: 10px; margin-top: 6px;";
										$bt->permiso = $permisos;
										$bt->tipo = 1;

										$bt->armar_boton();
									?>
		<div style="clear: both;"></div>
	</div>
	<div class="card-body">
		
              <div class="table-responsive">
				  <div id="contenedor-clientes">
                
		</div>
  	</div>
</div>

</div>
  	 



			<div class="modal fade" id="buscar-paciente" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
		  		<div class="modal-header">
					<h5 class="modal-title m-0 font-weight-bold text-primary" id="titulo-buscar-paciente">FILTRO DE B&Uacute;SQUEDA DE PACIENTE</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  			<span aria-hidden="true">&times;</span>
					</button>
		  		</div>
		  
				<div class="modal-body" id="contenedor-buscar-paciente">
					<form action="" name="filtro" id="filtro">
			<div class="row">
				

				<div class="col-md-4">
					<div class="form-group">
						<label>NOMBRE:</label>
						<input class="form-control" type="text" id="v_nombre" name="v_nombre">
					</div>
				</div><div class="col-md-4">
					<div class="form-group">
						<label>PATERNO:</label>
						<input class="form-control" type="text" id="v_paterno" name="v_paterno">
					</div>
				</div><div class="col-md-4">
					<div class="form-group">
						<label>MATERNO:</label>
						<input class="form-control" type="text" id="v_materno" name="v_materno">
					</div>
				</div>
					<div class="col-md-4">
					<div class="form-group">
						<label>EMAIL:</label>
						<input class="form-control" type="text" id="v_email" name="v_email">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>SEXO:</label>
						<select name="v_sexo" id="v_sexo" class="form-control">
							<option value="">Seleccione una opcion</option>
							<option value="H">HOMBRE</option>
							<option value="M">MUJER</option>

						</select>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>ESTATUS:</label>
						<select name="v_estatus" id="v_estatus" class="form-control">
							<option value="">TODOS</option>
							<option value="1">ACTIVOS</option>
							<option value="0">INACTIVOS</option>
						</select>
					</div>
				</div>
			</div>
		</form>
		 	 	</div>
				
		  		<div class="modal-footer">
					<button type="button" onClick="buscarclientes('filtro','<?php echo ($idmenu);?>');" class="btn btn-outline-primary">  <i class="fas fa-search"></i>  BUSCAR</button>
					<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
		  		</div>
			</div>
	  	</div>
	</div>
<script>
buscarclientes('filtro','<?php echo ($idmenu);?>');
</script>