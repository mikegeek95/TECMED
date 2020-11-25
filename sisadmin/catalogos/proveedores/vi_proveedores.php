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
	 
	 $sql_proveedor = "SELECT * FROM proveedores";
	 $result_proveedor = $db->consulta($sql_proveedor);
	 $result_proveedor_row = $db->fetch_assoc($result_proveedor);
	 $result_proveedor_row_num = $db->num_rows($result_proveedor);
	
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

	//$(document).ready(function() {

		var oTable = $('#zero_config').dataTable( {		

			  "oLanguage": {
							"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
							"sZeroRecords": "LO SENTIMOS, NO SE HAN ENCONTRADO REGISTROS.",
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
		} );
		//} );
</script>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE PROVEEDORES</h5>
		
		<?php
			//SCRIPT PARA CONSTRUIR UN BOTON
			$bt->titulo = "Nuevo Proveedor";
			$bt->icon = "fas fa-plus";
			$bt->funcion = "aparecermodulos('catalogos/proveedores/fa_proveedores.php?idmenumodulo=$idmenu','main');";
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
						<th>ID PROVEEDOR</th> 
						<th>NOMBRE</th>
						<th>DIRECCI&Oacute;N</th>
						<th>TEL&Eacute;FONO</th>
						<th>E-MAIL</th>
						<th>CONTACTO</th>
						<th>URL</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($result_proveedor_row_num == 0){
					}else{
            			do
						{
					?>
            
					<tr> 
   				  		<td style="text-align:center"><?php echo $f->imprimir_cadena_utf8($result_proveedor_row['idproveedores']); ?></td>  
					  	<td><?php echo  $f->imprimir_cadena_utf8($result_proveedor_row['nombre']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8( $result_proveedor_row['direccion']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($result_proveedor_row['telefono']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($result_proveedor_row['email']); ?></td>
					  	<td><?php echo $f->imprimir_cadena_utf8($result_proveedor_row['contacto']); ?></td>
                  		<td><?php echo $f->imprimir_cadena_utf8($result_proveedor_row['url']); ?></td>
						<td align="center">
							
							
							<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('catalogos/proveedores/fa_proveedores.php?id=".$result_proveedor_row['idproveedores']."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
							
							<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_proveedor_row['idproveedores']."','idproveedores','proveedores','n','catalogos/proveedores/vi_proveedores.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
						</td> 
					</tr>
					<?php 
					}while($result_proveedor_row = $db->fetch_assoc($result_proveedor));
					}
					?>
				</tbody>
			</table>
		</div>
  	</div>
</div>