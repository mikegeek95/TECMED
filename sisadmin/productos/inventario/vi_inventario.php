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
   require_once("../../clases/class.Categorias.php");
   require_once("../../clases/class.Sucursales.php");
   require_once("../../clases/class.Categoria_Descuento.php");
   require_once("../../clases/class.Tallas.php");
   //creamos los objeos
  
   $db = new MySQL();
   $ca = new Categoria();//creamos el objeto ca para llamar el metodo de lista que las imprime jserarquicamente 
   $suc = new Sucursales();
   $cd = new categoria_descuento();
   $ta = new Tallas();
   $ca->db=$db;
   $suc->db = $db; 
   $cd->db = $db;
   $ta->db = $db;

try{	
	
	//hacemols la consulta para las categorias
   
   $sql_categoria="SELECT * FROM categorias ";
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
		
		//$n_sucursal = "Sucursal: ".$result_sucursal_row['sucursal'];
		
		
		
	}
	
	//obtenemos las categorias de descuento
	$result_categorias_precios = $cd->todasCategoriasPrecio();
	$result_categorias_precios_row = $db->fetch_assoc($result_categorias_precios);

	
	$result_tallas = $ta->TallasActivas();
	$result_tallas_num = $db->num_rows($result_tallas);
	$result_tallas_row = $db->fetch_assoc($result_tallas);


?>
         

	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">BUSQUEDA DE PRODUCTO</h5>
			
				
			
			<button data-toggle="modal" data-target="#buscar-inventario"  class="btn btn-outline-primary"  style="margin-top: 5px; float:right;" >  <i class="fas fa-sliders-h"></i>  BUSCAR</button>
			
		</div>
		<div class="card-body">
			
			<div id="tabla_busqueda">
	  		<table  class="table table-bordered" cellspacing="1" id="d_modulos"> 
				<thead class="px-3 py-5 bg-gradient-info text-white"> 
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


			<div class="modal fade" id="buscar-inventario" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
		  		<div class="modal-header">
					<h5 class="modal-title m-0 font-weight-bold text-primary" id="titulo-buscar-paciente">FILTRO DE B&Uacute;SQUEDA DE PRODUCTO</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  			<span aria-hidden="true">&times;</span>
					</button>
		  		</div>
		  
				<div class="modal-body" id="contenedor-buscar-paciente">
					<form action="#" method="post" id="busqueda">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="id_producto" >C&oacute;digo Producto:</label>
						<input type="text" onchange="combotallasvalorinventario();" name="id_producto" id="id_producto" title="C&oacute;digo producto" class="form-control" />
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="id_sucursal" >Categoria Precios:</label>
						<select id="cap" name="cap" class="form-control" title="Categorias Precios">
								<option value="0">Todas</option>
							<?php 

								  do
								   {
							?> 					  
									<option value="<?php echo $result_categorias_precios_row['idcategoria_precio'];?>"><?php echo $result_categorias_precios_row['nombre']; ?></option>
						   <?php 	   
									}while($result_categorias_precios_row = $db->fetch_assoc($result_categorias_precios));

									//echo $ca->opciones;
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="id_sucursal" >Sucursal:</label>
						<select id="sucursal" name="sucursal" class="form-control" title="Sucursal">
							<?php
							if($tipo == 0){ 
							?>
							 <option value="0" selected>Todas</option>

							 <?php
							}
							 ?>
							<?php 

								  do
								   {
							?> 					  
									<option value="<?php echo $result_sucursal_row['idsucursales'];?>"><?php echo $result_sucursal_row['sucursal']; ?></option>
						   <?php 	   
									}while($result_sucursal_row = $db->fetch_assoc($result_sucursal));

									//echo $ca->opciones;
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Nombre de producto:</label> 
						<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre "  />
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Precio:</label> 
						<input type="text" name="precio" id="precio" class="form-control" title="Precio "  />
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group" id="contenedor_combo_tallas_inventario">
						<label>Unidad:</label>
					<select name="talla" id="talla" class="form-control">
						
						<option value="">SELECCIONA UN PRODUCTO</option>
						
					</select>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Descripci&oacute;n:</label> 
						<input type="text" name="descripcion" id="descripcion" class="form-control" title="Descripcion "  />
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label for="categoria" >Estatus:</label>   
						<select id="estatus" name="estatus" class="form-control" title="Estatus">
						  <option value="-">Seleccione un estatus</option>
						  <option value="0">No Activo</option>
						  <option value="1">Activo</option>
						</select>
					</div>
				</div>
				
			</div>
			
		</form>
		 	 	</div>
				
		  		<div class="modal-footer">
					
					
						
			<button name="btn_agregar" type="button" class="btn btn-outline-primary" id="btn_agregar" onclick="b_inventario('busqueda','tabla_busqueda','<?php echo ($idmenu);?>'); $('#buscar-inventario').modal('hide');" ><i class="fas fa-search"></i>  BUSCAR</button>
	  	
					<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
		  		</div>
			</div>
	  	</div>
	</div>
       

             
     <?php
}
catch (Exception $e)
{
	echo "Error:".$e;
}
     ?>   
         

<script>

			function  combotallasvalorinventario()
	{
		var nombre = $("#id_producto").val();
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrartodocarrito salida"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/inventario/vi_combo_tallas_pv.php',					  
					  data:'producto='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#contenedor_combo_tallas_inventario').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#contenedor_combo_tallas_inventario").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}
	
	b_inventario('busqueda','tabla_busqueda','<?php echo ($idmenu);?>');
	
</script>
       