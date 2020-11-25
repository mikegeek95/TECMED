<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();
header("Content-Type: text/text; charset=ISO-8859-1");


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

    
	 require_once("../clases/conexcion.php");	 
     require_once("../clases/class.Ventas.php");
	 require_once("../clases/class.Clientes.php");
	 require_once("../clases/class.Sucursales.php");

	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
	  $suc = new Sucursales();
		
	  $vent->db = $db;
	  $client->db = $db;
	  $suc->db = $db;
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');
	  
	  $tipo = $_SESSION['se_sas_Tipo'];
	  
if(isset($_GET['ac']))
{
	if($_GET['ac']==1){
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}else{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
		echo '<script type="text/javascript">buscarCorte("filtro");</script>';
	}
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	echo $msj;
}

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
	

 ?>
 
 
 <!--INICIAMOS A COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	<link rel="stylesheet" href="js/calendarios//themes/base/jquery.ui.all.css">
	<!--<script src="js/calendarios/jquery-1.7.2.js"></script>--> <!--QUITO ESTA LIBRERIA POR QUE CHOCA JUNTO CON LA TABLA-->
	<script src="js/calendarios/ui/jquery.ui.core.js"></script>
	<script src="js/calendarios/ui/jquery.ui.widget.js"></script>
	<script src="js/calendarios/ui/jquery.ui.datepicker.js"></script>
	
	
	
	<!--TERMINAMOS DE COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	
	
  
 <script>
 
    $("#inicio").datepicker({ 
	   dateFormat: "yy-mm-dd", 
	   changeMonth: true,
       changeYear: true,
	   inline: true
	   });
	   
	   $("#f_fin").datepicker({ 
	   dateFormat: "yy-mm-dd", 
	   changeMonth: true,
       changeYear: true,
	   inline: true
	   });
	   
	
  </script>
  <!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				/*var oTable = $('#d_modulos').dataTable( {		
					
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
					  
					  
						
				} );*/
				} );
				
				</script>
 
 
 <article class="module width_full">
		<header>
			<h3 class="tabs_involved">CORTES</h3>
             <ul class="tabs">
                <li ><a href="#" onClick="AbrirModalGeneral2('ModalPrincipal','900','560','ventas/fa_cortes.php');"> Iniciar Caja</a></li>
			</ul>
            
             
		</header>
		
		  <div id="li_modulos" class="module_content">
          <fieldset style="width:100%">
          
          	<form action="" name="filtro" id="filtro">
            <table >
              <tr>
                <td  align="center">No. Corte</td>
                <td  align="left"><input style="width:110px; " type="text" id="v_idventa" name="v_idventa" ></td>
                <td  align="center">Sucursal</td>
                <td  align="left">
                	<select id="sucursal" name="sucursal" style=" width:116px; display:block" title="Sucursal">
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
						?>
            		</select>
                	
                </td>
              </tr>
              <tr>
                <td  align="center"><label for="inicio" style="width:100px; ">Fecha Inicio:</label></td>
                <td  align="left"><input style="width:110px; " type="text" id="inicio" name="inicio" ></td>
                <td  align="center"><label for="fin" style="width:100px; ">Fecha Fin:</label></td>
                <td  align="left"><input style="width:110px; " type="text" id="f_fin" name="f_fin"></td>
                <td>
                	<div class="submit_link">
                    	<input type="button" value="Buscar" onClick="/*buscarPedido('filtro');*/ buscarCorte('filtro');" >
                    </div>
                </td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="left">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="left">&nbsp;
                    
                </td>
                <td>&nbsp;
                	
                </td>
              </tr>
            </table>
            </form>
          </fieldset>
         
          <!--############### tabla de pedidos #############-->
                          

    <div id="li_pedidos" class="tab_container">
    	<table  class="tablesorter" cellspacing="0" id="d_modulos"  style="display:none;"> 
        <thead> 
            <tr> 
                <th align="center">ORD. COMP.</th> 
                <th align="cealign=">FECHA</th>
                <th align="center">NOMBRE</th>
                <th align="center">TOTAL</th>
                <th align="center">ESTATUS</th>
                <th align="center">SUCURSAL</th>
                <th align="center">ACCI&Oacute;N</th>
            </tr> 
        </thead> 
        <tbody> 
        <?php 
		if($tipo == 0){
	    	//$pedidos = $vent->Lista_Pedidos_Pendientes();
		}else{
			$idsucursales = $_SESSION['se_sas_Sucursal'];
			$vent->idsucursales = $idsucursales;
			//$pedidos = $vent->Lista_Pedidos_Pendientes_sucursal();
		}
	     foreach($pedidos as $pedidos)
            {
				if($pedidos->idcliente != 0)
                {
                    $pedidos->idcliente ;
                    $client->idCliente = $pedidos->idcliente;								
                    $result_cliente = $client->ObtenerInformacionCliente();					
                    $cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
                }else
                {
                   $cliente = "VENTANILLA";			
                 }
                ?>
            <tr> 
              <td style="text-align:center"><?php echo $pedidos->idnota_remision; ?></td> 
              <td><?php echo $pedidos->fechapedido; ?></td>
              <td align="left"><?php echo $cliente; ?></td>
              <td align="center">$ <?php echo number_format($pedidos->total,2,'.',','); ?></td>
              <td align="center"><?PHP echo $estatus[$pedidos->estatus]; ?></td>
              <?php
			  	$idsucursal = $pedidos->idsucursales;
				$sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
				$result_sucursal = $db->consulta($sql_sucursal);
				$result_sucursal_row = $db->fetch_assoc($result_sucursal); 
			  ?>
              <td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
              <td align="center">
                <!--<input type="image" src="images/icn_categories.png" title="LISTAR PRODUCTOS" onclick="aparecermodulos('ventas/vi_productosPedido.php?id=<?php echo $pedidos->idnota_remision;?>','main');">-->
                <input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $pedidos->idnota_remision; ?>')">
               	<input type="image" src="images/icn_logout.png" title="CANCELAR" onclick="cancelarPedidoPagado('<?php echo $pedidos->idnota_remision; ?>')">
                
                
              </td> 
            </tr>
            
            <?php
            }
            ?>
        </tbody> 
        </table>

</div>

</div>
<br />
<br />

<footer>

</footer>
  </article>        
  
    
 
 
