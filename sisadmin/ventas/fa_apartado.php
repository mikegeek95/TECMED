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
   require_once("../clases/class.Fechas.php");
   require_once("../clases/class.Tallas.php");

   $db = new MySQL();
   $carrito = new ShoppingCar(); 
   $ta = new Tallas();
   $f = new Fechas(); 
   
	$ta->db = $db;

   $idsucursales = $_SESSION['se_sas_Sucursal'];

	$fecha_fin = $f->diaultimodelsiguientemes();

	$result_tallas = $ta->TallasActivas();
	$result_tallas_row = $db->fetch_assoc($result_tallas);
	$result_tallas_num = $db->num_rows($result_tallas);

?>

<script type="text/javascript" src="js/fn_PuntodeVenta.js"></script>
	 
 <script>    
	 
	 jQuery('#f_fin').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
	
  </script>

<div id="ModalSecundaria" class="ventana">
<div id="Close" style="text-align: right">
      <img src="images/004.png" width="16" height="16" onClick="$('#ModalSecundaria').css('display','none'); $('#contenido_modal_dos').html('');" style="cursor:pointer">
</div>

    <div id="contenido_modal_dos" >
   
    </div>

</div>



<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">GENERAR APARTADO</h5>
		<button type="button" onClick="aparecermodulos('ventas/vi_apartados2.php','main');" class="btn btn-info" style="float: right;">VER APARTADO</button>
		<div style="clear: both;"></div>
	</div>
</div>

<!--<form id="alta_categorias" name="alta_categorias" method="post" action="">-->

<div class="row">
	<div class="col-md-6">
		
		<div class="card mb-3">
			<div class="card-header">
				<h5 class="card-title" style="float: left; margin-top: 5px;">CLIENTES</h5>
				<button type="button" onClick="L_Clientes_apartado();" class="btn btn-info" style="float: right;">CLIENTES</button>
				<div style="clear: both;"></div>
			</div>
			
			<div class="card-body">
				<div class="form-group">
					 <label>CLIENTES</label>
					 <input name="v_nombre_cliente" type="text" id="v_nombre_cliente" placeholder="Jose Luis Gomez Aguiar" class="form-control" title="Campo Nombre de la Categor&iacute;a" onkeypress="bloquearMas(event.keyCode);" value="Venta General" readonly />
					 <input name="v_idcliente" type="hidden" id="v_idcliente" value="0" />
				</div>

				<div class="form-group">
					 <label>ABONO</label>
					<input type="text" id="abono" name="abono" title="Campo Abono" class="form-control" />
				</div>

				<div class="form-group">
					 <label>FECHA FIN</label>
					<input type="text" id="f_fin" name="f_fin" title="Campo F. Fin" value="<?php echo $fecha_fin; ?>" class="form-control" />
				</div>

			</div>
		</div>
	</div>
	

	<div class="col-md-6">
		
		<div class="card mb-3">
			<div class="card-header">
				<h5 class="card-title" style="float: left; margin-top: 5px;">AGREGA PRODUCTOS</h5>
				<button type="button" onClick="L_Productos_apartado();" class="btn btn-info" style="float: right;">PRODUCTOS</button>
				<div style="clear: both;"></div>
			</div>
			
			<div class="card-body">
				<div class="form-group">
					<label>TALLA</label>
					<select name="tallas" id="tallas" class="form-control">
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
					<input type="text" name="v_idproducto" id="v_idproducto" class="form-control" onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); addproductoApartado()"/>
					<input name="v_cantidad" type="hidden" id="v_cantidad" value="1" />
				</div>					
			</div>
			
		</div>
	</div>

	<div class="col-md-12">			
		<div class="card">
			<div class="card-body" style="border-bottom: 1px solid #eaeaea; margin-bottom: 15px;">
				<h4 class="card-title" style="float: left; line-height: 30px; margin: 0;">DETALLES</h4>
			</div>

			<div class="card-body">
				<div id="d_productos_shoping" >
				 <?php 
					$carrito->verCarritoApartado('0');
				 ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="card">
			<div class="card-body">	
				<input name="v_sucursal" type="hidden" id="v_sucursal" value="<?php echo $idsucursales;  ?>" />
				<button type="button" onClick="G_Apartado();" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>Generar Apartado</button>					
			</div>
		</div>
	</div>

</div>
<!--</form>-->