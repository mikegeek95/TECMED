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

try 
{

    $db= new MySQL();
	$pro = new Producto();
	$f = new Funciones();
	
	$pro->db = $db;
	
	 
	
	//enviamos datos a las variables de la tablas	
	$pago_tajerta =  trim($_POST['pago_tarjeta']);
	
 	$idsucursales = $_SESSION['se_sas_Sucursal'];
	
	/*$p_pedido = ($pedido != "" ) ? " AND no_pedido LIKE '%$pedido%' " : '';
	$p_guias = ($guias != "" ) ? "AND  no_guia LIKE '%$guias%' " : '';
	if($proveedor != 0){
		$p_proveedor = ($proveedor != "" ) ? "AND  idproveedores = $proveedor " : '';
	}
	
	$p_pago = ($pago != "" ) ? "AND  est_pago in($pago) " : '';
	
	$p_ini = ($ini != "" ) ? " est_recibido != $ini" : '';
	
	$p_f_alta = ($f_alta != "" ) ? " AND f_alta LIKE '%$f_alta%' " : '';
	$p_f_recibido = ($f_recibido != "" ) ? " AND f_recibido LIKE '%$f_recibido%' " : '';
	$p_facturado = ($fact != "" ) ? "AND  facturado in($fact) " : '';*/
	
	
	
	
	$sql_guias = "SELECT * FROM guias_pagos WHERE pagoTarjeta = '$pago_tajerta' AND metodo = 4";
	
	
	//die($sql_guias);
	//echo $sql_guias;
	
	$sql_mandar = $f->conver_especial($sql_guias);
		
//ejecuto la consulta y creo un fecth assoc	
	$result_pagos = $db->consulta($sql_guias);
	$result_row_pagos = $db->fetch_assoc($result_pagos); 
	$result_num_pagos = $db->num_rows($result_pagos);
	 //error por si no se encuentra ni un registro
	 if ($result_num_pagos <= 0)
	 {
		 echo "<p style='text-align:center; color:red;'>Lo sentimos no se encontraron los resultados de la busqueda</p> ";
		 
		 }
	else 
	{
		
		
		
		$moneda = array('USD','MXN');
		$metodo = array('EFECTIVO','DEPOSITO BANCARIO','MONEY GRAM','WESTER UNION','PAYPAL');
		$pagoTarjeta = array('PENDIENTE','PAGADO');
	 
?>




<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

      <!--  <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
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


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_modulos').dataTable( {	
				 "ordering": false,	
					   "lengthChange": true,
					   "pageLength": 50,		
					
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
				} );
				
				</script>


			<div style="padding:2px; width:100%;">
            	<input type="image" src="images/print.png" title="IMPRIMIR" onclick="imprimirPDF('catalogos/pdf/reportePagosGuia.php?sql=<?php echo $sql_mandar; ?>')">
                
                
                
                <a href="catalogos/excel/excelPagosGuais.php?sql=<?php echo $sql_mandar;?>"> 
      
                <img width="18" height="18" src="images/ico_excel.gif" title="GUARDAR EN EXCEL" />
            </a>
                
			</div>		
            

			<table  cellspacing="0"   class="tablesorter" id="tablacolores" style="width:100%" > 
		   <thead> 
			   <tr style="background-color:#DBD7D7">
			     
			     <th align="center" style="text-align:center">LOTE</th>
				   <th align="center" style="text-align:center">FECHA PAGO</th> 
   				   <th align="center" style="text-align:center"> MONTO</th>
                   <th align="center" style="text-align:center">MXN</th>
   				   <th align="center" style="text-align:center">MONEDA</th>
   				   <th align="center" style="text-align:center">METODO</th>
   				   <th align="center" style="text-align:center">REFERENCIA</th>
   				   <th align="center" style="text-align:center">P. TARJETA</th>
   				   <th align="center" style="text-align:center">ACCIONES</th>
			   </tr> 
		   </thead> 
		   <tbody> 
            
           <?php
           
		   
		   if($result_num_pagos!=0)
		   {
		   	$total = 0;
		   do
		   {
		   ?>
           
			   <tr>			   
			     <td align="center"><?php echo $result_row_pagos['idguias_pedidos']; ?></td>
			     <td align="center"><?php echo  $result_row_pagos['fecha_pago']; ?></td> 
			     <td align="center"><?php echo  "$ ".$result_row_pagos['monto']; ?></td>
			     <td align="center"><?php echo  "$ ".$result_row_pagos['monto_mxn']; ?></td>
			     <td align="center"><?php echo  $moneda[$result_row_pagos['moneda']]; ?></td>
			     <td align="center"><?php echo  $metodo[$result_row_pagos['metodo']]; ?></td>
			     <td align="center"><?php echo  $result_row_pagos['referencia']; ?></td>
			     <td align="center"><?php echo $pagoTarjeta[$result_row_pagos['pagoTarjeta']]; ?></td>
			     <td align="center">
                 <input type="image" src="images/icn_edit.png" title="EDITAR" onclick="aparecermodulos('catalogos/fc_guias_pago.php?idguias_pagos=<?php echo $result_row_pagos['idguias_pagos'];?>&idguia=<?php echo $idguia; ?>','contenido_modal');">
                 <input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarDatosPagoGuia('<?php echo $result_row_pagos['idguias_pagos'];?>','idguias_pagos','guias_pagos','n','catalogos/vi_guias_pagos.php?v_idguia=<?php echo $idguia;?>','contenido_modal')" /></td> 
			   </tr>
            
            <?php
			
				$total = $total + $result_row_pagos['monto'];
		   }while($result_row_pagos = $db->fetch_assoc($result_pagos));
		   }else
		   {
			?>
				<tr  >
			   
			     <td align="center" colspan="9">NO EXISTE NINGUN CONCEPTO DE GASTO EN ESTE MOMENTO</td> 
			     
			   </tr>
           	   <?php
		   }
			   ?>
               
               <tr>
               		<td colspan="7" align="center">&nbsp;</td>
               		<td width="90" align="center">TOTAL :</td>
                    <td width="60" align="center"><?php echo "$ ".number_format($total,2,'.',''); ?></td>
               </tr>
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