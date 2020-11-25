<?php
  require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}
try {
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Funciones.php");


    $db= new MySQL();
	$fu= new Funciones();
	
	 
	
	//enviamos datos a las variables de la tablas	
	$producto =  trim($_POST['id_producto']);
	$idsucursal = $_POST['sucursal'];
	//$categoria = $_POST['categoria'];
	$nombre = $_POST['nombre'];
	$precio = $_POST['precio'];
	$idcategoria_precio = $_POST['cap'];
	$descripcion = $_POST['descripcion'];
	$estatus = $_POST['estatus'];
	$tallas = $_POST['talla'];
	
$sql_producto = trim("SELECT 
									p.idproducto AS CODIGOPRODUCTO,
									p.cod_proveedor AS CODIGOPROVEEDOR,
									p.nombre AS NOMBREPRODUCTO,
									p.pv AS COSTOACTUAL,
									i.existencia AS EXISTENCIA,
									s.sucursal as SUCURSAL, 
									cp.nombre as NOMBRECAT, 
									p.foto as FOTO, 
									
									i.idsucursales, 
									t.idtallas as TALLA ,t.unidad,t.valor
									FROM 
									productos p, 
									inventario i, 
									sucursales s, 
									categoria_precio cp, 
									tallas t 
									WHERE p.idproducto=i.idproducto 
									AND i.idsucursales=s.idsucursales 
									AND p.idcategoria_precio = cp.idcategoria_precio
									AND i.idtallas = t.idtallas
									");

	
//En esta parte sin necedidad de un if pregunta si la variable esta vacia o llena y le concatena la consulta

$sql_producto .= ($producto != '') ? " AND p.idproducto like'%$producto%'":"";
//$sql_producto .= ($cod_proveedor != '') ? " AND p.cod_proveedor like'%$cod_proveedor%'":"";
//$sql_producto .= ($categoria > 1) ? " AND p.idcategoria=$categoria":"";
$sql_producto .= ($idsucursal >= 1) ? " AND i.idsucursales=$idsucursal":"";
$sql_producto .= ($idcategoria_precio >= 1) ? " AND p.idcategoria_precio = $idcategoria_precio":"";
$sql_producto .= ($nombre != '') ? " AND p.nombre like'%$nombre%'":"";
$sql_producto .= ($precio != '') ? " AND p.pv like'%$precio%'":"";
//$sql_producto .= ($idsucursal != 0) ? " AND e.idsucursales = $idsucursal" : "" ;
//$sql_producto .= ($fecha != "") ? " AND e.fecha_compra = '$fecha' " : "" ;
$sql_producto .= ($estatus != "-") ? " AND p.estatus=$estatus":"" ;
$sql_producto .= ($descripcion != '') ? " AND p.descripcion like '%$descripcion%'":"";
$sql_producto .= ($tallas > 0) ? " AND i.idtallas = '$tallas'":"";
/*$sql_producto .= ($fecha && $fecha_fin)   ? " AND e.fecha_entrada BETWEEN '$fecha[0]-$fecha[1]-$fecha[2]'
                                                        AND '$fecha_fin[0]-$fecha_fin[1]-$fecha_fin[2]' " : "";*/

//die($sql_producto);
//terminan las preguntas de si la variable esta llena o vacia 
	 
	/*echo  $sql_producto ;
	exit;*/

//Convertimos el sql para el excel
$_SESSION['sql_invetario_excel']=$sql_producto;

//ejecuto la consulta y creo un fecth assoc	

	$result_producto = $db->consulta($sql_producto);
	$result_producto_row = $db->fetch_assoc($result_producto); 
	$result_producto_row_num = $db->num_rows($result_producto);
	 //error por si no se encuentra ni un registro
	 if ($result_producto_row_num <= 0)
	 {
		 echo "<p style='text-align:center; color:red;'>Lo sentimos no se encontraron los resultados de la busqueda</p> ";
		 
		 }
	else 
	{	 
?>


<script type="text/javascript" charset="utf-8">

	var oTable = $('#d_modulos').dataTable( {		
		"lengthChange": true,
	   "pageLength": 50,		

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



			<?php 
			
				//echo $sql_producto; 
				
				//$sql_encriptado = $fu->encrypt($sql_producto,'123');
				
				//echo $sql_encriptado;
				
				
				//Creamos la variable de session que tiene el sql a exportar a excel
				$_SESSION["sql"]=$sql_producto;
				
			?>


		<div class="row">
			<div class="col-md-12">
				<a class="btn btn-outline-success" href="productos/excel/excelInventario.php"> 
					<i class="far fa-file-excel"></i> 
					EXPORTAR EXCEL
				</a>
			</div>
		</div>
           
		<br>



			<table  class="table table-bordered table-hover" cellspacing="0" id="d_modulos"> 
			<thead class="px-3 py-5 bg-gradient-info text-white"> 
				<tr> 
   					 
                    <th>CODIGO</th>
					<th>UNIDAD/VALOR</th>
                    <th>IMAGEN</th>
                    <th>CAT. PRECIO</th>
                    <th>NOMBRE</th>
                    <th>COSTO</th>
    				<th>EXISTENCIA</th>
                    <th>SUCURSAL</th>
                </tr> 
			</thead> 
				
			<tbody> 
            
            
            <?php
            do
			{  
			   
			       
				
			      $idproducto = $result_producto_row['CODIGOPRODUCTO'];
				  $idsucursales = $result_producto_row['idsucursales'];
				  $idtallas = $result_producto_row['TALLA'];
				  
				 
				
				
				$sql_tallas = "SELECT * FROM tallas WHERE idtallas = '$idtallas'";
				$result_tallas = $db->consulta($sql_tallas);
				$result_tallas_row = $db->fetch_assoc($result_tallas);
				  			       
			?>
            
				<tr> 
   					  
   				   <td align="center" ><?php echo $result_producto_row['CODIGOPRODUCTO']; ?> </td>
					<td align="center" ><?php echo $fu->imprimir_cadena_utf8 ($result_tallas_row['valor']." ".$result_tallas_row['unidad']); ?> </td>
   				  <!-- <td align="center"><?php echo $result_producto_row['CODIGOPROVEEDOR']; ?></td>-->
                   
                   <!-- INICIA IMAGEN -->
                   <!--<td align="center" style="cursor:pointer;" onMouseOver="AbrirModalImagen('ModalImagen<?php echo $idproducto; ?>','400','400','<?php echo $idproducto; ?>');" onMouseOut="$('#ModalImagen<?php echo $idproducto; ?>').css('display','none'); $('#contenido_modal_img').html('');">
                   		
                        <img width="40" height="40"<?php if ($result_producto_row['FOTO']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/imagenes/<?php echo $result_producto_row['FOTO'];} ?>" style=" cursor:pointer;" />
                 
                        <div id="ModalImagen<?php echo $idproducto ?>" class="ventana" style="margin-left:-80px;">
                                <div id="contenido_modal_img<?php echo $idproducto; ?>">
                                    <img width="400" height="400" <?php if ($result_producto_row['FOTO']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/imagenes/<?php echo $result_producto_row['FOTO'];} ?>" />
                                </div>
                        </div>
                   </td>-->
					
					<?php 
						if ($result_producto_row['FOTO']==""){ 
							$ruta = 'images/sinfoto.png';   
						}else{ 
							$ruta = "productos/productos/imagenes/".$result_producto_row['FOTO']."?".rand(0,3000);
						}
					?>
					
					<td align="center" style="cursor:pointer;" onClick="AbrirModalImagen('<?php echo $ruta; ?>','<?php echo $fu->imprimir_cadena_utf8($result_producto_row['nombre']); ?>');">
						<img width="40" height="40"<?php if ($result_producto_row['FOTO']==""){ echo 'src="images/sinfoto.png" ';   } else { ?> src="productos/productos/imagenes/<?php echo $result_producto_row['FOTO']."?".rand(0,3000);} ?>" style=" cursor:pointer;" />
					</td>
                   <!-- termina IMAGEN -->
                   
                   
                   <td align="center"><?php echo $fu->imprimir_cadena_utf8($result_producto_row['NOMBRECAT']); ?></td>
   				   <!--<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_producto_row['f_entrada']); ?></td>-->
   				   <td align="center"><?php echo $fu->imprimir_cadena_utf8($result_producto_row['NOMBREPRODUCTO']); ?></td>
                   
                  <td align="center">$<?php echo  $fu->imprimir_cadena_utf8($result_producto_row['COSTOACTUAL']); ?></td>
                  <!--<td align="center"><?php echo  $fu->imprimir_cadena_utf8($result_producto_row['CANTIDADINGRESADA']); ?></td>-->
                 
                   <td align="center"><?php echo  $fu->imprimir_cadena_utf8($result_producto_row['EXISTENCIA']); ?></td>
                  
                   <!--<td align="center"><?php echo  $fu->imprimir_cadena_utf8($result_producto_row['EXISTENCIA']); ?></td>-->
                   <td align="center"><?php echo  $fu->imprimir_cadena_utf8($result_producto_row['SUCURSAL']); ?></td>
                   <!--Aqui estaba el thum -->
                    <!--<td>
                    	<a href="productos/excel/excelInventario.php?id=<?php echo $result_producto_row['CODIGOPRODUCTO'];?>">  
                  
                  			<input type="image" width="18" height="18" src="images/ico_excel.gif" title="GUARDAR EN EXCEL">
                      	</a>
                    </td>-->
                </tr>
            <?php 
			   }
			   while($result_producto_row = $db->fetch_assoc($result_producto));
			?>
            	
			</tbody> 
			</table>
          
           <?php } }
		   catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}		


		   ?> 