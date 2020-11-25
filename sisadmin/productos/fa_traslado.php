<?php
    require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   require_once("../clases/class.Sucursales.php");
   require_once("../clases/class.Tallas.php");
   

   $db = new MySQL();
   $carrito = new ShoppingCar();
   $ta = new Tallas();
   $su = new Sucursales();  
   
   $su->db = $db;
   $ta->db = $db;
   
   $idsucursales = $_SESSION['se_sas_Sucursal'];
   
   
   $result_sucursales = $su->todasSucursales();
   $result_sucursales_row = $db->fetch_assoc($result_sucursales);
   $result_sucursales_num = $db->num_rows($result_sucursales);

   $result_tallas = $ta->TallasActivas();
   $result_tallas_row = $db->fetch_assoc($result_tallas);
   $result_tallas_num = $db->num_rows($result_tallas);


?>

<script type="text/javascript" src="js/fn_PuntodeVenta.js"></script>

	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">GENERAR ORD. TRASPASO</h5>
			<button type="button" onClick="aparecermodulos('productos/vi_traslado.php','main');" class="btn btn-info" style="float: right;">VER TRASPASOS</button>
			<div style="clear: both;"></div>
		</div>
	</div>

	
	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">SUCURSALES</h5>
					<!--<button onclick="L_Sucursales();" class="btn" style="float: right;">Sucursales</button>-->
				</div>

				<div class="card-body">
					<?php
						//Buscamos la sucursal en la que esta el gerente que realizará el traspaso
						$su->idsucursales = $idsucursales;
						$result_sucursal = $su->buscarSucursal();
						$result_sucursal_row = $db->fetch_assoc($result_sucursal);

						$sucursal = utf8_encode($result_sucursal_row['sucursal']);
					?>

					<div class="form-group">
						 <label>SUCURSALES(DE)</label>
						<input name="v_sucursal" type="text" id="v_sucursal" placeholder="Matriz" class="form-control" title="Sucursal" onkeypress="bloquearMas(event.keyCode);" value="<?php echo $sucursal; ?>"  readonly />
						<input name="v_idsucursal" type="hidden" id="v_idsucursal" value="<?php echo $idsucursales; ?>" />
					</div>

					<div class="form-group">
						<label>SUCURSAL(PARA)</label>
						<select id="para" class="form-control">
							<?php
							do
							{
								if($idsucursales != $result_sucursales_row['idsucursales']){
							?>
							<option value="<?php echo $result_sucursales_row['idsucursales'] ?>"><?php echo $result_sucursales_row['sucursal']; ?></option>
							<?php
								}
							}while($result_sucursales_row = $db->fetch_assoc($result_sucursales));
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Observaciones</label>
					   <textarea id="observaciones" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">AGREGA PRODUCTOS</h5>
					<button type="button" onClick="L_ProductosTraspaso();" class="btn btn-info" style="float: right;">PRODUCTOS</button>
					<div style="clear: both;"></div>
				</div>

				<div class="card-body">
					<div class="form-group">
						<label>TALLA</label>
						<select name="talla" id="talla" class="form-control">
							<?php
							do
							{
							?>
							<option value="<?php echo $result_tallas_row['idtallas']; ?>"><?php echo utf8_encode($result_tallas_row['talla']); ?></option>
							<?php
							}while($result_tallas_row = $db->fetch_assoc($result_tallas));
							?>
						</select>
					</div>
						
					<div class="form-group">
						 <label>ID PRODUCTO</label>
						<input type="text" name="v_idproducto" id="v_idproducto" class="form-control" onKeyDown="bloquear_enie(event.keyCode);"  onkeypress="bloquear_enie(event.keyCode); if(event.keyCode === 13){addproductoTraspaso();}"/>
					</div>
					
					<div class="form-group">
						<label>CANTIDAD</label>
						<input name="v_cantidad" type="text" id="v_cantidad" class="form-control" value="1"  onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); addproductoTraspaso()"/>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">		
			
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">DETALLES</h5>
				</div>

				<div class="card-body">
					<div id="d_productos_shoping" >
					 <?php 
						$carrito->verCarritoTraspaso();
					 ?>
					</div>
				</div>
				
				<div class="card-footer text-muted">
					<input name="v_sucursal" type="hidden" id="v_sucursal" value="<?php echo $idsucursales;  ?>" />
					<button type="button" onClick="GuardarTraspaso('alta_etiquetas','productos/ga_traslado.php','productos/vi_traslado.php','main');" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>GENERAR TRASPASO</button>
				</div>
			</div>
		</div>
	</div>