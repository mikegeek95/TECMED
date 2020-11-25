<!--<link rel="stylesheet" type="text/css" href="../css/layout.css">-->

<?php
   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   require_once("../clases/class.Clientes.php");
   require_once("../clases/class.Devoluciones.php");
   require_once("../clases/class.Tallas.php");

   $db = new MySQL();
   $carrito = new ShoppingCar();  
   $cli = new Clientes();
   $dev = new Devoluciones();
   $ta = new Tallas();
   
   $cli->db = $db;
   $dev->db = $db;
   $ta->db = $db;
   
   $row_clientes = $cli->ObtenerInformacionClientes();
   $num_clientes = count($row_clientes);

	$result_tallas = $ta->TallasActivas();
	$result_tallas_num = $db->num_rows($result_tallas);
	$result_tallas_row = $db->fetch_assoc($result_tallas);

?>

<script type="text/javascript" src="js/fn_Consignacion.js"></script>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">DEVOLUCIONES DE PRODUCTO</h5>
		<button type="button" onClick="aparecermodulos('ventas/vi_devolucion.php','main');" class="btn btn-info" style="float: right;">VER DEVOLUCIONES</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<div class="form-group">
		 	<label>NO. DE VENTA</label>
			<input type="text" name="v_idorden" id="v_idorden" style="width:150px; margin-right: 15px;"  title="No. Venta " class="form-control" /> 
			<div style="clear: both;"></div>
		</div>
  	</div>
	
	<div class="card-footer text-muted" style="text-align: right;">
		<div style="float:right;" class="btn btn-info" onClick="var resp=MM_validateForm('v_idorden','','RisNum'); if(resp==1){ BuscarVenta();}">CARGAR VENTA</div>
		<div style="clear: both;"></div>
	</div>
</div>
	
<div class="row">
	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-header">
				<h5 class="card-title" style="float: left; margin-top: 5px;">VENTA <input type="hidden" value="0" id="v_idventa"></h5>
			</div>
			<div class="card-body" style="min-height: 300px;">
				<div id="d_venta" class="tab_content" style="overflow: auto;">            
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		
		<div class="card mb-3">
			<div class="card-header">
				<h5 class="card-title" style="float: left; margin-top: 5px;">DEVOLUCI&Oacute;N</h5>
			</div>
			<div class="card-body" style="min-height: 300px;">
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
					 <label>INGRESA COD. PRODUCTO </label>
					<input type="text" id="v_idproducto" onKeyDown="bloquear_enie(event.keyCode);" class="form-control" onkeypress="bloquear_enie(event.keyCode); AddDevolucion()">
				</div>
				
				<div style="overflow: auto;">
					<table class="table" cellspacing="0"> 
						<tbody id="d_devoluciones" > 
							<tr> 
								<!--<td>Producto devolucion</td> -->
								<?php
								$dev->VerDevoluciones(1); 
								?>
							</tr> 
						</tbody> 
					</table>
				</div>
			</div>
		</div>
	</div>
</div>