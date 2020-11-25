<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Funciones.php");
session_start();
//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


try{
    $db= new MySQL();
	$fu= new Funciones(); 
	
	//enviamos datos a las variables de la tablas	
	$producto =  trim($_POST['id_producto']);
	$idsucursal = $_POST['sucursal'];
	$idtallas = $_POST['talla'];
	$categoria = $_POST['idcategoria'];
	$nombre = $_POST['nombre'];
	$precio = $_POST['precio'];
	$descripcion = $_POST['descripcion'];	

	$sql_producto = "SELECT p.idproducto as idproducto, nd.cantidad as cantidad, nr.fechapedido as fecha, nr.idnota_remision as idnota, p.nombre as nombre, nr.idcliente as idcliente, nr.estatus as estatus, p.foto as FOTO, t.valor, t.unidad FROM nota_descripcion nd, productos p, nota_remision nr, tallas t WHERE nd.idproducto = p.idproducto AND nd.idnota_remision = nr.idnota_remision AND nd.idtallas = t.idtallas";


	$sql_entradas = "SELECT ed.*, e.idsucursales, e.fecha_entrada, e.idusuarios, p.nombre, t.valor, t.unidad FROM entradas_detalles ed, entradas e, productos p, tallas t WHERE ed.idproducto = '$producto' AND e.identradas = ed.identradas AND p.idproducto = ed.idproducto AND ed.idtallas = t.idtallas";

	$sql_salidas = "SELECT sd.*, s.idsucursales, s.fecha, s.tipo, s.idusuarios, p.nombre, t.valor, t.unidad FROM salidas_detalles sd, salidas s, productos p, tallas t WHERE sd.idproducto = '$producto' AND s.idsalidas = sd.idsalidas AND p.idproducto = sd.idproducto AND sd.idtallas = t.idtallas";

	$sql_devo = "SELECT cdd.cantidad, cdd.idproducto, cd.fecha, cd.idcliente_devolucion, p.nombre, nr.idcliente, cdd.idnota_remision, t.valor, t.unidad FROM cliente_devolucion_detalle cdd, cliente_devolucion cd, productos p, nota_remision nr, tallas t WHERE cdd.idproducto = '$producto' AND cdd.idcliente_devolucion = cd.idcliente_devolucion AND cdd.idproducto = p.idproducto AND cdd.idnota_remision = nr.idnota_remision AND cdd.idtallas = t.idtallas";

	//En esta parte sin necedidad de un if pregunta si la variable esta vacia o llena y le concatena la consulta
	$sql_producto .= ($producto != '') ? " AND nd.idproducto like'%$producto%'":"";
	$sql_producto .= ($categoria > 0) ? " AND p.idsubcategoria = '$categoria'":"";
	$sql_producto .= ($idsucursal >= 1) ? " AND nr.idsucursales = $idsucursal":"";
	$sql_producto .= ($nombre != '') ? " AND p.nombre like '%$nombre%'":"";
	$sql_producto .= ($precio != '') ? " AND p.pv like '%$precio%'":"";
	$sql_producto .= ($descripcion != '') ? " AND p.descripcion like '%$descripcion%'":"";
	$sql_producto .= ($idtallas > 0) ? " AND nd.idtallas = '$idtallas'":"";
	
	

	$sql_entradas .= ($producto != '') ? " AND ed.idproducto like '%$producto%'":"";
	$sql_entradas .= ($categoria > 0) ? " AND p.idsubcategoria = '$categoria'":"";
	$sql_entradas .= ($idsucursal >= 1) ? " AND e.idsucursales = $idsucursal":"";
	$sql_entradas .= ($nombre != '') ? " AND p.nombre like '%$nombre%'":"";
	$sql_entradas .= ($precio != '') ? " AND p.pv like '%$precio%'":"";
	$sql_entradas .= ($descripcion != '') ? " AND p.descripcion like '%$descripcion%'":"";
	$sql_entradas .= ($idtallas > 0) ? " AND ed.idtallas = '$idtallas'":"";
	
	
	$sql_salidas .= ($producto != '') ? " AND sd.idproducto like '%$producto%'":"";
	$sql_salidas .= ($categoria > 0) ? " AND p.idsubcategoria = '$categoria'":"";
	$sql_salidas .= ($idsucursal >= 1) ? " AND s.idsucursales = $idsucursal":"";
	$sql_salidas .= ($nombre != '') ? " AND p.nombre like '%$nombre%'":"";
	$sql_salidas .= ($precio != '') ? " AND p.pv like '%$precio%'":"";
	$sql_salidas .= ($descripcion != '') ? " AND p.descripcion like '%$descripcion%'":"";
	$sql_salidas .= ($idtallas > 0) ? " AND sd.idtallas = '$idtallas'":"";
	
	$sql_devo .= ($producto != '') ? " AND cdd.idproducto like '%$producto%'":"";
	$sql_devo .= ($categoria > 0) ? " AND p.idsubcategoria = '$categoria'":"";
	$sql_devo .= ($idsucursal >= 1) ? " AND cd.idsucursales = $idsucursal":"";
	$sql_devo .= ($nombre != '') ? " AND p.nombre like '%$nombre%'":"";
	$sql_devo .= ($precio != '') ? " AND p.pv like '%$precio%'":"";
	$sql_devo .= ($descripcion != '') ? " AND p.descripcion like '%$descripcion%'":"";
	$sql_devo .= ($idtallas > 0) ? " AND cdd.idtallas = '$idtallas'":"";

	//Convertimos el sql para el excel
	//$sqlenvio = $fu->conver_especial($sql_producto);

	//ejecuto la consulta y creo un fecth assoc	
	//echo $sql_producto;
	$_SESSION['prod_ven_productos']=$sql_producto;
	//die($sql_producto);
	$result_producto = $db->consulta($sql_producto);
	$result_producto_row = $db->fetch_assoc($result_producto); 
	$result_producto_row_num = $db->num_rows($result_producto);
	
	
	//echo ";".$sql_entradas;
	$_SESSION['prod_ven_entradas']=$sql_entradas;
	$result_entradas = $db->consulta($sql_entradas);
	$result_entradas_row = $db->fetch_assoc($result_entradas);
	$result_entradas_num = $db->num_rows($result_entradas);
	
	//	echo ";".$sql_salidas;
	
	$_SESSION['prod_ven_salidas']=$sql_salidas;
	$result_salidas = $db->consulta($sql_salidas);
	$result_salidas_row = $db->fetch_assoc($result_salidas);
	$result_salidas_num = $db->num_rows($result_salidas);
	
//echo ";".$sql_devo;
	$_SESSION['prod_ven_devoluciones']=$sql_devo;
	$result_devo = $db->consulta($sql_devo);
	$result_devo_row = $db->fetch_assoc($result_devo);
	$result_devo_num = $db->num_rows($result_devo);
	
?>
<script type="text/javascript" charset="utf-8">

var oTable = $('#d_modulos').dataTable( {		
	"ordering": false,
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



} );

var oTable = $('#d_modulos1').dataTable( {		
		"ordering": false,
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



} );


var oTable = $('#d_modulos2').dataTable( {		
	"ordering": false,
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



} );

var oTable = $('#d_modulos3').dataTable( {		
	"ordering": false,
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



} );

</script>

<?php 

	//echo $sql_producto; 

	//$sql_encriptado = $fu->encrypt($sql_producto,'123');

	//echo $sql_encriptado;


	//Creamos la variable de session que tiene el sql a exportar a excel
	$_SESSION["sql"]=$sql_producto;

?>
<!--<a style="padding: 5px; position:relative; top:3px;" href="productos/excel/excelInventario.php?id=<?php echo $sql_producto;?>"> 

	<img width="18" height="18" src="images/ico_excel.gif" title="GUARDAR EN EXCEL" />
</a>--><br>
			


<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">HISTORIAL DE VENTA DE PRODUCTOS</h5>
			<div style="clear: both;"></div>
		</div>
		<div class="card-body">
			<table  class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_modulos"> 
				<thead> 
					<tr> 
						 <th>NO. VENTA</th>
						<th>CODIGO</th>
						<th>IMAGEN</th>
						<th>NOMBRE</th>
						<th>CANT</th>
						<th>FECHA</th>
						<th>CLIENTE</th>
						<th>ESTATUS</th>
					</tr> 
				</thead> 

				<tbody>         
					<?php
					do
					{  

					if($result_producto_row['estatus'] == 1){

						  if($result_producto_row['estatus'] == 2){
							  $color = "#F00";
						  }else{
							  $color = "";
						  }


						$est = array('PENDIENTE','PAGADO','CANCELADO','CREDITO','CREDITO PAGADO');
						  $idproducto = $result_producto_row['idproducto'];

					?>

					<tr style="background: <?php echo $color; ?>;"> 
						<td align="center" ><?php echo $result_producto_row['idnota']; ?> </td>  
						<td align="center" ><?php echo $result_producto_row['idproducto']; ?> </td>

					   <!-- INICIA IMAGEN -->
					   <!--<td align="center" style="cursor:pointer;" onMouseOver="AbrirModalImagen('ModalImagen<?php echo $idproducto; ?>','400','400','<?php echo $idproducto; ?>');" onMouseOut="$('#ModalImagen<?php echo $idproducto; ?>').css('display','none'); $('#contenido_modal_img').html('');">

							<img width="20" height="20"<?php if ($result_producto_row['FOTO']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/imagenes/<?php echo $result_producto_row['FOTO'];} ?>" style=" cursor:pointer;" />

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
								$ruta = "productos/imagenes/".$result_producto_row['FOTO'];
							}
								
							if($result_producto_row['unidad']="TALLA"){
								$tallap=$result_producto_row['unidad']." ".$result_producto_row['valor'];
								
							}else{
								$tallap=$result_producto_row['valor']." ".$result_producto_row['unidad'];
							}
						?>

						<td align="center" style="cursor:pointer;" onClick="AbrirModalImagen('<?php echo $ruta; ?>','<?php echo utf8_encode($result_producto_row['nombre']); ?>');">
							<img width="40" height="40"<?php if ($result_producto_row['FOTO']==""){ echo 'src="images/sinfoto.png" ';   } else { ?> src="productos/imagenes/<?php echo $result_producto_row['FOTO'];} ?>" style=" cursor:pointer;" />
						</td>

					   <!-- termina IMAGEN -->
					   <td align="center"><?php echo utf8_encode($result_producto_row['nombre']." #".$tallap); ?></td>
					   <td align="center"><?php echo utf8_encode($result_producto_row['cantidad']); ?></td>

					   <!--<td align="center"><?php echo $result_producto_row['NOMBRECAT']; ?></td>-->
					   <?php
							$f = explode(' ',$result_producto_row['fecha']);
					   ?>
					   <td align="center"><?php echo $f['0']; ?></td>
					   <?Php 

						$idcliente = $result_producto_row['idcliente'];

						if($idcliente != 0){
							$sql_cliente = "SELECT * FROM clientes WHERE idcliente = '$idcliente'";
							$result_cliente = $db->consulta($sql_cliente);
							$result_cliente_row = $db->fetch_assoc($result_cliente);

							$nombre = utf8_encode($result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno']);
						}else{
							$nombre = "PUBLICO GENERAL";
						}


					   ?>
					   <td align="center"><?php echo $nombre; ?></td>
					   <td align="center"><?php echo $est[$result_producto_row['estatus']]; ?></td>                   

					</tr>
					<?php
							$vendidos = $vendidos + $result_producto_row['cantidad'];
						}
					  }while($result_producto_row = $db->fetch_assoc($result_producto));
					?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>

						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right">TOTAL: <?php echo $vendidos; ?></td>
					</tr>
				</tbody> 
			</table>
		</div>
	</div>


	<!--
	
<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">DEVOLUCIONES</h5>
		<div style="clear: both;"></div>
	</div>
	<div class="card-body">
		<table class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_modulos1"> 
			<thead> 
				<tr> 
					<th>NO. DEV</th>
					<th>NO. ORD</th>
					<th>CODIGO</th>
					<th>NOMBRE</th>
					<th>CANT</th>
					<th>FECHA</th>
					<th>CLIENTE</th>
				</tr> 
			</thead> 

			<tbody> 
			<?php
			if($result_devo_num == 0){
			}else{
				do
				{  
			?>
					<tr> 
						<td align="center" ><?php echo $result_devo_row['idcliente_devolucion']; ?> </td> 
						<td align="center" ><?php echo $result_devo_row['idnota_remision']; ?> </td>  
						<td align="center" ><?php echo $result_devo_row['idproducto']; ?> </td>
						<td align="center"><?php echo utf8_encode($result_devo_row['nombre']." #".$result_devo_row['talla']); ?></td>
						<td align="center"><?php echo utf8_encode($result_devo_row['cantidad']); ?></td>

					   <?php
							$f = explode(' ',$result_devo_row['fecha']);
					   ?>
						<td align="center"><?php echo $f['0']; ?></td>
					   <?php 

							$idcliente = $result_devo_row['idcliente'];

							if($idcliente != 0){
								$sql_cliente = "SELECT * FROM clientes WHERE idcliente = '$idcliente'";
								$result_cliente = $db->consulta($sql_cliente);
								$result_cliente_row = $db->fetch_assoc($result_cliente);

								$nombre = utf8_encode($result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno']);
							}else{
								$nombre = "PUBLICO GENERAL";
							}


						?>
						<td align="center"><?php echo $nombre; ?></td>
					</tr>
				<?php
					$devueltos = $devueltos + $result_devo_row['cantidad'];
				  }while($result_devo_row = $db->fetch_assoc($result_devo));
				}
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>

					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right">TOTAL: <?php echo $devueltos; ?></td>
				</tr>
			</tbody> 
		</table>
	</div>
</div>
           
-->

            
<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">ENTRADAS</h5>
		<div style="clear: both;"></div>
	</div>
	<div class="card-body">
		<table  class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_modulos2"> 
			<thead> 
				<tr> 
					<th align="center">CODIGO</th>
					<th align="center">NOMBRE</th>
					<th align="center">CANT</th>
					<th align="center">FECHA</th>
					<!--<th>ESTATUS</th>-->
				</tr> 
			</thead> 

			<tbody>         
			<?php
			if($result_entradas_num == 0){ 

			}else{
				do
				{
					
					if($result_entradas_row['unidad']="TALLA"){
								$tallap=$result_entradas_row['unidad']." ".$result_entradas_row['valor'];
								
							}else{
								$tallap=$result_entradas_row['valor']." ".$result_entradas_row['unidad'];
							}
			?>
				<tr> 
				   <td align="center" ><?php echo $result_entradas_row['idproducto']; ?> </td>
				   <td align="center"><?php echo utf8_encode($result_entradas_row['nombre']." #".$tallap); ?></td>
				   <td align="center"><?php echo utf8_encode($result_entradas_row['cantidad']); ?></td>
				   <?php
				   $f_entrada = explode(" ",$result_entradas_row['fecha_entrada']); 
				   ?>
				   <td align="center"><?php echo $f_entrada[0]; ?></td>
				   <!--<td align="center"><?php echo $est[$result_producto_row['estatus']]; ?></td>-->
				</tr>
			<?php
					$entraron = $entraron + $result_entradas_row['cantidad'];
				}while($result_entradas_row = $db->fetch_assoc($result_entradas));
			}
			?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right">TOTAL: <?php echo $entraron; ?></td>
				</tr>

			</tbody> 
		</table>
	</div>
</div>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">SALIDAS</h5>
		<div style="clear: both;"></div>
	</div>
	<div class="card-body">
		<table  class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_modulos3"> 
			<thead> 
				<tr> 
					<th align="center">CODIGO</th>
					<th align="center">NOMBRE</th>
					<th align="center">CANT</th>
					<th align="center">FECHA</th>
					<th align="center">TIPO</th>
				</tr> 
			</thead> 

			<tbody> 
			<?php
			if($result_salidas_num == 0){             	
			}else{
				do
				{
					
					if($result_salidas_row['unidad']="TALLA"){
								$tallap=result_salidas_row['unidad']." ".$result_salidas_row['valor'];
								
							}else{
								$tallap=$result_salidas_row['valor']." ".$result_salidas_row['unidad'];
							}
			?>
				<tr> 
				   <td align="center" ><?php echo $result_salidas_row['idproducto']; ?> </td>
				   <td align="center"><?php echo utf8_encode($result_salidas_row['nombre']." #".$tallap); ?></td>
				   <td align="center"><?php echo utf8_encode($result_salidas_row['cantidad']); ?></td>
				   <?php
				   $f_salida = explode(" ",$result_salidas_row['fecha']); 
				   $tipo = array('VENTAS','DEVOLUCION','FALLA','CADUCADO');

				   ?>
				   <td align="center"><?php echo $f_salida[0]; ?></td>
				   <td align="center"><?php echo $tipo[$result_salidas_row['tipo']]; ?></td>
				</tr>
			<?php
					$salieron = $salieron + $result_salidas_row['cantidad'];
				}while($result_salidas_row = $db->fetch_assoc($result_salidas));
			}
			?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right">TOTAL: <?php echo $salieron; ?></td>
				</tr>
			</tbody> 
		</table>
	</div>
</div>
        


<br>
<?php 
}catch(Exception $e){
	$db->rollback();
	echo "Error. ".$e;
}		
?> 