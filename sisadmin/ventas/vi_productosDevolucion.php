<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Devoluciones.php");
require_once("../clases/class.Configuracion.php");


$db = new MySQL();

$dev = new Devoluciones();

$conf = new Configuracion();

$dev->db = $db;
$conf->db = $db;

$idcliente_devolucion = $_GET['id'];

$dev->iddevolucion = $idcliente_devolucion;

$sql = "SELECT cd.*, n.idcliente FROM cliente_devolucion cd, nota_remision n  WHERE cd.idnota_remision = n.idnota_remision AND cd.idcliente_devolucion = '$idcliente_devolucion'";

$result_devo = $db->consulta($sql);
$result_devo_row = $db->fetch_assoc($result_devo);
$result_devo_num = $db->num_rows($result_devo);

$fecha_dev = $result_devo_row['fecha'];
$estatus_dev = $result_devo_row['estatus'];
$total_dev = $result_devo_row['total'];
$desc_dev = $result_devo_row['descuento'];
$iva_dev = $result_devo_row['iva'];
$subtotal_dev = $result_devo_row['subtotal'];


if($result_devo_row['idcliente'] != 0)
 {
	 $idcliente = $result_devo_row['idcliente'];
	 	
	//buscamos al cliente
	$sql_cliente = "SELECT * FROM clientes WHERE idcliente = '$idcliente'";	
	$result_cliente = $db->consulta($sql_cliente);
	$result_cliente_row = $db->fetch_assoc($result_cliente);
  
	$nombrecliente = $result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno'];
 }else
 {
	$nombrecliente = "Publico General";
 }

$estatus  = array('Cancelada','Realizada');


//Consultamos configuracion para impresion
$result_conf = $conf->ObtenerInformacionConfiguracion();

$impresion = $result_conf['notas_print'];
?>



<div id="main2">

<div id="ModalSecundaria" class="ventana">
<div id="Close" style="text-align: right">
      <img src="images/004.png" width="16" height="16" onClick="$('#ModalSecundaria').css('display','none'); $('#contenido_modal_dos').html('');" style="cursor:pointer">
</div>

    <div id="contenido_modal_dos" >
   
    </div>

</div>

              
        <article class="module width_full">
		<header>
			<h3 class="tabs_involved">DATOS DEVOLUCIÓN</h3>
           <!--<ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('ventas/vi_devolucion.php','main');">Ver Devoluciones</a></li>
			</ul>-->
          <!--  <ul class="tabs">
                <li><a href="#" onClick="imprimirPDF('ventas/pdf/vi_pedidoPdf.php?id=<?php echo $ventas->id_notaremision;?>');">Imprimir </a></li>
			</ul>-->
            
             <ul class="tabs">
                <li>
                	<!--<a href="#" onClick="imprimirPDFSecundaria('ventas/pdf/devolucion.php?id=<?php echo $idcliente_devolucion;?>');">Imprimir </a>-->
                    
                    <?php
					if($impresion == 0){ 
					?>
                    <a href="#" onClick="imprimirPDFSecundaria('ventas/pdf/devolucion.php?id=<?php echo $idcliente_devolucion;?>');">Imprimir </a>
                    <?Php
					}else{
					?>
                    
                    <a href="#" onClick="imprimirPDFSecundaria('ventas/pdf/devolucion_termica.php?id=<?php echo $idcliente_devolucion;?>');">Imprimir </a>
                    
                    <?Php
					}
					?>
               	</li>
			</ul>
             
		</header>
        <div id="li_modulos" class="module_content" >
        
            <fieldset>
                <table width="90%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td>No Devoluci&oacute;n:</td>
                    <td><?php echo $idcliente_devolucion; ?></td>
                  </tr>
  <tr>
    <td width="18%">Fecha Devoluci&oacute;n:</td>
    <td width="82%"><?php echo $fecha_dev; ?></td>
    </tr>
  <tr>
    <td>Cliente: </td>
    <td><?php echo $nombrecliente; ?></td>
  </tr>
  <!--<tr>
    <td>Factura:</td>
    <td><?php echo $no_factura; ?></td>
  </tr>-->
  <tr>
    <td>Estatus: </td>
    <td><?php echo $estatus[$estatus_dev]; ?></td>
    </tr>
</table>
            
            
            </fieldset>
        
        
        
        </div>
        
        
        </article>       
              
                
       <article class="module width_full">
		<header>
			<h3 class="tabs_involved">DESCRIPCION DE DEVOLUCIÓN</h3>
           
            
             
		</header>
		
		  <div id="li_modulos" class="tab_container">
       
			<table  class="tablesorter" cellspacing="0" id="d_modulos" style="width:100%; color:#666;"> 
			<thead> 
				<tr> 
   					<th align="center">ID PRODUCTO</th> 
    				<th align="center">PRODUCTO</th>
                    <th align="center">CANTIDAD</th>
                    <th align="center">PRECIO</th>
                    <th align="center">% DESC</th>
                    <th align="center">DESCUENTO</th>
                    <th align="center">TOTAL</th>
                    
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     //$productos = $ventas->listarProdctosenPedido();
		 $productos = $dev->listarProdctosenDevolucion();
	     $Sumatotal = 0;
	 
	     foreach($productos as $p )
{
					
					
					$precio = $p->pv;
					$cantidad = $p->cantidad;
					
					
					?>
            
          
            
				<tr> 
   				  <td style="text-align:center">P-<?php echo $p->idproducto; ?></td> 
   				  <td><?php echo utf8_encode($p->nombre); ?></td>
                  <td align="center"><?PHP echo $cantidad; ?></td>
                  <td align="center">$ <?php echo number_format($precio,2,'.',','); ?></td>
                  <td align="center"><?php echo $p->porc_desc; ?> %</td>
                  <td align="center">$ <?php echo number_format($p->total_descuento,2,'.',','); ?></td>
                  <td align="center"><?PHP echo number_format($p->total,2,'.',','); ?></td>
                  
				</tr>
				
                <?php
				}
				?>
 
            	<!--<tr>
            	  <td colspan="5" align="right" style="text-align: right">TOTAL SUMA</td>
            	  <td align="center">&nbsp;</td>
            	  <td align="center">$ <?PHP echo number_format($Sumatotal,2,'.',','); ?></td>
          	  </tr>-->
            	<tr>
				  <td colspan="5" align="right" style="text-align: right">SUBTOTAL:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($subtotal_dev,2,'.',','); ?></td>
			  </tr>
				<!--<tr style="background-color:#FFC">
				  <td colspan="5" align="right" style="text-align:right">DESC. PRODUCTO:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_producto,2,'.',','); ?></td>
			  </tr>
				<tr style="background-color:#FFC">
				  <td colspan="5" align="right" style="text-align:right">DESC. PAQUETE:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_paquetes,2,'.',','); ?></td>
			  </tr>
				<tr style="background-color:#FFC">
				  <td colspan="5" align="right" style="text-align:right">DES. DIRECTO:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_directo,2,'.',','); ?></td>
			  </tr>
				<tr>
				  <td colspan="5" align="right" style="text-align:right">IVA:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($iva,2,'.',','); ?></td>
			  </tr>-->
              
              	<tr style="background-color:#FFC;">
				  <td colspan="5" align="right" style="text-align:right">DESCUENTO:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_dev,2,'.',','); ?></td>
			  </tr>
              
				<tr>
				  <td colspan="5" align="right" style="text-align:right">TOTAL:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($total_dev,2,'.',','); ?></td>
			  </tr>
                
			</tbody> 
			</table>
	<div class=".spacer"></div>
        
		</div>
     
     		
</article>

<div class="clear"></div>
</div>
 


