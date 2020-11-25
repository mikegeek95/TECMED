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
	 require_once("../../clases/class.Categoria_Descuento.php");
	require_once("../../clases/class.Botones.php");
	require_once("../../clases/class.Funciones.php");
	 
	 $db = new MySQL();
	 $fn = new Funciones(); 
	 $cd = new categoria_descuento();
	$bt = new Botones_permisos();
	$f= new Funciones();
	 
	 $cd->db = $db;
	 
	 $result_categorias = $cd->todasCategoriasPrecio();
	 $result_categorias_row = $db->fetch_assoc($result_categorias);
	 
	 
	 $result_productos = $db->consulta("SELECT * FROM productos WHERE estatus = '1' ");
	 $result_productos_num = $db->num_rows($result_productos);
	 $result_productos_row = $db->fetch_assoc($result_productos);

if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

 
 ?>

    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_modulos').dataTable( {		
		   "ordering": false,	
		   "lengthChange": true,
		   "pageLength": 100,						
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
		   "sScrollX": "100%",
		   "sScrollXInner": "100%",
		   "bScrollCollapse": true,



	});				
</script>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">LISTA DE PRODUCTOS</h5>
		<button data-toggle="modal" data-target="#buscar-medicamento"  class="btn btn-outline-primary"  style="margin-top: 5px; float:right;" >  <i class="fas fa-sliders-h"></i>  BUSCAR</button>
		
		<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "Nuevo Producto";
										$bt->data_toggle='data-toggle="modal"';
										$bt->data_target='data-target="#modal-forms"';
										$bt->icon = "fas fa-plus";
										$bt->funcion = "AbrirModalGeneral2('ModalPrincipal','900','560','productos/productos/fa_productos.php?idmenumodulo=$idmenu')";
										$bt->estilos = "float:right;margin-right: 10px; margin-top: 6px;";
										$bt->permiso = $permisos;
										$bt->tipo = 1;

										$bt->armar_boton();
									?>
		
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div  id="li_productos" class="tab_container"></div>
	</div>
	
	<div class="card-footer text-muted">
		
	</div>
</div>






			<div class="modal fade" id="buscar-medicamento" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
		  		<div class="modal-header">
					<h5 class="modal-title m-0 font-weight-bold text-primary" id="titulo-buscar-paciente">FILTRO DE B&Uacute;SQUEDA DE PRODUCTO</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  			<span aria-hidden="true">&times;</span>
					</button>
		  		</div>
		  
				<div class="modal-body" id="contenedor-buscar-paciente">
					<form action="" name="filtro" id="filtro">
			<div class="row">
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>C&oacute;digo:</label>
					<input name="v_codigo" type="text" id="v_codigo" class="form-control"  title="Codigo del producto" size="5" />
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>C&oacute;digo Proveedor:</label>
					<input name="v_cod_proveedor" type="text" id="v_cod_proveedor"  class="form-control"  title="Codigo del proveedor" size="5"  />
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>Nombre:</label>
					<input name="v_nombre" type="text" id="v_nombre"  class="form-control"  title="Debe de contener un Nombre" size="5"  />
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>Descripci&oacute;n:</label>
					<input name="v_descripcion" type="text" id="v_descripcion"  class="form-control"  title="Debe de contener una descripcion" size="5" />
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>Precio:</label>
					<input name="v_precio" type="text" id="v_precio"  class="form-control"  title="Debe contener un numero precio" size="5" />
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>Estatus:</label>
					<select name="estatus" id="estatus" class="form-control" >
      					<option value="0,1">Ambos</option>
      					<option value="0">Desactivado</option>
      					<option value="1">Activo</option>
    				</select>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group m-t-20">
					<label>Cat. Precio:</label>
					<select name="v_existencia" id="v_existencia" class="form-control">
					  <option value="0">Todos</option>
					  <?php
					  do
					  { 
					  ?>
					  <option value="<?php echo $result_categorias_row['idcategoria_precio']; ?>"><?php echo $result_categorias_row['nombre']; ?></option>
					  <?php
					  }while($result_categorias_row = $db->fetch_assoc($result_categorias));
					  ?>
					</select>
				</div>
			</div>
			
			
		</div>
		</form>
		 	 	</div>
				
		  		<div class="modal-footer">
					<button type="button" onClick="var resp=MM_validateForm('v_precio','','isNum'); if(resp==1){ b_productos('li_productos','<?php echo ($idmenu);?>');}" class="btn btn-outline-primary" style="float: right;" >  <i class="fas fa-search"></i>  BUSCAR</button>
					<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
		  		</div>
			</div>
	  	</div>
	</div>

<script>
b_productos('li_productos','<?php echo ($idmenu);?>');
</script>