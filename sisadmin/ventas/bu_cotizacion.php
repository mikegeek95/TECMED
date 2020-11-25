<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


require_once("../clases/conexcion.php");
require_once("../clases/class.Productos.php");
require_once("../clases/class.Funciones.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Configuracion.php");

try 
{

    $db= new MySQL();
	$pro = new Producto();
	$f = new Funciones();
	$cl = new Clientes();
	$conf = new Configuracion();
	
	$pro->db = $db;
	$cl->db = $db;
	$conf->db = $db;
	
	//Consultamos configuracion de impresion por sucursal
	$suc = $_SESSION['se_sas_Sucursal'];
	
	/*$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
	$result_imp = $db->consulta($sql_imp);
	$result_imp_row = $db->fetch_assoc($result_imp);
	$impresion = $result_imp_row['notas_print'];*/
	 
	
	//enviamos datos a las variables de la tablas	
	$nombre =  utf8_decode($_POST['nombre']);
	$estatus = utf8_encode($_POST['estatus']);
	//$sucursal = $_POST['idsucursales'];	
		
	$tipo = $_SESSION['se_sas_Tipo'];

	
	//$p_nombre = ($nombre != "" ) ? " AND c.nombre LIKE '%$nombre%' " : '';
	//$p_paterno = ($paterno != "" ) ? "AND  c.paterno LIKE '%$paterno%' " : '';
	//$p_materno = ($materno != "" ) ? " AND c.materno LIKE '%$materno%' " : '';
	
	
	//$p_pago = ($pago != "" ) ? "AND  est_pago in($pago) " : '';
	//$p_ini = ($ini != "" ) ? " est_recibido != $ini" : '';
	
	if($nombre != ""){	
		$sql_guias = "SELECT co.* FROM cotizacion co, clientes c WHERE co.idcliente = c.idcliente AND co.estatus = '$estatus' ";
	}else{
		$sql_guias = "SELECT * FROM cotizacion co WHERE co.estatus = '$estatus'";
	}
	
	$sql_guias.=($nombre != "") ? " AND CONCAT(c.nombre,' ',c.paterno,' ',c.materno) LIKE TRIM('%$nombre%') ":"";
	//$sql_guias .= ($sucursal >= 1) ? " AND a.idsucursales = $sucursal ":"";


	
	/*if($tipo == 0){
	//die("superusuario TODAS");
}else{
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$sql_guias.= "AND nota_remision.idsucursales = '$idsucursales'";	
}
*/
	
	$sql_guias.= "ORDER BY co.idcotizacion DESC";

	//die($sql_guias);
	//echo $sql_guias;
	
	$sql_mandar = $f->conver_especial($sql_guias);
	
	$result_pedidos = $db->consulta($sql_guias);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);
$result_pedidos_num = $db->num_rows($result_pedidos);
	 //error por si no se encuentra ni un registro
	 if ($result_pedidos_num <= 0)
	 {
		 echo "<p style='text-align:center; color:red;'>Lo sentimos no se encontraron los resultados de la busqueda</p> ";
		 
		 }
	else 
	{	 
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
            <!--<link rel="stylesheet" type="text/css" href="js/media/css/jquery.dataTables.css">-->
        <!-- jQuery -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.js"></script> 
        <!-- DataTables -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.dataTables.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#tablacolores').dataTable( {	
				 "ordering": false,	
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
					  
					  
						
				} );
				} );
				
				</script>


			
            <!--<div style="padding:2px; width:100%;">
            	<input type="image" src="images/print.png" title="IMPRIMIR" onclick="imprimirPDF('catalogos/pdf/reporteGuiaConsentrado.php?sql=<?php echo $sql_mandar; ?>')">
                
                
                
                <a href="catalogos/excel/excelguias.php?sql=<?php echo $sql_mandar;?>"> 
      
                <img width="18" height="18" src="images/ico_excel.gif" title="GUARDAR EN EXCEL" />
            </a>
                
			</div>-->
            
            <!--<table style="font-size:13px; margin:6px;">
            	<tr>
                	<td>&nbsp;</td>
                	<td>Cliente: <?php echo $result_gastos_row['nombre']." ".$result_gastos_row['paterno']." ".$result_gastos_row['materno']; ?></td>
                    
                    <td>&nbsp;</td>
                    
                    <td>Saldo actual: <?php echo "$ ".$result_gastos_row['saldo_monedero']; ?></td>
                </tr>
            </table>-->

			<table  cellspacing="0"  class="tablesorter" id="tablacolores"> 
		   <thead> 
			   <tr style="background-color:#DBD7D7">
			     
			    <th>NO. COT.</th> 
    				<th>FECHA</th>
    				<!--<th>F. FIN</th>-->
                    <th>CLIENTE</th>
                    <th>TOTAL</th>
                    <th>SUCURSAL</th>
                    <!--<th>TiPO PAGO</th>
                    <th>ESTATUS</th>-->
                    <th>ACCI&Oacute;N</th>
			   </tr> 
		   </thead> 
		   <tbody> 
            
            <?php		
	 if($result_pedidos_num != 0){
	     
	 
	     do
		    {
					
					$idsucursales = $result_pedidos_row['idsucursales'];
					
					$sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursales'";
					$result_sucursal = $db->consulta($sql_sucursal);
					$result_sucursal_row = $db->fetch_assoc($result_sucursal);
					
					
					if($result_pedidos_row['idcliente'] != 0)
					{
						$result_pedidos_row['idcliente'];
						$cl->idCliente = $result_pedidos_row['idcliente'];								
						$result_cliente = $cl->ObtenerInformacionCliente();					
						$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
				    }else
					{
			           $cliente = "VENTANILLA";			
						}
					
					
					?>
            
          
            
				<tr> 
   				  <td style="text-align:center"><?php echo $result_pedidos_row['idcotizacion']; ?></td> 
   				  <td><?php echo $result_pedidos_row['fecha']; ?></td>
                  <!--<td><?php echo $result_pedidos_row['fecha_fin']; ?></td>-->
   				  <td align="center"><?php echo utf8_encode($cliente); ?></td>
                  <td align="center"><?php echo "$ ".$result_pedidos_row['total']; ?></td>
                  <td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
                  <!--<td align="center">$ <?php echo number_format($result_pedidos_row['total'],2,'.',','); ?></td>
                  <td align="center"><?PHP echo $tipopago[$result_pedidos_row['tipo_pago']]; ?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>-->
                  <td align="center">
                    	
                        <!-- Inicia impresion -->
                        <input type="image" src="images/print.png" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/cotizacion.php?id=<?php echo $result_pedidos_row['idcotizacion']; ?>')"> 

						<!-- Inicia Generar venta -->
                        
                        <?php
						if($result_pedidos_row['estatus'] != 0){ 
						?>
						<input type="image" src="images/venta2.png" width="18" title="GENERAR VENTA" onclick="generarVenta('<?php echo $result_pedidos_row['idcotizacion']; ?>');"> 
                        <?php
						}
						?>
                        
                        
                        <!-- Agregar producto -->
                        <?php
						if($result_pedidos_row['estatus'] != 0){ 
						?>
						<input type="image" src="images/add.png" width="18" title="AGREGAR PRODUCTO" onclick="AbrirModalGeneral2('ModalPrincipal','900','560','ventas/fc_cotizacion.php?id=<?php echo $result_pedidos_row['idcotizacion']; ?>');"> 
                        <?php
						}
						?>
                   
                    
                    <!-- Inicia Cancelar cotizacion -->
					<?php 
						if($result_pedidos_row['estatus'] != 0){
					?>
                    
                    <input type="image" src="images/icn_logout.png" title="CANCELAR" onclick="cancelarCotizacion('<?php echo  $result_pedidos_row['idcotizacion'];?>')">
                    
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
          
           <?php 
		     } 
		   }
		   catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}		


		   ?> 