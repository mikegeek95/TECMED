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
//conecto a la base de datos

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.Categorias.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Categoria_Descuento.php");




   //creacion de objetos

   $db = new MySQL();
   $ca = new Categoria();//creamos el objeto ca para llamar el metodo de lista que las imprime jserarquicamente 
   $producto = new Producto();
   $f = new Funciones ();
   $cd = new categoria_descuento();
  
    
   $ca->db=$db; 
   $producto->db = $db;
  
   $cd->db = $db;

   
   
   $result_cate_precio = $cd->todasCategoriasPrecio();
   $result_cate_precio_row = $db->fetch_assoc($result_cate_precio);
  
   
   //recibimos variables id para su busqueda
   if(isset($_GET['id'])){
	$id = $_GET['id'];
	$cadena = $f->desconver_especial($id);
   $producto->id_producto_anterior = $cadena;  // este id es para poder hacer el UPDATE ya que el id_producto puede cambiar
   $producto->id_producto = $producto->id_producto_anterior;
   
   //se hace la consulta para optener datos del producto
   
   $sql_producto = "SELECT * FROM productos WHERE idproducto = '$producto->id_producto' ";
   $result_producto = $db->consulta($sql_producto);
   $result_producto_row = $db->fetch_assoc($result_producto);
   $result_producto_row_num = $db->fetch_assoc($result_producto);
	  $tipo=1;
	   $titulo=$f->imprimir_cadena_utf8("MODIFICACI&Oacute;N DE PRODUCTO");
	   $idproducto=$f->imprimir_cadena_utf8($result_producto_row['idproducto']);
	   $proveedor=$f->imprimir_cadena_utf8($result_producto_row['cod_proveedor']);
	   $subcategoria=$f->imprimir_cadena_utf8($result_producto_row['idsubcategoria']);
	   $categoriaprecio=$f->imprimir_cadena_utf8($result_producto_row['idcategoria_precio']);
	   $nombre=$f->imprimir_cadena_utf8($result_producto_row['nombre']);
	   $pc=$f->imprimir_cadena_utf8($result_producto_row['pc']);
	   $pv=$f->imprimir_cadena_utf8($result_producto_row['pv']);
	   $unidad=$f->imprimir_cadena_utf8($result_producto_row['unidad']);
	   $descuento=$f->imprimir_cadena_utf8($result_producto_row['descuento']);
	   $minimo=$f->imprimir_cadena_utf8($result_producto_row['stok_min']);
	   $descripcion=$f->imprimir_cadena_utf8($result_producto_row['descripcion']);
	   $estatus=$f->imprimir_cadena_utf8($result_producto_row['estatus']);
	   
	   $sql="select idcategoria from subcategoria where idsubcategoria='$subcategoria'";
							$result_cat = $db->consulta($sql);
							$result_cat_num = $db->num_rows($result_cat);
						$result_cat_row = $db->fetch_assoc($result_cat);
	   
	   $categoria=$f->imprimir_cadena_utf8($result_cat_row['idcategoria']);
	   
	    if($result_producto_row['foto'] != "")
			{
				$imagen = "productos/productos/imagenes/".$result_producto_row['foto']."?".rand(0,3000);
			 }else
			{
				 $imagen = "images/sinfoto.png";
			 }
	   
	   $disabled="disabled";
	   
   }else{
	   $tipo=0;
	   $titulo=$f->imprimir_cadena_utf8("ALTA DE PRODUCTO");
	   $idproducto="";
	   $proveedor="";
	   $subcategoria="";
	   $categoriaprecio="";
	   $nombre="";
	   $pc="";
	   $pv="";
	   $unidad="";
	   $descuento="";
	   $minimo="";
	   $descripcion="";
	   $estatus="";
	    $categoria="";
	   $imagen = "images/sinfoto.png";
	 
	   $disabled="";
	   
   }
    
   
   //genero consulta para obtener las cateorias principales.
   
   $sql_categoria="SELECT * FROM categorias WHERE  estatus = '1'";
   $result_categoria= $db->consulta($sql_categoria);
   $result_categoria_row= $db->fetch_assoc($result_categoria);
   $result_categoria_row_num = $db->num_rows($result_categoria);
    
	

	

?>

<script type="text/javascript">
	$('#titulo-modal-forms').html("<?php echo ($titulo);?>");
</script>

<form id="form_producto" method="post" action="">
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<div class="row">
				<div class="col-md-6">
					
					
					
					<div class="form-group m-t-20">
						<label>C&oacute;digo del Producto:</label>
						<input  name="idproducto" type="text" id="idproducto" class="form-control" title="Campo Id del Producto" value="<?php echo $idproducto; ?>" <?php echo ($disabled);?>/>
						<input  name="id" type="hidden" id="id" class="form-control" title="" value="<?php echo $tipo; ?>" />
					</div>
					
					<div class="form-group m-t-20">
						<label>C&oacute;digo del Proveedor:</label>
						<input type="text" name="cod_proveedor" id="cod_proveedor" value="<?php echo $proveedor; ?>" class="form-control" title="Código del producto con el proveedor" />
					</div>
					
					
					
					<div class="form-group m-t-20">
						<label>Categor&iacute;a:</label>
						<select id="categoria" name="categoria" class="form-control" title="Categoria" onChange="combosubcategorias('');">
							<?php 
							
							
									do
								   	{
									    ?>
							<option value="<?php echo $result_categoria_row['idcategoria'] ?>" <?php if($categoria==$result_categoria_row['idcategoria']){echo ("selected");} ?>><?php echo $result_categoria_row['nombre']; ?></option> 
							<?php					  

									}while($result_categoria_row = $db->fetch_assoc($result_categoria));

									?>

						</select>
					</div>
					<div id="content_combo_subcategorias" class="form-group m-t-20">
					
					</div>
					
					<div class="form-group m-t-20">
						<label>Categor&iacute;a de precios:</label>
						<select id="v_idcategoria_precio" name="v_idcategoria_precio" class="form-control" title="Categoria">
							<?php 
							do
							{
							?>
							<option value="<?php echo $result_cate_precio_row['idcategoria_precio'] ?>" <?php if($categoriaprecio == $result_cate_precio_row['idcategoria_precio']){ echo "selected";} ?>><?php echo $result_cate_precio_row['nombre']; ?></option> 
							<?php
							}while($result_cate_precio_row = $db->fetch_assoc($result_cate_precio));
							?>               
						</select>
					</div>
					
					<div class="form-group m-t-20">
						<label>Nombre del Producto:</label>
						<input name="nombre" type="text" id="nombre"  class="form-control" value="<?php echo $nombre; ?>" title="Campo Nombre del Producto" />
					</div>
					
					<div class="form-group m-t-20">
						<label>Precio Costo:</label>
						<input type="text" name="p_costo" id="p_costo" class="form-control" value="<?php echo $pc; ?>" title="Costo del Producto"  />
					</div>
					
					<div class="form-group m-t-20">
						<label>Precio Venta:</label>
						<input type="text" name="p_venta" id="p_venta" class="form-control" value="<?php echo $pv; ?>" title="Costo del Producto"  />
					</div>
				</div>
				
				<div class="col-md-6">
					
					<div class="form-group m-t-20">
						<label>% Descuento:</label>
						<input name="v_descuento" type="text" id="v_descuento" value="<?php echo $descuento;?>"  class="form-control" title="Costo Nombre del Producto" size="5" />
					</div>
					
					<div class="form-group m-t-20">
						<label>Cantidad Minima en Inventario:</label>
						<input name="v_stock" type="text" id="v_stock" value="<?php echo $minimo; ?>"  class="form-control" title="Cantidad Minima en Inventario" size="5" />
					</div>
					
					
					
					<?php 
					switch ($unidad)
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
							
							default:
						$pz = "";
						$lt = "";
						$kg = '';
						$talla = "";
						$mg = '';
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
						<textarea name="descripcion" rows="7" id="descripcion" class="form-control" title="Campo Descripci&oacute;n" style="height: 203px;"><?php echo $descripcion; ?></textarea>
					</div>
					
					
					
					<div class="form-group m-t-20">
						<label>Estatus:</label>
						<select id="v_estatus" name="v_estatus" class="form-control">
						 	<option value="1" <?php if(1==$estatus){ echo "selected" ;} ?> >Activo</option>
						 	<option value="0" <?php if(0==$estatus){ echo "selected"; } ?>>Inactivo</option>
					   </select>
					</div>
					
				</div>
				
				<div class="col-md-12">
					<div class="form-group m-t-20" style="text-align: center;">
						<label>IMAGEN DEL PRODUCTO:</label>
						<div id="d_logo" style="text-align:center; margin-top: 10px; margin-bottom: 20px;">
						
                     		<img src="<?php echo $imagen; ?>" width="150" height="150" alt="" style="border: 1px #707070 solid"/> 
						</div>
						<div class="spacer"></div>
                     	<input type="file" id="v_imagen" name="v_imagen[]">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<button type="button" onClick=" G_producto('form_producto','productos/productos/ga_productos.php','productos/productos/vi_productos.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" >  <i class="far fa-save"></i>  GUARDAR</button>
		</div>
	</div>
</form>
<script>
combosubcategorias(<?php echo ($subcategoria);?>);
</script>

<script type="text/javascript"	src="js/validaciones/productos.js"></script>