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
	 
	 $sql_categoria = "SELECT * FROM categorias";
	 $result_categoria = $db->consulta($sql_categoria);
	 $result_categoria_row = $db->fetch_assoc($result_categoria);
	 $result_categoria_row_num = $db->num_rows($result_categoria);
 

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
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


<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-b-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE CATEGOR&Iacute;AS</h5>
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nueva Categor&iacute;a";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('productos/categorias/fa_categorias.php?idmenumodulo=$idmenu','main');";
			$bt->estilos = "float: right;";
			$bt->permiso = $permisos;
			$bt->tipo = 1;
		
			$bt->armar_boton();
		?>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered " id="d_modulos" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
					<tr>
						<th>ID CATEGOR&Iacute;A</th> 
						<th>NOMBRE</th>
						<th>DESCRIPCI&Oacute;N</th>
						<!--<th>DEPENDE</th>-->
						<th>NIVEL</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
<?php
				if($result_categoria_row_num != 0){
            	do
				{     
					    
?>
            
					<tr> 
   						<td style="text-align:center"><?php echo $f->imprimir_cadena_utf8($result_categoria_row['idcategoria']); ?></td>  
                   		<td><?php echo $f->imprimir_cadena_utf8($result_categoria_row['nombre']); ?></td>
                 
                   		<td><?php echo $f->imprimir_cadena_utf8($result_categoria_row['descripcion']); ?></td>
                 
                   	
    					<td><?php echo $f->imprimir_cadena_utf8($result_categoria_row['nivel']); ?></td>
                		<td align="center">
							
							
							<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('productos/categorias/fa_categorias.php?id=".$result_categoria_row['idcategoria']."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
							
							<button data-toggle="modal" data-target="#modal-forms" type="button" onClick="AbrirModalGeneral2('ModalPrincipal','900','560','productos/categorias/li_subcategorias.php?id=<?php echo $result_categoria_row['idcategoria'];?>&idmenumodulo=<?php echo $idmenu ?>');" title="AGREGAR SUBCATEGORIAS" class="btn btn-outline-primary"><i class="fas fa-layer-group"></i></button>
							
							
							<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_categoria_row['idcategoria']."','idcategoria','categorias','n','productos/categorias/vi_categorias.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
						
							
                    	</td> 
					</tr>
<?php 
			   	}while($result_categoria_row = $db->fetch_assoc($result_categoria));
				}
?>
				</tbody>
			</table>
		</div>
  	</div>
</div>