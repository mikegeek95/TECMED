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
	
	
	//Consultamos configuracion para impresion
	//$result_conf = $conf->ObtenerInformacionConfiguracion();
	//$impresion = $result_conf['notas_print'];
	
	//Consultamos configuracion de impresion por sucursal
	$suc = $_SESSION['se_sas_Sucursal'];
	$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
	$result_imp = $db->consulta($sql_imp);
	$result_imp_row = $db->fetch_assoc($result_imp);
	$impresion = $result_imp_row['notas_print'];
	 
	
	//enviamos datos a las variables de la tablas	
	$nombre =  utf8_decode($_POST['nombre']);
	//$paterno = utf8_decode($_POST['paterno']);
	//$materno = utf8_decode($_POST['materno']);
	$estatus = utf8_encode($_POST['estatus']);
	//$sucursal = $_POST['idsucursales'];	
	
		
 	//$idsucursales = $_SESSION['se_sas_Sucursal'];
	$tipo = $_SESSION['se_sas_Tipo'];

	
	//$p_nombre = ($nombre != "" ) ? " AND c.nombre LIKE '%$nombre%' " : '';
	//$p_paterno = ($paterno != "" ) ? "AND  c.paterno LIKE '%$paterno%' " : '';
	//$p_materno = ($materno != "" ) ? " AND c.materno LIKE '%$materno%' " : '';
	
	
	//$p_pago = ($pago != "" ) ? "AND  est_pago in($pago) " : '';
	//$p_ini = ($ini != "" ) ? " est_recibido != $ini" : '';
	
	if($nombre != ""){	
		$sql_guias = "SELECT a.* FROM apartados a, clientes c WHERE a.idcliente = c.idcliente AND a.estatus = '$estatus' ";
	}else{
		$sql_guias = "SELECT * FROM apartados a WHERE a.estatus = '$estatus'";
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
	
	$sql_guias.= "ORDER BY a.idapartados DESC";

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



		<script type="text/javascript" charset="utf-8">
				
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

			<table  cellspacing="0"  class="table table-bordered table-hover" cellpadding="0" id="tablacolores"> 
		   <thead> 
			   <tr>
			     
			    	<th style=" text-align: center;">NO. AP.</th> 
    				<th style=" text-align: center;">FECHA</th>
    				<th style=" text-align: center;">F. FIN</th>
                    <th style=" text-align: center;">CLIENTE</th>
                    <th style=" text-align: center;">ABONO</th>
                    <th style=" text-align: center;">SUCURSAL</th>
                    <!--<th>TiPO PAGO</th>
                    <th>ESTATUS</th>-->
                    <th style=" text-align: center;">ACCI&Oacute;N</th>
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
   				  <td style="text-align:center"><?php echo $result_pedidos_row['idapartados']; ?></td> 
   				  <td><?php echo $result_pedidos_row['fecha']; ?></td>
                  <td><?php echo $result_pedidos_row['fecha_fin']; ?></td>
   				  <td align="center"><?php echo utf8_encode($cliente); ?></td>
                  <td align="center"><?php echo $result_pedidos_row['abono']; ?></td>
                  <td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
                  <!--<td align="center">$ <?php echo number_format($result_pedidos_row['total'],2,'.',','); ?></td>
                  <td align="center"><?PHP echo $tipopago[$result_pedidos_row['tipo_pago']]; ?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>-->
                  <td align="center">
                  
                  
                  
                  	<?php
					if($impresion == 0){ 
					?>
					  
					  	<button type="button" onClick="imprimirPDF('ventas/pdf/apartado.php?id=<?php echo $result_pedidos_row['idapartados']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger">
							<i class="mdi mdi-printer"></i>
						</button>
					  
                    <?php
					}else{
						if($impresion == 1){
					?>
					  	
					  	<button type="button" onClick="imprimirPDF('ventas/pdf/apartado_termico.php?id=<?php echo $result_pedidos_row['idapartados']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger">
							<i class="mdi mdi-printer"></i>
						</button>
					  
                    <?php
						}else{
					?>					  
					  		<button type="button" onClick="imprimirPDF('ventas/pdf/apartado_termico2.php?id=<?php echo $result_pedidos_row['idapartados']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger">
								<i class="mdi mdi-printer"></i>
					  		</button>
                    <?php
						}
					}
					?>
                    
                    
                    
                    <?php 
						if($result_pedidos_row['estatus'] != 0){
					?>
					  
					  <button type="button" onClick="cancelarApartado('<?php echo  $result_pedidos_row['idapartados'];?>')" title="CANCELAR" class="btn btn-outline-danger"><i class="mdi mdi-block-helper"></i></button>
					                      
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