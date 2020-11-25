<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once ("../clases/conexcion.php");
require_once ("../clases/class.Etiquetas.php");
require_once("../clases/class.ShoppingCar.php");
require_once ("../clases/class.Sesion.php");




try
{
	
$db = new MySQL ();
$etiquetas = new Etiquetas ();
$carrito = new ShoppingCar ();
$sesion = new Sesion ();


if ($sesion->obtenerSesion('contador')>=1)
{
$sesion->terminarSesion('contador');
$sesion->crearSesion('contador',0);
}
$sesion->crearSesion('contador',0);



$etiquetas->db = $db ;

$etiquetas->idetiquetas = $_GET['id'];

$etiquetas->obtenerDatosEtiqueta();

$result_etiquetas_row = $etiquetas->obtenerDatosEtiqueta();



?>  

<form id="alta_etiquetas" method="post" action="">
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">AGREGAR LISTA</h5>
			<button type="button" onClick="aparecermodulos('productos/vi_etiquetas.php','main');" class="btn btn-info" style="float: right;">VER ETIQUETAS</button>
			<div style="clear: both;"></div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group m-t-20">
						<label>ID LISTA :</label>
						<input type="text" class="form-control" disabled value="<?php echo $result_etiquetas_row['idetiquetas']?>" />
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group m-t-20">
						<label>FECHA :</label>
						<input type="text" class="form-control" disabled value="<?php $explode = explode(' ',$result_etiquetas_row['fecha']); echo $explode[0]; ?>" />
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="row form-group">
					<div class="col-md-11 form-group padding-right: 0;">
						<label>C&oacute;digo :</label>
						<input type="text"  name="v_codigo" onblur="validarProductoNoexiste(this.value,'btn_agregar')" onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode);"  onchange="combotallasvaloretiquetas();" id="v_codigo" title="Codigo del Producto" class="form-control"  /> 
					</div>
					<div class="col-md-1" style="padding-left: 0;">
						<button class="btn btn-info" style="margin-top: 28px; border-radius: 0px 2px 2px 0;" type="button" onclick="vi_productos('productos/colocar_producto2.php','contenedor-productos-modal')"  id="btn_buscar" name="btn_buscar" title="BUSCAR">
							<i class="mdi mdi-account-search"></i>
						</button>
					</div>
					</div>
					<div class="form-group m-t-20" id="contenedor_combo_tallas_etiquetas">
						
						<div class="row">
						<div class="col-6">
							<label>Unidad:</label>
					<input type="text" name="v_talla" id="v_talla" title="Cantidad del Producto"  placeholder="Unidad"  class="form-control" disabled/>
							</div>
							<div class="col-6 ">
								<label>Tallas:</label>
						<select name="talla" id="talla" class="form-control">
						
						<option value="">SELECCIONA UN PRODUCTO</option>
						
					</select>
								</div>
							</div>
					</div>
					<div class="form-group m-t-20">
						<label>Cantidad :</label>
						<input type="text" name="v_cantidad" id="v_cantidad" title="Cantidad del Producto"  placeholder="0"  class="form-control"/>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input type="hidden" value="<?php echo $result_etiquetas_row['idetiquetas']?>" id="id" name="id"  />
			<button type="button" onClick="var resp=MM_validateForm('v_codigo','','R','v_cantidad','','RisNum'); if(resp==1){    AgregarCestaEtiquetas();  } " class="btn btn-info alt_btn" style="float: right;" <?php echo $disabled; ?> id="btn_agregar">AGREGAR</button>			
	  	</div>
	</div>
</form>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">PRODUCTOS</h5>
		<button onclick="eliminarTodoCarritoEtiquetas('itemsEnCestaEtiquetas','descripcion_carrito');" class="btn btn-danger" style="float: right;">ELIMINAR</button>
		<button type="button" onClick=" IngresarEtiquetas('<?php echo $result_etiquetas_row['idetiquetas']?>'); aparecermodulos('productos/lista_etiquetas_productos.php?id=<?php echo $result_etiquetas_row['idetiquetas']?>','lst_producto')   " class="btn btn-success alt_btn" style="float: right; margin-right: 5px;" <?php echo $disabled; ?> id="btn_agregar">GENERAR LISTA</button>
		<div style="clear: both;"></div>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div  id="descripcion_carrito" class="tab_content" style=" overflow:auto;" >
				<?php
					$carrito->verCarritoEtiquetas();		
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style=" margin-top: 5px;">PRODUCTOS A&Ntilde;ADIDOS EN LISTA</h5>
	</div>

	<div class="card-body" id="lst_producto">
		<?php
 			$etiquetas->verProductosEtiquetas();
 		?>
	</div>
</div>

<?php

}
catch (Exception $e)
{
	echo "Error: ".$e;
}
?>

<script>

		function  combotallasvaloretiquetas()
	{
		var nombre = $("#v_codigo").val();
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrartodocarrito salida"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/vi_combo_tallas_et.php',					  
					  data:'producto='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#contenedor_combo_tallas_etiquetas').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#contenedor_combo_tallas_etiquetas").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}
</script>
