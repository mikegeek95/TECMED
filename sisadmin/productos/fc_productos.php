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


//conecto a la base de datos

require_once("../clases/conexcion.php");
require_once("../clases/class.Productos.php");
require_once("../clases/class.Categorias.php");
require_once("../clases/class.Funciones.php");
require_once("../clases/class.Categoria_Descuento.php");
require_once("../clases/class.Campanas.php");



   //creacion de objetos

   $db = new MySQL();
   $ca = new Categoria();//creamos el objeto ca para llamar el metodo de lista que las imprime jserarquicamente 
   $producto = new Producto();
   $fn = new Funciones ();
   $cd = new categoria_descuento();
   $cam = new Campanas();
    
   $ca->db=$db; 
   $producto->db = $db;
  
   $cd->db = $db;

   $cam->db = $db;
   
   $result_cate_precio = $cd->todasCategoriasPrecio();
   $result_cate_precio_row = $db->fetch_assoc($result_cate_precio);
  
   
   //recibimos variables id para su busqueda
   
	$id = $_GET['id'];
	$cadena = $fn->desconver_especial($id);
   $producto->id_producto_anterior = $cadena;  // este id es para poder hacer el UPDATE ya que el id_producto puede cambiar
   $producto->id_producto = $producto->id_producto_anterior;
   
   //se hace la consulta para optener datos del producto
   
   $sql_producto = "SELECT * FROM productos WHERE idproducto = '$producto->id_producto' ";
   $result_producto = $db->consulta($sql_producto);
   $result_producto_row = $db->fetch_assoc($result_producto);
   $result_producto_row_num = $db->fetch_assoc($result_producto);
    
    
   
   //genero consulta para obtener las cateorias principales.
   
   $sql_categoria="SELECT * FROM categorias WHERE depende = 0 AND estatus = '1'";
   $result_categoria= $db->consulta($sql_categoria);
   $result_categoria_row= $db->fetch_assoc($result_categoria);
   $result_categoria_row_num = $db->num_rows($result_categoria);
    
	
	$sql_productos = "SELECT * FROM productos WHERE estatus = 1 AND depende = 0";
  $result_productos = $db->consulta($sql_productos);
  $result_productos_num = $db->num_rows($result_productos);
  $result_productos_row = $db->fetch_assoc($result_productos);
  

	$result_campanas = $cam->todas();
	$result_campanas_num = $db->num_rows($result_campanas);
	$result_campanas_row = $db->fetch_assoc($result_campanas);

?>

<script type="text/javascript">
	$('#titulo-modal-forms').html("ALTA DE PRODUCTO");
</script>

<form id="modificar_producto" method="post" action="">
	<div class="card">
		<div class="card-body" style="padding: 0;">
			<div class="row">
				<div class="col-md-6">
					
					<!--<div class="form-group m-t-20">
						<label>Campa&ntilde;a:</label>
						<select name="idsobrepedido_camp" id="idsobrepedido_camp" class="form-control">
							<?php
							if($result_campanas_num == 0){
							?>
							<option value=" ">&nbsp;</option>
							<?php
							}else{
							?>
								<option value="0">--- SELECCIONAR CAMPA&Ntilde;A ---</option>
							<?php
								do
								{										
							?>
									<option value="<?php echo $result_campanas_row['idsobrepedido_camp'];?>" <?php if($result_campanas_row['idsobrepedido_camp'] == $result_producto_row['idsobrepedido_camp']){ echo "selected"; } ?>  ><?php echo $result_campanas_row['nombre']; ?></option>
							<?php
								}while($result_campanas_row = $db->fetch_assoc($result_campanas));
							}
							?>
						</select>
					</div>-->
					
					<div class="form-group m-t-20">
						<label>C&oacute;digo del Producto:</label>
						<input disabled="disabled" name="idproducto" type="text" id="idproducto" class="form-control" title="Campo Id del Producto" value="<?php echo $result_producto_row['idproducto']; ?>" />
					</div>
					
					<div class="form-group m-t-20">
						<label>C&oacute;digo del Proveedor:</label>
						<input type="text" name="cod_proveedor" id="cod_proveedor" value="<?php echo $result_producto_row['cod_proveedor']; ?>" class="form-control" title="Código del producto con el proveedor" />
					</div>
					
					<!--<div class="form-group m-t-20">
						<label>Depende:</label>
						<select id="depende" name="depende" class="form-control" title="depende">
							<option selected="" value="0">No depende</option>
							<?php
							if($result_productos_num != 0){
								do
								{
							?>
								<option <?php if($result_producto_row['depende'] == $result_productos_row['idproducto']){ echo "selected";} ?> value="<?php echo $result_productos_row['idproducto']; ?>"><?php echo $result_productos_row['nombre']; ?></option>
							<?php
								}while($result_productos_row = $db->fetch_assoc($result_productos));
							}
							?>
						</select>
					</div>-->
					
					<div class="form-group m-t-20">
						<label>Categor&iacute;a:</label>
						<select id="categoria" name="categoria" class="form-control" title="Categoria" onChange="combosubcategorias();">
							<?php 
							$subc=$result_producto_row['idsubcategoria'];
							$sql="select idcategoria from subcategoria where idsubcategoria='$subc'";
							$result_cat = $db->consulta($sql);
							$result_cat_num = $db->num_rows($result_cat);
						$result_cat_row = $db->fetch_assoc($result_cat);
									do
								   	{
									    ?>
							<option value="<?php echo $result_categoria_row['idcategoria'] ?>" <?php if($result_cat_row['idcategoria']==$result_categoria_row['idcategoria']){echo ("selected");} ?>><?php echo $result_categoria_row['nombre']; ?></option> 
							<?php					  

									}while($result_categoria_row = $db->fetch_assoc($result_categoria));

									?>

						</select>
					</div>
					<div id="content_combo_subcategorias" class="form-group m-t-20">
					<?php	
						$subc=$result_producto_row['idsubcategoria'];
						$sql="select * FROM subcategoria where idcategoria=(select idcategoria from subcategoria where idsubcategoria='$subc')";
						
						$result_tallas = $db->consulta($sql);

						$result_tallas_num = $db->num_rows($result_tallas);
						$result_tallas_row = $db->fetch_assoc($result_tallas);


?>


					<label>SUBCATEGORIA:</label>
					<select name="v_idcategoria" id="v_idcategoria" class="form-control">
						
						<?php
						if($result_tallas_num==0){
							?><option value="">NO HAY REGISTROS PARA ESTA CATEGORIA</option><?php
						}
						else{
						
						do
						{
						?>
						<option value="<?php echo $result_tallas_row['idsubcategoria']; ?>" <?php if($subc==$result_tallas_row['idsubcategoria']){echo ("selected");}?>><?php echo utf8_encode($result_tallas_row['nombre']); ?></option>
						<?php
						}while($result_tallas_row = $db->fetch_assoc($result_tallas));}
						
						?>
					</select>
					</div>
					
					<div class="form-group m-t-20">
						<label>Categor&iacute;a de precios:</label>
						<select id="v_idcategoria_precio" name="v_idcategoria_precio" class="form-control" title="Categoria">
							<?php 
							do
							{
							?>
							<option value="<?php echo $result_cate_precio_row['idcategoria_precio'] ?>" <?php if($result_producto_row['idcategoria_precio'] == $result_cate_precio_row['idcategoria_precio']){ echo "selected";} ?>><?php echo $result_cate_precio_row['nombre']; ?></option> 
							<?php
							}while($result_cate_precio_row = $db->fetch_assoc($result_cate_precio));
							?>               
						</select>
					</div>
					
					<div class="form-group m-t-20">
						<label>Nombre del Producto:</label>
						<input name="nombre" type="text" id="nombre" placeholder="usb" class="form-control" value="<?php echo $result_producto_row['nombre']; ?>" title="Campo Nombre del Producto" />
					</div>
					
					<!--<div class="form-group m-t-20">
						<label>Precio Costo:</label>
						<input type="text" name="p_costo" id="p_costo" class="form-control" value="<?php echo $result_producto_row['pc']; ?>" title="Costo del Producto" placeholder="14.50" />
					</div>-->
					
					<div class="form-group m-t-20">
						<label>Precio Venta:</label>
						<input type="text" name="p_venta" id="p_venta" class="form-control" value="<?php echo $result_producto_row['pv']; ?>" title="Costo del Producto" placeholder="14.50" />
					</div>
				</div>
				
				<div class="col-md-6">
					<!--<div class="form-group m-t-20">
						<label>Precio Mayoreo:</label>
						<input type="text" name="p_mayoreo" id="p_mayoreo" class="form-control" value="<?php echo $result_producto_row['pm']; ?>" title="Costo del Producto" placeholder="14.50" />
					</div>
					<div class="form-group m-t-20">
						<label>% Descuento:</label>
						<input name="v_descuento" type="text" id="v_descuento" value="<?php echo $result_producto_row['descuento']?>" placeholder="14.50" class="form-control" title="Costo Nombre del Producto" size="5" />
					</div>-->
					
					<div class="form-group m-t-20">
						<label>Cantidad Minima en Inventario:</label>
						<input name="v_stock" type="text" id="v_stock" value="<?php echo $result_producto_row['stok_min'] ?>" placeholder="14" class="form-control" title="Cantidad Minima en Inventario" size="5" />
					</div>
					
					<!--  <label class="width_full"> Notificar v&iacute;a SMS Stock M&iacute;nimo</label>    
        			<select id="v_sms" name="v_sms" style=" width:200px; display:block">
        			<option value="0" <?php if($result_producto_row['sms'] == 0){ echo "selected";} ?>>NO</option>
            		<option value="1" <?php if($result_producto_row['sms'] == 1){ echo "selected"; } ?>>SI</option>
        			</select>-->
					
					<?php 
					switch ($result_producto_row['unidad'])
					{
						case "PZ":
						$pz = 'selected="selected"';
						$lt = "";
						$kg = "";
						$talla = "";
						$mg = "";
						$ml = "";
						
						break;

						case "LT":
						$pz = "";
						$lt = 'selected="selected"';
						$kg = "";
						$talla = "";
						$mg = "";
						$ml = "";
						break ;

						case "KG":
						$pz = "";
						$lt = "";
						$kg = 'selected="selected"';
						$talla = "";
						$mg = "";
						$ml = "";
						break;
							
						case "TALLA":
						$pz = "";
						$lt = "";
						$kg = '';
						$talla = 'selected="selected"';
						$mg = "";
						$ml = "";
						break;
						
						case "ML":
						$pz = "";
						$lt = "";
						$kg = '';
						$talla = '';
						$mg = "";
						$ml = 'selected="selected"';
						break;
							
						case "MG":
						$pz = "";
						$lt = "";
						$kg = '';
						$talla = "";
						$mg = 'selected="selected"';
						$ml = "";
						break;
					}
					?>
					
					<div class="form-group m-t-20">
						<label>Unidad:</label>
						<select id="v_unidad" name="v_unidad" class="form-control">
							<option value="PZ" <?php echo $pz;  ?> >PZ</option>
							<option value="TALLA" <?php echo $talla;  ?> >TALLA</option>
							<option value="LT" <?php echo $lt; ?> >LT</option>
							<option value="ML" <?php echo $ml; ?> >ML</option>
							<option value="KG" <?php echo $kg; ?> >KG</option>
							<option value="MG" <?php echo $mg; ?> >MG</option>
						</select>
					</div>
					
					<div class="form-group m-t-20">
						<label>Descripci&oacute;n del Producto:</label>
						<textarea name="descripcion" rows="7" id="descripcion" class="form-control" placeholder="color media etc." title="Campo Descripci&oacute;n" style="height: 203px;"><?php echo $result_producto_row['descripcion']; ?></textarea>
					</div>
					
					<?php
					 switch ($result_producto_row['estatus'])
					 {
						 case 0:
						 $activo = "" ;
						 $inactivo ='selected="selected"';
						 break;
						 case 1:
						 $activo = 'selected="selected"';
						 $inactivo = "" ;
						 break;


					 }
					 ?>
					
					<div class="form-group m-t-20">
						<label>Estatus:</label>
						<select id="v_estatus" name="v_estatus" class="form-control">
						 	<option value="1" <?php echo $activo; ?> >Activo</option>
						 	<option value="0" <?php echo $inactivo; ?>>Inactivo</option>
					   </select>
					</div>
					
				</div>
				
				<div class="col-md-12">
					<div class="form-group m-t-20" style="text-align: center;">
						<label>IMAGEN DEL PRODUCTO:</label>
						<div id="d_logo" style="text-align:center; margin-top: 10px; margin-bottom: 20px;">
<?PHP
							 if($result_producto_row['foto'] != "")
							 {
								 $imagen = "productos/imagenes/".$result_producto_row['foto']."?".rand(0,3000);
							 }else
							 {
								 $imagen = "images/sinfoto.png";
							 }
?>
							
                     		<img src="<?php echo $imagen; ?>" width="150" height="150" alt="" style="border: 1px #707070 solid"/> 
						</div>
						<div class="spacer"></div>
                     	<input type="file" id="v_imagen" name="v_imagen[]">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="card">
		<div class="card-body" style="padding: 0;">
			<button type="button" onClick="var resp=MM_validateForm('nombre','','R','v_stok','','RisNum'); if(resp==1){ M_producto('modificar_producto','productos/md_productos.php','productos/bu_producto2.php','li_productos');}" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>GUARDAR</button>
		</div>
	</div>
</form>
<script>

</script>