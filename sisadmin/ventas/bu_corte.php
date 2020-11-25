<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Fechas.php");

$db = new MySQL();
$cl = new Clientes();
$fe = new Fechas();

$cl->db = $db;

$fecha = ($_POST['inicio'] != '' ) ? $_POST['inicio'] : '';
$fecha_fin =($_POST['f_fin'] != '' ) ? $_POST['f_fin'] : '';
$fecha_actual = $fe->fechaaYYYY_mm_dd_guion();

$sucursal = $_POST['sucursal'];
$idcorte = $_POST['v_idventa'];

$b_where = 0;

$sql_pedidos ="SELECT * FROM corte ";


$sql_pedidos.= ($fecha && $fecha_fin) ? " WHERE date(f_inicio)>= date('$fecha') AND date(f_inicio) <= date('$fecha_fin') " : " WHERE date(f_inicio)>= '1900-01-01' AND DATE(f_inicio) <= '$fecha_actual' ";


$sql_pedidos.=($sucursal >= 1) ? " AND idsucursales =  '$sucursal'  ":" ";												
$sql_pedidos.=($idcorte !="") ? " AND idcorte =  '$idcorte'  ":" ";	


//die($sql_pedidos);

$result_pedidos = $db->consulta($sql_pedidos);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);
$result_row_num = $db->num_rows($result_pedidos);

$estatus  = array('CERRADO','ACTIVO');




//die("Cantidad de registros es : ".$result_row_num);

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


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_modulos').dataTable( {	
				       "ordering": false,
					   "lengthChange": true,
					   "pageLength": 100,	
					   "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "Lo sentimos - Ningun registro encontrado",
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
					   "scrollX": true
					} );
				} );
				
				</script>
                
                
           <div>
           	<span>ME = Monto efectivo  -  TC = Tarjeta Cr&eacute;dito  -  TF = Transferencia  -  DP = Deposito  -  CH = Cheque  -  MV = Monto Virtual</span> 
           </div>
           
           <br>
       
			<table width="1400"  class="display table compact" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<!--<th style="width:20px!important;">No.</th>-->
                    <th>SUCURSAL</th>
    				<th>F. INICIO</th>
    				<th>C. CHICA</th>
                    <th>F. CORTE</th>
                    <th>ME</th>
                    <th>TC</th>
                    <th>TF</th>
                    <th>DP</th>
                    <th>CH</th>
                    <th>MV</th>
                    <th>CAJA</th>
                    <th>BANCO</th>
                    <th>TOTAL</th>
                    <th>GANANCIA</th>      
                    <th>ESTATUS</th>                   
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     if($result_row_num != 0){
	 
	     do
				{				
					?>
            
          
            
				<tr style="background:<?php echo $color; ?>; color:#000;"> 
   				  <!--<td style="text-align:center; width:20px!important;"><?php echo $result_pedidos_row['idcorte']; ?></td>--> 
                  <?php
					  $idsucursal = $result_pedidos_row['idsucursales'];
					  $sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
					  $result_sucursal = $db->consulta($sql_sucursal);
					  $result_sucursal_row = $db->fetch_assoc($result_sucursal);
					  
					  $f_inicio = $result_pedidos_row['f_inicio']." ".$result_pedidos_row['h_inicio'];
					  
					  if($result_pedidos_row['f_corte'] == ""){
						$f_corte = "-";  
					  }else{
					  	$f_corte = $result_pedidos_row['f_corte']." ".$result_pedidos_row['h_corte'];
					  }
					  
					  if($result_pedidos_row['efectivo'] == ''){
						  $efectivo = "0.00";
					  }else{
						  $efectivo = $result_pedidos_row['efectivo'];
					  }
					  
					  if($result_pedidos_row['tarjeta'] == ''){
						  $tarjeta = "0.00";
					  }else{
						  $tarjeta = $result_pedidos_row['tarjeta'];
					  }
					  
					  if($result_pedidos_row['virtual'] == ''){
						  $virtual = "0.00";
					  }else{
						  $virtual = $result_pedidos_row['virtual'];
					  }
					  
					  if($result_pedidos_row['trasfer'] == ''){
						  $trasfer = "0.00";
					  }else{
						  $trasfer = $result_pedidos_row['trasfer'];
					  }
					  
					  if($result_pedidos_row['deposito'] == ''){
						  $deposito = "0.00";
					  }else{
						  $deposito = $result_pedidos_row['deposito'];
					  }
					  
					  if($result_pedidos_row['cheque'] == ''){
						  $cheque = "0.00";
					  }else{
						  $cheque = $result_pedidos_row['cheque'];
					  }
					  
					  if($result_pedidos_row['cajacorte'] == ''){
						  $c_corte = "0.00";
					  }else{
						  $c_corte = $result_pedidos_row['cajacorte'];
					  }
					  
					  if($result_pedidos_row['cajafinal'] == ''){
						  $c_final = "0.00";
					  }else{
						  $c_final = $result_pedidos_row['cajafinal'];
					  }
					  
					  $banco = number_format($tarjeta+$trasfer+$deposito,2,'.',',');
					  
					  $caja = number_format($efectivo + $result_pedidos_row['cajachica'],2,'.',',');
					  
				  ?>
               	  <td align="center" style="width:60px!important;"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
   				  <td><?php echo $f_inicio; ?></td>
   				  <td align="center">$ <?php echo $result_pedidos_row['cajachica']; ?></td>
                  <td align="center"><?php echo  $f_corte;?></td>
                  <td align="center">$ <?PHP echo $efectivo; ?></td>
                  <td align="center">$ <?PHP echo $tarjeta; ?></td>
                  <td align="center">$ <?PHP echo $trasfer;?></td>
                  <td align="center">$ <?PHP echo $deposito; ?></td>
                  <td align="center">$ <?PHP echo $cheque; ?></td>
                  <td align="center">$ <?PHP echo $virtual; ?></td>
                  <td align="center"><?php echo "$ ".$caja; ?></td>
                  <td align="center"><?php echo "$ ".$banco; ?></td>
                  <td align="center"><?PHP echo "$ ".$c_corte;?></td>
                  <td align="center">$ <?PHP echo $c_final;?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>
                  <td align="center">
                    <!--<input type="image" src="images/icn_categories.png" title="LISTAR PRODUCTOS" onclick="aparecermodulos('ventas/vi_productosPedido.php?id=<?php echo $result_pedidos_row['idnota_remision'];?>','main');">-->
                    <!--<input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')">-->
                    
                    <?php
					if($result_pedidos_row['estatus'] != 0){ 
					?>
                <input type="image" src="images/icono2.png" width="25" title="GENERAR CORTE" onclick="/*AbrirModalGeneral2('ModalPrincipal','900','560','ventas/fc_cortes.php?id=<?php echo $result_pedidos_row['idcorte']; ?>');*/ generarCorte('<?php echo $result_pedidos_row['idcorte']; ?>');">   
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


