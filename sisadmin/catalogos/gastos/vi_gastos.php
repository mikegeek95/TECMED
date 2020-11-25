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
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Botones.php");


$db = new MySQL();
$fe = new Fechas();
$f = new Funciones();
$bt = new Botones_permisos();

$sqlgastos = "SELECT * FROM gastos_categorias";
$result_gastos= $db->consulta($sqlgastos);
$result_gastos_row = $db->fetch_assoc($result_gastos);
$result_gastos_row_num = $db->num_rows($result_gastos);

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



$t_gasto = array('FIJO','VIATICOS');


?>

<script type="text/javascript" charset="utf-8">

//$(document).ready(function() {

var oTable = $('#zero_config').dataTable( {		

	  "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "NO EXISTEN CONCEPTOS DE GASTOS EN LA BASE DE DATOS",
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



});
//});

</script>

<div class="card">
	<div class="card-header">
		
		<div id="mensajes"></div>
		
		<h5 class="m-b-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE CONCEPTOS DE GASTOS</h5>
		
		
			
			
			<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo Concepto de Gasto";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('catalogos/gastos/fa_gasto.php?idmenumodulo=$idmenu','main');";
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
						<th style="text-align:center">ID GASTO</th> 
				   		<th style="text-align:center">GASTO</th>
				   		<th style="text-align:center">DESCRIPCION</th> 
   				   		<th style="text-align:center">TIPO</th>                   
                   		<th style="text-align:center">ACCIONES</th>
					</tr>
				</thead>
				<tbody>
<?php
					if($result_gastos_row_num != 0)
			 		{
		           		do
			         	{ 
?>
           
			   	<tr>
			   		<td align="center"><?PHP echo $f->imprimir_cadena_utf8($result_gastos_row['idgastos_categorias']); ?></td> 
			     	<td align="center"><?php echo $f->imprimir_cadena_utf8($result_gastos_row['categoria']); ?></td>
			     	<td align="center"><?php echo $f->imprimir_cadena_utf8( $result_gastos_row['descripcion']); ?></td> 
			     	<td align="center"><?php echo  $f->imprimir_cadena_utf8($t_gasto[$result_gastos_row['tipo']]); ?></td> 
   			
   			     	<td align="center">	
						
						
						<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('catalogos/gastos/fa_gasto.php?id=".$result_gastos_row['idgastos_categorias']."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
						
						
						
						<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_gastos_row['idgastos_categorias']."','idgastos_categorias','gastos_categorias','n','catalogos/gastos/vi_gastos.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
						
					</td> 
			   </tr>
<?php
						}while($result_gastos_row = $db->fetch_assoc($result_gastos));
			 		}else{
			  		}
?>	
					</tbody>
				</table>
			</div>
		</div>
	
</div>		