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
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.ShoppingCar.php");
require_once("../../clases/class.Tallas.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");


$db = new MySQL();
$carrito = new ShoppingCar();
$suc = new Sucursales();
$ta = new Tallas();
$bt = new Botones_permisos();
$f = new Funciones();

$suc->db = $db;
$ta->db = $db;

$sql_proveedores = "SELECT * FROM proveedores";
$result_proveedores = $db->consulta($sql_proveedores);
$result_proveedores_row = $db->fetch_assoc($result_proveedores);
$result_proveedores_row_num = $db->num_rows($result_proveedores);


$tipo = $_SESSION['se_sas_Tipo'];


//Validamos que sea superUsuario
if($tipo == 0){
	//Puede hacer movimientos de todas las sucursales
	$result_sucursal = $suc->todasSucursales();
	$result_sucursal_row = $db->fetch_assoc($result_sucursal);
	
}else{
	//solo hace movimientos para su sucursal
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	
	//Obtenemos los datos de la sucursal
	$suc->idsucursales = $idsucursales;
	$result_sucursal = $suc->buscar_sucursal();
	$result_sucursal_row = $db->fetch_assoc($result_sucursal);	
}
	 

$result_tallas = $ta->TallasActivas();
$result_tallas_num = $db->num_rows($result_tallas);
$result_tallas_row = $db->fetch_assoc($result_tallas);


if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/


 ?>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">DATOS GENERALES DE ENTRADA</h5>
		<button type="button" onClick="aparecermodulos('productos/entradas/li_entradas.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="far fa-caret-square-right"></i> VER ENTRADAS</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
    				<label>Sucursal:</label>
    				<select class="form-control" id="sucursal" name="sucursal">
						<?php
						do
						{ 
						?>
							<option value="<?php echo $result_sucursal_row['idsucursales']; ?>"><?php echo $f->imprimir_cadena_utf8($result_sucursal_row['sucursal']); ?></option>
						<?php
						}while($result_sucursal_row = $db->fetch_assoc($result_sucursal));
						?>
					</select>
  				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
    				<label>Fecha de ingreso:</label>
    				<input type="text" name="v_f_ingreso" id="v_f_ingreso"  title="La fecha de Ingreso " class="form-control"   />
  				</div>
			</div>
			
					
			<div class="col-md-12">
				<div class="form-group">
    				<label>Descripci&oacute;n:</label>
    				<textarea name="v_descripcion" rows="5" id="v_descripcion" class="form-control"></textarea>
  				</div>
			</div>
		</div>
  	</div>
</div>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style=" margin-top: 5px;">AGREGAR PRODUCTOS</h5>
	</div>
  	<div class="card-body">
		<div class="row">
			<div class="col-md-3">
				<label>C&oacute;digo:</label>
				<div class="input-group ">
					
							
							<input onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); if(event.keyCode==13){ resp = MM_validateForm('v_codigo','','R','v_cantidad','','R'); if(resp == 1){AgregarCestaEntradaEnter(event.keycode);}}" onChange="combotallasvalor();" class="form-control" type="text" name="v_codigo" id="v_codigo" title="Codigo del Producto"   /> 
						
					
					<div class="input-group-prepend">
						
						<button data-toggle="modal" data-target="#modal-forms" class="btn btn-outline-info" style=" border-radius: 0px 2px 2px 0;" type="button" onclick="vi_productos('productos/entradas/colocar_producto.php','contenedor-modal-forms')"  id="btn_buscar" name="btn_buscar" title="BUSCAR">
							<i class="fas fa-pills"></i>
						</button>
					</div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group" id="contenedor_combo_tallas">
					<label>Presentaci&oacute;n:</label>
					<select name="talla" id="talla" class="form-control">
						
						<option value="">SELECCIONA UN PRODUCTO</option>
						
					</select>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Cantidad:</label>
					<input onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); if(event.keyCode==13){ resp=MM_validateForm('v_codigo','','R','v_cantidad','','R'); if(resp == 1){AgregarCestaEntradaEnter(event.keycode);}}" class="form-control" type="text" name="v_cantidad" id="v_cantidad" title="Cantidad de Producto"  />
				</div>
			</div>
			
			<div class="col-md-3">
               
				
						<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "AGREGAR";
										$bt->icon = "";
										$bt->funcion = "var resp=MM_validateForm('v_codigo','','R','v_cantidad','','R isNum'); if(resp==1 ){    AgregarCestaEntrada();  } ";
										$bt->estilos = "margin-top: 28px;";
										$bt->permiso = $permisos;
										$bt->tipo = 1;

										$bt->armar_boton();
									?>
				
			</div>
		</div>
  	</div>
</div>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">DESCRIPCI&Oacute;N DE ENTRADA</h5>
		
		
								<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "ELIMINAR PRODUCTOS";
										$bt->icon = "far fa-trash-alt";
										$bt->funcion = "eliminarTodoCarrito('itemsEnCestaEntrada','descripcion_carrito');";
										$bt->estilos = "float: right;";
										$bt->permiso = $permisos;
										$bt->tipo = 3;

										$bt->armar_boton();
									?>
		

		<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "GUARDAR ENTRADA";
										$bt->icon = "far fa-save";
										$bt->funcion = "var resp=MM_validateForm('v_f_ingreso','','R','tipo_entrada_compra','','RisNum','tipo_entrada_dev','','RisNum'); if(resp==1 ){    IngresarProductoInventario();  }";
										$bt->estilos = "float: right; margin-right: 5px;";
										$bt->permiso = $permisos;
										$bt->tipo = 5;

										$bt->armar_boton();
									?>
		
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div id="descripcion_carrito" class="tab_content" style=" overflow:auto;" >
				<?php
					$carrito->verCarritoEntrada();		
				?>	
				</div>
			</div>
		</div>
  	</div>
</div>

<!--<div class="card">
	<div class="card-body" style="text-align: right;">
		<input type="submit" class="btn btn-success" value="GUARDAR EN INVENTARIO" class="alt_btn" onclick=" var resp=MM_validateForm('v_f_ingreso','','R','tipo_entrada_compra','','RisNum','tipo_entrada_dev','','RisNum'); if(resp==1){    IngresarProductoInventario();  }">
	</div>
</div>-->


<script>
	jQuery('#v_f_ingreso').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
	
			function  combotallasvalor()
	{
		var nombre = $("#v_codigo").val();
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrartodocarrito salida"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/vi_combo_tallas.php',					  
					  data:'producto='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#contenedor_combo_tallas').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#contenedor_combo_tallas").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}

	

</script>