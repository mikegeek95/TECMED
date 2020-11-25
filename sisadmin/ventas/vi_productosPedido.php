<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");

$db = new MySQL();
$ventas = new Ventas();

$ventas->db = $db ;

$ventas->id_notaremision = $_GET['id'];

$ventas_result = $ventas->verClientePedido();

$id_notaremision = $ventas_result['idnota_remision'];
$fechapedido = $ventas_result['fechapedido'];
$fecha_pago = $ventas_result['fecha_pago'];
$tipo_pago = $ventas_result['tipo_pago'];
$tipo_descuento = $ventas_result['tipo_descuento'];
$facturado = $ventas_result['facturado'];
$no_factura = $ventas_result['no_factura'];
$corte = $ventas_result['corte'];
$subtotal = $ventas_result['subtotal'];
$iva = $ventas_result['iva'];
$total =$ventas_result['total'];
$desc_producto =$ventas_result['desc_producto'];
$desc_paquetes =$ventas_result['desc_paquetes'];
$desc_directo = $ventas_result['desc_directo'];
$estatus = $ventas_result['estatus'];


if($ventas_result['clientes'] != null)
 {	
		$nombrecliente = utf8_encode($ventas_result['clientes']);
		
 }else
 {
		$nombrecliente = "Publico General";
 }


/*foreach($productos as $p )
{
	$idproducto =  "idproducto". $p->idproducto ;
	$nombre =  "nombre=".$p->nombre;
	$pv = $p->pv;
	$cantidad = "cantidad".$p->cantidad;
}*/


?>




              
        <article class="module width_full">
		<header>
			<h3 class="tabs_involved">DATOS PEDIDO</h3>
           <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('ventas/vi_pedidos.php','main');">Ver Pedidos</a></li>
			</ul>
          <!--  <ul class="tabs">
                <li><a href="#" onClick="imprimirPDF('ventas/pdf/vi_pedidoPdf.php?id=<?php echo $ventas->id_notaremision;?>');">Imprimir </a></li>
			</ul>-->
            
             <ul class="tabs">
                <li><a href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $ventas->id_notaremision;?>');">Imprimir </a></li>
			</ul>
             
		</header>
        <div id="li_modulos" class="module_content" >
        
            <fieldset>
                <table width="90%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td>Nota Remisión:</td>
                    <td><?php echo $id_notaremision; ?></td>
                  </tr>
  <tr>
    <td width="18%">Fecha Pedido:</td>
    <td width="82%"><?php echo $fechapedido; ?></td>
    </tr>
  <tr>
    <td>Cliente: </td>
    <td><?php echo $nombrecliente; ?></td>
  </tr>
  <tr>
    <td>Factura:</td>
    <td><?php echo $no_factura; ?></td>
  </tr>
  <tr>
    <td>Estatus: </td>
    <td><?php echo $estatus; ?></td>
    </tr>
</table>
            
            
            </fieldset>
        
        
        
        </div>
        
        
        </article>       
              
                
       <article class="module width_full">
		<header>
			<h3 class="tabs_involved">DESCRIPCION DE PEDIDO</h3>
           
            
             
		</header>
		
		  <div id="li_modulos" class="tab_container">
       
			<table  class="tablesorter" cellspacing="0" id="d_modulos" style="width:100%"> 
			<thead> 
				<tr> 
   					<th align="center">ID PRODUCTO</th> 
    				<th align="center">PRODUCTO</th>
                    <th align="center">PRECIO</th>
                    <th align="center">CANTIDAD</th>
                    <th align="center">TOTAL</th>
                    
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     $productos = $ventas->listarProdctosenPedido();
	 
	     $Sumatotal = 0;
	 
	     foreach($productos as $p )
{
					
					
					$precio = $p->pv;
					$cantidad = $p->cantidad;
					
					$totales = $cantidad * $precio;
					
					 $Sumatotal = $Sumatotal + $totales;
					
					?>
            
          
            
				<tr> 
   				  <td style="text-align:center">P-<?php echo $p->idproducto; ?></td> 
   				  <td><?php echo utf8_encode($p->nombre); ?></td>
                  <td align="center">$ <?php echo number_format($precio,2,'.',','); ?></td>
                  <td align="center"><?PHP echo $cantidad; ?></td>
                  <td align="center"><?PHP echo number_format($totales,2,'.',','); ?></td>
                  
				</tr>
				
                <?php
				}
				?>
 
            	<tr>
            	  <td colspan="3" align="right" style="text-align: right">TOTAL SUMA</td>
            	  <td align="center">&nbsp;</td>
            	  <td align="center">$ <?PHP echo number_format($Sumatotal,2,'.',','); ?></td>
          	  </tr>
            	<tr>
				  <td colspan="3" align="right" style="text-align: right">SUBTOTAL:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($subtotal,2,'.',','); ?></td>
			  </tr>
				<tr style="background-color:#FFC">
				  <td colspan="3" align="right" style="text-align:right">DESC. PRODUCTO:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_producto,2,'.',','); ?></td>
			  </tr>
				<tr style="background-color:#FFC">
				  <td colspan="3" align="right" style="text-align:right">DESC. PAQUETE:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_paquetes,2,'.',','); ?></td>
			  </tr>
				<tr style="background-color:#FFC">
				  <td colspan="3" align="right" style="text-align:right">DES. DIRECTO:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($desc_directo,2,'.',','); ?></td>
			  </tr>
				<tr >
				  <td colspan="3" align="right" style="text-align:right">IVA:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($iva,2,'.',','); ?></td>
			  </tr>
				<tr>
				  <td colspan="3" align="right" style="text-align:right">TOTAL:</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">$ <?PHP echo number_format($total,2,'.',','); ?></td>
			  </tr>
                
			</tbody> 
			</table>
	<div class=".spacer"></div>
        
		</div>
     
     		
</article>

<div class="clear"></div>

 


