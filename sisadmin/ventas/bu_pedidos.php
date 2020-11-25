<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Configuracion.php");


$db = new MySQL();
$cl = new Clientes();
$fe = new Fechas();
$conf = new Configuracion();

$conf->db = $db;

$cl->db = $db;

$tipo = $_SESSION['se_sas_Tipo'];


$fecha = ($_POST['inicio'] != '' ) ? $_POST['inicio'] : '';
$fecha_fin =($_POST['f_fin'] != '' ) ? $_POST['f_fin'] : '';
$fecha_actual = $fe->fechaaYYYY_mm_dd_guion();

$nombre = trim($_POST['nombre']);
$estatust = $_POST['estatust'];
$idorden = $_POST['v_idventa'];
$autorizados = $_POST['autorizados'];

$b_where = 0;

$sql_pedidos ="SELECT nota_remision.idnota_remision, 
	clientes.idcliente, 
	nota_remision.idusuarios, 
	nota_remision.fechapedido, 
	nota_remision.fecha_pago, 
	nota_remision.idcliente, 
	nota_remision.total, 
	nota_remision.estatus, 
	nota_remision.tipo_pago, 
	nota_remision.idsucursales,
	nota_remision.autorizado,
	clientes.nombre, 
	clientes.paterno, 
	clientes.materno
FROM nota_remision  LEFT OUTER JOIN clientes ON nota_remision.idcliente = clientes.idcliente ";


$sql_pedidos.= ($fecha && $fecha_fin) ? " WHERE date(nota_remision.fechapedido)>= date('$fecha') AND date(nota_remision.fechapedido) <= date('$fecha_fin') " : " WHERE date(nota_remision.fechapedido)>= '1900-01-01' AND DATE(nota_remision.fechapedido) <= '$fecha_actual' ";

$sql_pedidos.=($nombre != "") ? " AND CONCAT(clientes.nombre,' ',clientes.paterno,' ',clientes.materno) LIKE TRIM('%$nombre%')":"";	
$sql_pedidos.=($estatust !="n") ? " AND nota_remision.estatus =  '$estatust'  ":" ";												
$sql_pedidos.=($idorden !="") ? " AND nota_remision.idnota_remision =  '$idorden'  ":" ";	
$sql_pedidos .= ($autorizados != 't') ? " AND nota_remision.autorizado = '$autorizados'":"";
//Validamos que sea superUsuario
if($tipo == 0){
	//die("superusuario TODAS");
}else{
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$sql_pedidos.= "AND nota_remision.idsucursales = '$idsucursales'";	
}
$sql_pedidos.= "ORDER BY nota_remision.idnota_remision DESC";

//echo $sql_pedidos ;

//$sql = "SELECT * FROM nota_remision";
$result_pedidos = $db->consulta($sql_pedidos);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);
$result_row_num = $db->num_rows($result_pedidos);

$tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
$estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia','Autorizados');




//die("Cantidad de registros es : ".$result_row_num);

//Consultamos configuracion para impresion
//$result_conf = $conf->ObtenerInformacionConfiguracion();
//$impresion = $result_conf['notas_print'];

//Consultamos configuracion de impresion por sucursal
$suc = $_SESSION['se_sas_Sucursal'];
$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
$result_imp = $db->consulta($sql_imp);
$result_imp_row = $db->fetch_assoc($result_imp);
$impresion = $result_imp_row['notas_print'];

?>




<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<!--<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>-->
        
        
        <!-- DataTables CSS -->
            <link rel="stylesheet" type="text/css" href="js/media/css/jquery.dataTables.css">
        <!-- jQuery -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.js"></script> 
        <!-- DataTables -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.dataTables.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


       
			<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th>ORD. COMP.</th> 
    				<th>FECHA</th>
    				<th>NOMBRE</th>
                    <th>TOTAL</th>
                    <th>ESTATUS</th>
                    <?php
					//if($tipo == 0){ 
					?>
                    <th>SUCURSAL</th>
                    <?php
					/*}else{
						echo "";
					}*/
					?>
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     if($result_row_num != 0){
	 
	     do
				{
			 
			 		if($result_pedidos_row['autorizado'] == 0){
						$icon = 'mdi mdi-close-circle';
					}else{
						$icon = 'mdi mdi-check-circle';
					}
					
					if($result_pedidos_row['idcliente'] != 0)
					{
						$cl->idCliente = $result_pedidos_row['idcliente'];								
						$result_cliente = $cl->ObtenerInformacionCliente();					
						$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
				    }
					else
					{
			           $cliente = "VENTANILLA";			
					}
					
					
					if($result_pedidos_row['estatus'] == 2){
						//Cancelado
						$color = "#F25781";
					}else{
						if($result_pedidos_row['estatus'] == 1){
							//Pagado
							$color = "#07D9B2";
						}else{
							if($result_pedidos_row['estatus'] == 0){
								//pendientes
								$color = '#F2E74B';
							}else{
								$color = "";
							}
						}
					}
					
					?>
            
          
            
				<tr > 
   				  <td style="text-align:center"><?php echo $result_pedidos_row['idnota_remision']; ?> <i class="<?php echo $icon; ?>"></i></td> 
   				  <td><?php echo $result_pedidos_row['fechapedido']; ?></td>
   				  <td align="left"><?php echo utf8_encode($cliente); ?></td>
                  <td align="center">$ <?php echo number_format($result_pedidos_row['total'],2,'.',','); ?></td>
                  <td align="center" style="background:<?php echo $color; ?>; color:#000;"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>
                  <?php
				  //if($tipo == 0){
					  $idsucursal = $result_pedidos_row['idsucursales'];
					  $sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
					  $result_sucursal = $db->consulta($sql_sucursal);
					  $result_sucursal_row = $db->fetch_assoc($result_sucursal);
				  ?>
               	  <td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
                  <?php
				 /* }else{
					  echo "";
				  }*/
				  ?>
                  <td align="center">
                    <!--<input type="image" src="images/icn_categories.png" title="LISTAR PRODUCTOS" onclick="aparecermodulos('ventas/vi_productosPedido.php?id=<?php echo $result_pedidos_row['idnota_remision'];?>','main');">-->
					  
					  <a class="iconped" href="#" onClick="imprimirPDF('ventas/pdf/etiqueta_pedido.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')" title="IMPRIMIR ETIQUETA DE PEDIDO"><i class="mdi mdi-tag-outline"></i></a>
                    
                    <?php
					if($impresion == 0){ 
					?>
					  <a href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
                    <?Php
					}else{
						if($impresion == 1){
					?>
					  <a class="iconped" href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado_termico.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
                    
                    <?Php
						}else{
							?>
					 	 	<a href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado_termico2.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
                            <?php
						}
					}
					?>
					  
					  
					  <a class="iconped" href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_anticipos_pedido.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>');" title="VER ANTICIPOS" style="font-size: 11px;"><i class="mdi mdi-square-inc-cash"></i></a>
																
					<a class="iconped" href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_depositos_pedido.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>');" title="DEPOSITOS" style="font-size: 12px;"><i class="mdi mdi-credit-card-plus"></i></a>
					  
					  
					  <a class="iconped" href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_guias_pedido.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>');" title="GUIAS" style="font-size: 13px;"><i class="mdi mdi-truck-delivery"></i></a>
					  
				<?php
			 	if($result_pedidos_row['estatus'] == 0){
				?>
					  
					<!--<a class="iconped" href="#" onclick="aparecermodulos('ventas/fc_ventas.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>','main')" title="EDITAR" style="font-size: 12px;"><i class="mdi mdi-table-edit"></i></a>-->
				<?php
				}
				?>
                    
                    <?php
					if($result_pedidos_row['estatus'] != 2){ 
					?>
					  <a class="iconped" href="#" onClick="cancelarPedidoPagado('<?php echo $result_pedidos_row['idnota_remision'] ?>')" title="CANCELAR" style="font-size: 11px;"><i class="mdi mdi-block-helper"></i></a>
                <?php
					}
				?>   
                  </td> 
				</tr>
                
                <?php
				}while($result_pedidos_row = $db->fetch_assoc($result_pedidos));
		 }
				?>
 
            	
			</tbody> 
			</table>


<script type="text/javascript">
	 $('#d_modulos').DataTable( {
				"pageLength": 10,
			"oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ ",
						"sZeroRecords": "NO EXISTEN CATEGORÍAS EN LA BASE DE DATOS.",
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
		 	"paging":   true,
		 	"ordering": false,
        	"info":     false


		} );
</script>
