<?php
header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");

//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}
require_once("../clases/conexcion.php");
require_once("../clases/class.Categorias.php");
require_once("../clases/class.Sucursales.php");
require_once("../clases/class.Tallas.php");

//creamos los objeos
  
$db = new MySQL();
$ca = new Categoria();
$suc = new Sucursales();
$ta = new Tallas();

$ca->db=$db;
$suc->db = $db;
$ta->db = $db;

try{	
	
	//hacemols la consulta para las categorias
   
   	$sql_categoria="SELECT * FROM subcategoria WHERE estatus=1";
   	$result_categoria= $db->consulta($sql_categoria);
   	$result_categoria_row= $db->fetch_assoc($result_categoria);
   	$result_categoria_row_num = $db->num_rows($result_categoria);  
	 
	$b_estatus = array("DESACTIVADO","ACTIVADO");
	 
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
		$result_sucursal = $suc->buscarSucursal();
		$result_sucursal_row = $db->fetch_assoc($result_sucursal);
	}
	
	$result_tallas = $ta->TallasActivas();
	$result_tallas_row = $db->fetch_assoc($result_tallas);
?>
    

<script type="text/javascript" charset="utf-8">				
	var oTable = $('#d_modulos').dataTable( {						
		  "oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
						"sZeroRecords": "Nada Encontrado - Disculpa",
						"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
						"sInfoEmpty": "desde 0 a 0 de 0 records",
						"sInfoFiltered": "(filtered desde _MAX_ total Registros)",
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
		   "bScrollCollapse": true						
	});
</script>


<form action="" name="filtro" id="filtro">	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style=" margin-top: 5px;">B&Uacute;SQUEDA DE PRODUCTO</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>C&oacute;digo de producto:</label>
						<input class="form-control" type="text" id="id_producto" name="id_producto" title="C&oacute;digo producto" onchange="combotallasvalorventas_prod();">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group" id="contenedor_combo_tallas_productos_vendidos">
				
						<label>Unidad:</label>
					<select name="talla" id="talla" class="form-control">
						
						<option value="">SELECCIONA UN PRODUCTO</option>
						
					</select>
					</div></div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Sucursal:</label>							
						<select id="sucursal" name="sucursal" class="form-control" title="Sucursal">
						<?php
						if($tipo == 0){ 
						?>
							<option value="0" selected>Todas</option>
						<?php
						}
							do
							{
						?> 					  
								<option value="<?php echo $result_sucursal_row['idsucursales'];?>"><?php echo $result_sucursal_row['sucursal']; ?></option>
						<?php 	   
							}while($result_sucursal_row = $db->fetch_assoc($result_sucursal));
						?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Nombre de producto:</label>
						<input class="form-control" type="text" id="nombre" name="nombre" title="Nombre" >
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Subcategor&iacute;a:</label>							
						<select id="idcategoria" name="idcategoria" class="form-control" title="Categor&iacute;a">
							<option value="0" selected>Todos</option>  
							<?php 
							do
							{
								
								?><option value="<?php echo $result_categoria_row['idsubcategoria'];?>"><?php echo $result_categoria_row['nombre']; ?></option><?php						  
							}while($result_categoria_row= $db->fetch_assoc($result_categoria));
							?>
						</select>
					</div>
				</div>

				

				<div class="col-md-3">
					<div class="form-group">
						<label>Precio:</label>
						<input class="form-control" type="text" id="precio" name="precio" title="Precio" >
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Descripci&oacute;n:</label>
						<input class="form-control" type="text" id="descripcion" name="descripcion" title="Descripcion" >
					</div>
				</div>

					
			</div>
		</div>
		
		<div class="card-footer text-muted" style="text-align: right;">
			<button type="button" onClick="reporteprod_vend();" class="btn btn-success" style="margin-right: 10px;"><i class="mdi mdi-download" ></i>  GENERAR REPORTE</button>
			<input type="button" value="BUSCAR" class="btn btn-info" onClick="var resp=MM_validateForm('id_producto','','R'); if(resp==1){b_producto_vendido('filtro','tabla_busqueda'); }" style="margin-top: 5px;" >
		</div>
	</div>
</form>
 
<div id="tabla_busqueda">
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">HISTORIAL DE VENTA DE PRODUCTOS</h5>
			<div style="clear: both;"></div>
		</div>
		<div class="card-body">
			<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
				<thead> 
					<tr> 
						<th>CODIGO</th>
						<th>NOMBRE</th>
						<th>COSTO</th>
						<th>EXIS.</th>
						<th>EXIS. FISC.</th>
					</tr> 
				</thead>

				<tbody> 
					<tr> 
						<td align="center" ></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
						<td align="center"></td>
					</tr>
				</tbody> 
			</table>
		</div>
	</div>
</div>


            
<?php
}catch (Exception $e){
	echo "Error:".$e;
}
?>   
         
<script>

		function  combotallasvalorventas_prod()
	{
		var nombre = $("#id_producto").val();
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrartodocarrito salida"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/vi_combo_tallas_pv.php',					  
					  data:'producto='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#contenedor_combo_tallas_productos_vendidos').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#contenedor_combo_tallas_productos_vendidos").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}
</script>