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
require_once("../../clases/class.Productos.php");
require_once("../../clases/class.Categoria_Descuento.php");
	require_once("../../clases/class.Botones.php");
	require_once("../../clases/class.Funciones.php");

if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/




    $db= new MySQL();
	$pro = new Producto();
	$cd = new categoria_descuento();
	$bt = new Botones_permisos();
	$f= new Funciones();
	
	$pro->db = $db;
	$cd->db = $db;
	
	 
	
	//enviamos datos a las variables de la tablas	
	$cod =  trim($f->guardar_cadena_utf8($_POST['cod']));
	$cod_proveedor = trim($f->guardar_cadena_utf8($_POST['cod_proveedor']));
	$nombre = trim($f->guardar_cadena_utf8($_POST['nombre']));
	$descripcion = trim($f->guardar_cadena_utf8($_POST['descripcion']));
	$precio = $_POST['precio'];
	$estatus = $_POST['estatus'];
	//$existencia = $_POST['existencia'];
	$categoria = $_POST['categoria'];
	
	
	
 	
	
	$p_codigo = ($cod != "" ) ? " AND p.idproducto LIKE '%$cod%' " : '';
	$p_cod_proveedor = ($cod_proveedor != "" ) ? "AND  p.cod_proveedor LIKE '%$cod_proveedor%' " : '';
	$p_precio = ($precio != "" ) ? "AND  p.pv = $precio " : '';
	$p_descripcion = ($descripcion != "" ) ? "AND  p.descripcion like '%$descripcion%' " : '';
	$p_nombre = ($nombre != "" ) ? "AND  p.nombre like '%$nombre%' " : '';
	
	
	if($categoria != 0){
	$p_categoria = ($categoria != "" ) ? "AND  p.idcategoria_precio IN ($categoria) " : '';
	}else{
		$p_categoria = "";
	}
		$sql_producto = "SELECT * FROM productos p WHERE p.estatus in($estatus) $p_codigo $p_cod_proveedor $p_descripcion $p_precio $p_nombre $p_categoria ";
		

//ejecuto la consulta y creo un fecth assoc
	$result_producto = $db->consulta($sql_producto);
	$result_producto_row = $db->fetch_assoc($result_producto); 
	$result_producto_row_num = $db->num_rows($result_producto);
	 //error por si no se encuentra ni un registro
	 
	  
?>




	 <table class="table table-bordered " id="d_modulos" width="100%" cellspacing="0" style="text-align: center; ">
	<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
		<tr>  
			<th style="text-align: center;">CODIGO</th>
			<!--<th style="text-align: center;">COD. PROVEEDOR</th>-->
			<th style="text-align: center;" >IMAGEN</th>
			<th style="text-align: center;">CAT. PRECIO</th>
			<th style="text-align: center;">NOMBRE</th>
			<th style="text-align: center;">DESCRIPCION</th>
			<th style="text-align: center;">COSTO</th>
			<th style="text-align: center;">EXISTENCIA</th>
			<th style="text-align: center;">ACCIONES</th>
		</tr> 
	</thead> 
			
	<tbody> 
<?php	if($result_producto_row_num == 0){
		  ?>
		 <tr>   <td style='text-align: center;' colspan="8">Lo sentimos no se encontraron los resultados de la busqueda</td></tr>  
		<?php
	  }
		 else{
   		do
		{  			 
			
?>
            
		<tr> 
	<?php
			//Obtenemos existencia de la sucursal
			$idproducto = $result_producto_row['idproducto'];
			$sql = "SELECT SUM(existencia) as existencia FROM inventario WHERE idproducto = '$idproducto'";
			$result_inventario = $db->consulta($sql);
			$result_inventario_row = $db->fetch_assoc($result_inventario);
			$result_inventario_num = $db->num_rows($result_inventario);

			if($result_inventario_num == 0){
				//No hay en existencia
				$existencia = 0;
			}else{
				//Tiene existencia
				$existencia = $result_inventario_row['existencia'];
			}
	?>	  
	   		<td align="center" ><?php echo $result_producto_row['idproducto']; ?> </td>
	   		<!--<td align="center" ><?php echo $result_producto_row['cod_proveedor']; ?> </td>-->
			
			<?php 
				if ($result_producto_row['foto']==""){ 
					$ruta = 'images/sinfoto.png';   
				}else{ 
					$ruta = "productos/productos/imagenes/".$result_producto_row['foto']."?".rand(0,3000);
				}
			?>

	  		<td align="center" style="cursor:pointer;" onClick="AbrirModalImagen('<?php echo $ruta; ?>','<?php echo $f->imprimir_cadena_utf8($result_producto_row['nombre']); ?>');">
				<img width="40" height="40"<?php if ($result_producto_row['foto']==""){ echo 'src="images/sinfoto.png" ';   } else { ?> src="productos/productos/imagenes/<?php echo $result_producto_row['foto']."?".rand(0,3000);} ?>" style=" cursor:pointer;" />
	 		</td>

	   <?PHP
			$idcategoria_precio = $result_producto_row['idcategoria_precio'];

			$cd->idcategoria_precio = $idcategoria_precio;
			$result_categoria = $cd->buscarCategoriaPrecio();
			$result_categoria_row = $db->fetch_assoc($result_categoria);

	   ?>

		   <td align="center"><?php echo $f->imprimir_cadena_utf8($result_categoria_row['nombre']); ?></td>
		   <td align="center"><?php echo $f->imprimir_cadena_utf8($result_producto_row['nombre']); ?></td>
		   <td align="center" style="max-width: 200px;"><?php echo $f->imprimir_cadena_utf8($result_producto_row['descripcion']); ?></td>

		  <td align="center"><?php echo $result_producto_row['pv']; ?></td>

		   <td align="center"><?php echo $existencia; ?></td>
		   <!--<td align="center"><?php echo $cant_consig; ?></td>

		   <td align="center"><?php echo $total_existencia; ?></td>-->
		   <td align="center"> 

			   <?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->data_toggle='data-toggle="modal"';
										$bt->data_target='data-target="#modal-forms"';
										$bt->icon = "far fa-edit";
										$bt->funcion = "AbrirModalGeneral2 ('ModalPrincipal','900','560','productos/productos/fa_productos.php?id=".$result_producto_row['idproducto']."&idmenumodulo=$idmenu')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
			   
			   
			 
							
			
			   <?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->data_toggle='';
												$bt->data_target='';
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_producto_row['idproducto']."','idproducto','productos','n','productos/productos/vi_productos.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
		   </td>



		</tr>
<?php 
   }
   while($result_producto_row = $db->fetch_assoc($result_producto));
}
?>

</tbody> 
</table>
          
  <script type="text/javascript" charset="utf-8">

var oTable = $('#d_modulos').dataTable( {	
 "ordering": false,	
	   "lengthChange": true,
	   "pageLength": 10,		

	  "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "Nada Encontrado - Disculpa",
					"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty": "desde 0 a 0 de 0 records",
					"sInfoFiltered": "",
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



} );

</script>