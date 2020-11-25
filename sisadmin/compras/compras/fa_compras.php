<?php
     //header("Content-Type: text/text; charset=ISO-8859-1");
	 
     require_once("../../clases/conexcion.php");
	 require_once("../../clases/class.ShoppingCar.php");
	require_once("../../clases/class.Funciones.php");

$idmenu=$_GET['idmenumodulo'];

	 $db = new MySQL();
	 $carrito = new ShoppingCar();
	$f= new Funciones();

	 
	 $sql_proveedores = "SELECT * FROM proveedores";
	 $result_proveedores = $db->consulta($sql_proveedores);
	 $result_proveedores_row = $db->fetch_assoc($result_proveedores);
	 $result_proveedores_row_num = $db->num_rows($result_proveedores);
	 
	

 ?>
	
<form id="alta_categorias" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;">DATOS DE COMPRA</h5>

				
					<button type="button" onClick="aparecermodulos('compras/compras/vi_compras.php?idmenumodulo=<?php echo $idmenu;?>','main');" class="btn btn-outline-primary" style="float: right;"><i class="fas fa-undo"></i> Ver Compras</button>
					
				
			</div>
			<div class="card-body">
				<div class="col-12 row">
				<div class="col-md-6">
			<div class="">
				<label>Prioridad:</label>
				<select id="prioridad" class="form-control" name="prioridad">
					<option value="0">Normal</option>
					<option value="1">Urgente</option>
					<option value="2">Alta</option>
				</select>
			</div>
				</div>
				<div class="col-md-6">
					<label>Sucursal:</label>
				<select id="sucursal" class="form-control" name="sucursal">
					<?php
						$sql="select * from sucursales";
						$suc=$db->consulta($sql);
						$suc_row=$db->fetch_assoc($suc);
						do{
					?>
					<option value="<?php echo ($suc_row['idsucursales']);?>"><?php echo $f->imprimir_cadena_utf8($suc_row['sucursal']);?></option>
					<?php }while($suc_row=$db->fetch_assoc($suc)); ?>
				</select>
					</div>
				</div>
				<br>
			<div class="form-group m-t-20">
				<label>Descripci&oacute;n:</label>
				<textarea name="v_descripcion" rows="5" id="v_descripcion" class="form-control"></textarea>
			</div>
		</div>
	</div>
	<br>
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;">AGREGAR COMPRA</h5>
		</div>
			<div class="card-body">
			<div class="row">

				<div class="col-md-4">
				<label>C&oacute;digo:</label>
				<div class="input-group ">
					
							
							<input onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); if(event.keyCode==13){ resp = MM_validateForm('v_codigo','','R','v_cantidad','','R'); if(resp == 1){AgregarCestaEntradaEnter(event.keycode);}}" onChange="combotallasvalor();" class="form-control" type="text" name="v_codigo" id="v_codigo" title="Codigo del Producto"   /> 
						
					
					<div class="input-group-prepend">
						
						<button data-toggle="modal" data-target="#modal-forms" class="btn btn-outline-info" style=" border-radius: 0px 2px 2px 0;" type="button" onclick="vi_productos('compras/compras/vi_productos.php','contenedor-modal-forms')"  id="btn_buscar" name="btn_buscar" title="BUSCAR">
							<i class="fas fa-pills"></i>
						</button>
					</div>
				</div>
			</div>

			

				<div class="col-md-4">
					<div class="form-group">
						<label>Cantidad:</label>
						<input type="text" class="form-control" name="v_cantidad" id="v_cantidad" title="Cantidad del Producto"  placeholder="0"  />
					</div>
				</div>

				<div class="col-md-4">
					 <input name="btn_agregar" type="button" id="btn_agregar" value="Agregar Producto" onclick="var resp=MM_validateForm('v_codigo','','R','v_cantidad','','RisNum'); if(resp==1){    AgregarCestaCompras();  } " style="margin-top: 28px;" class="btn btn-outline-primary" />
					
				</div>
			</div>
		</div>
	</div>
	<br>

</form>
  
 <div class="card">
	<div class="card-header" >
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;">DESCRIPCION DE LA COMPRA</h5>

		<button onclick="eliminarTodoCarritoCompras('itemsEnCestaCompras','descripcion_carrito');" class="btn btn-outline-danger alt_btn" style="float: right;"><i class="far fa-trash-alt"></i> Eliminar Productos</button>

		<button type="button" onClick=" var resp=MM_validateForm('tipo_entrada_compra','','RisNum','tipo_entrada_dev','','RisNum'); if(resp==1){    IngresarCompras('compras/compras/vi_compras.php?idmenumodulo=<?php echo $idmenu;?>','main');  }  " class="btn btn-outline-success alt_btn" style="float: right; margin-right: 5px;" ><i class="far fa-save"></i> Guardar Orden de Compra</button>

	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div  id="descripcion_carrito" class="tab_content table-responsive" style="height:350px; overflow:auto;" >
				<?php
				  $carrito->verCarritoCompras();		
				?>
				</div>
			</div>
		</div>
	</div>
</div>               