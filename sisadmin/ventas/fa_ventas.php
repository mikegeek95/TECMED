<?php
    require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

session_start();
if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   require_once("../clases/class.Tallas.php");

   $db = new MySQL();
   $carrito = new ShoppingCar();
   $ta = new Tallas();

   $ta->db = $db;
   
   $idsucursales = $_SESSION['se_sas_Sucursal'];
   
   //debemos de buscar que una caja sea abierta para poder mostrar este modulo
   //$sql = "SELECT * FROM corte WHERE idsucursales = '$idsucursales' AND estatus = 1";
   //$result_sql = $db->consulta($sql);
   //$result_sql_row = $db->fetch_assoc($result_sql);
   //$result_sql_num = $db->num_rows($result_sql);


	$result_tallas = $ta->TallasActivas();
	$result_tallas_row = $db->fetch_assoc($result_tallas);
	$result_tallas_num = $db->num_rows($result_tallas);


?>

<script type="text/javascript" src="js/fn_PuntodeVenta.js"></script>


<!--<form id="alta_categorias" name="alta_categorias" method="post" action="">-->

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">GENERAR ORD. COMPRA</h5>
		<!--<button type="button" onClick="aparecermodulos('ventas/vi_pedidos.php','main');" class="btn btn-info" style="float: right;">VER PEDIDOS</button>-->
		<div style="clear: both;"></div>
	</div>
</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">CLIENTES</h5>
					<button type="button" onClick="L_Clientes();" class="btn btn-info" style="float: right;">CLIENTES</button>
					<div style="clear: both;"></div>
				</div>

				<div class="card-body">
					<div class="form-group">
						 <label>CLIENTES</label>
						<input name="v_nombre_cliente" class="form-control" type="text" id="v_nombre_cliente" placeholder="Jose Luis Gomez Aguiar" title="Campo Nombre de la Categor&iacute;a" onkeypress="bloquearMas(event.keyCode);" value="Venta General" readonly />
          				<input name="v_idcliente" type="hidden" id="v_idcliente" value="0" />
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">AGREGA PRODUCTOS</h5>
					<button type="button" onClick="vi_productos('productos/colocar_producto4.php','contenedor-productos-modal');" class="btn btn-info" style="float: right;">PRODUCTOS</button>
					<div style="clear: both;"></div>
				</div>

				<div class="card-body">
					<div class="form-group">
						 <label>ID PRODUCTO</label>
						<input type="text" name="v_codigo" id="v_codigo" class="form-control" onKeyDown="bloquear_enie(event.keyCode);" onchange="combotallasvalor_pedidos();" onkeypress="bloquear_enie(event.keyCode); addproducto()"/>
						<!--<input name="v_cantidad" type="hidden" id="v_cantidad" value="1" />-->
					</div>
					<div class="form-group" id="combotallasvalor_pedidos">
						 <label>Unidad:</label>
					<select name="talla" id="talla" class="form-control">
						
						<option value="">SELECCIONA UN PRODUCTO</option>
						
					</select>
					</div>
					
					<div class="form-group">
						 <label>CANTIDAD</label>
						 <div onDblClick="activar_cantidad();">
							 <input type="text" name="v_cantidad" id="v_cantidad" class="form-control"  onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode);"  />
						</div>
					</div>
					<button type="button" onClick="S_Producto2('<?php echo ($_SESSION['se_sas_Sucursal']);?>');" class="btn btn-info" style="float: right;">AGREGAR</button>
					
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
						$carrito->verCarritoPuntodeVenta('0');
					 ?>
					</div>
				</div>
				
				<div class="card-footer text-muted">
					<input name="v_sucursal" type="hidden" id="v_sucursal" value="<?php echo $idsucursales;  ?>" />
					<button type="button" onClick="G_Pedido();" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>GENERAR PEDIDO</button>
				</div>
			</div>
		</div>
	</div>
<!--</form>-->
<script>

			function  combotallasvalor_ventas()
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
						  $('#contenedor_combo_tallas_ventas').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#contenedor_combo_tallas_ventas").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}

	function  combotallasvalor_pedidos()
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
						  $('#combotallasvalor_pedidos').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#combotallasvalor_pedidos").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}
</script>