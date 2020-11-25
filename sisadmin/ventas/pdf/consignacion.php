<?php
    header("Content-Type: text/text; charset=ISO-8859-1");
    require_once("../clases/conexcion.php");
	require_once("../clases/class.Consignacion.php");
	require_once("../clases/class.Fechas.php");	
	$db = new MySQL();
	$con = new Consignacion();
	$f = new Fechas();
	
	$con->db = $db;


    //recibimos el id
	
	$id = $_GET['id'];
	
	$row_consignacion = $con->ObtenerDatosdeConsignacionID($id);
	
	$row_consignacion_detalle = $con->ObtenerDetallesdeConsignacionID($id);
	
	
	//sacamos los valores del array
	
	foreach($row_consignacion as $row)
	  {
		  $nombre = $row->nombre;
		  $idcliente = $row->idcliente;
		  $fecha = $row->fecha;
		  $estatus = $row->estatus;
	  }
	
	
	
	//var_dump($row_consignacion);
	
	$num = count($row_consignacion);
	


?>


    <style>
   @media print {
	   
    div,a {display:none}
    .ver {display:block}
    .nover {display:none}
}


#page-wrap { width: 90%; margin: 0 auto; }
table { border-collapse: collapse; }
table td, table th { border: 1px solid black; padding: 5px; }

#header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white;  text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

#address { width: 250px; height: 70px; float: left; }
#customer { overflow: hidden; }

#logo { text-align: right; float: right; position: relative; margin-top: 0px; border: 0px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }
/* #logo:hover { border: 1px solid #000; margin-top: 0px; max-height: 125px; } */
#logoctr { display: none; }
#logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 0px; }
#logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
#logohelp input { margin-bottom: 5px; }
.edit #logohelp { display: block; }
.edit #save-logo, .edit #cancel-logo { display: inline; }
.edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
#customer-title { font-size: 20px; font-weight: bold; float: left; }

#meta { margin-top: 1px; width: 150px; float: right; }
#meta td { text-align: right;  }
#meta td.meta-head { width: 70px; text-align: left; background: #eee; }
#meta td textarea { width: 100%; height: 20px; text-align: right; }

#items { clear: both; width: 100%; margin: 10px 0 0 0; border: 1px solid black; }
#items th { background: #eee; }
#items textarea { width: 80px; height: 50px; }
#items tr.item-row td { border: 0; vertical-align: top; }
#items .item-row:hover { background-color:#999; color:#FFF}
#items td.description { width: 300px; }
#items td.item-name { width: 175px; }
#items td.description textarea, #items td.item-name textarea { width: 100%; }
#items td.total-line { border-right: 0; text-align: right; }
#items td.total-value { border-left: 0; padding: 10px; }
#items td.total-value textarea { height: 20px; background: none; }
#items td.balance { background: #eee; }
#items td.blank { border: 0; }

#terms { text-align: center; margin: 20px 0 0 0; }
#terms h5 { text-transform: uppercase; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
#terms textarea { width: 100%; text-align: center;}

textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { background-color:#EEFF88; }

.delete-wpr { position: relative; }
.delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-size: 12px; }
    
    </style>

<script>
function printdiv(id_div){
var content = document.getElementById(id_div);
var printscreen = window.open('','','left=1,top=1,width=1,height=1,toolbar=0,scrollbars=0,status=0');
printscreen.document.write(content.innerHTML);
printscreen.document.close();
printscreen.focus();
printscreen.print();
printscreen.close();
}
</script>

<article class="module width_full">
    <header>
   		<h3 class="tabs_involved">NOTA DE CONSIGNACION</h3>
        <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('ventas/vi_consignacion.php','main');">Lista</a></li>
	  </ul>
      
     <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('ventas/fa_consignacion.php','main');">Nueva</a></li>
	  </ul>
      
        <ul class="tabs">
                <li><a href="#"  onclick="ventanaSecundaria('ventas/pdf/pdf_asignacion.php?id=<?php echo $id;?>','Imp. Consiganción','',600,500,'true')">Imprimir</a></li>
	  </ul>
  
    </header>
    
    <div class="module_content">

    


	<div id="page-wrap">

		
		<div id="identity">
		
        <table id="address" style="border:1px #000  thin; line-height:12px;">
        	<tr >
        		<td id="cliente">ID SOCIO: <?php echo $idcliente; ?></td>        		
        	</tr>
            <tr>
            	<td> 7 Ote. entre 1 y 2 Sur 251Tuxtla Gutierrez, Chiapas, C.P 29000 </td>
            </tr>
            <tr>
            	<td>Tel&eacute;fono: (961) 61-37757</td>        		
            </tr>
           
        </table>
     

            <div id="logo">
              <img src="images/logo1.png" alt="logo" width="149" height="93" id="image" />
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

            <div id="customer-title">Socio: <?php echo $nombre; ?></div>

            <table id="meta">
                <tr>
                    <td width="131" class="meta-head">ID #</td>
                    <td width="157"><div><?php echo $id;?></div></td>
                </tr>
                <tr>

                    <td class="meta-head">Fecha</td>
                    <td><div id="date"><?php echo $f->fecha_esp($fecha);?></div></td>
                </tr>
                <!--<tr>
                    <td class="meta-head">Cuenta</td>
                    <td><div class="due">$875.00</div></td>
                </tr>-->

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th width="175">C&oacute;digo</th>
		      <th width="387">Descripci&oacute;n</th>
		      <th width="102">Costo</th>
		      <th width="70">Cantidad</th>
		      <th width="137">Precio</th>
		  </tr>
		  
		  
          <?php
          //realizamos el while para impresion 
		  
		  $montoapagar = 0;
		  $cantidadprodu = 0;
		  
		  foreach($row_consignacion_detalle as $detalle)
		  {
			  
			  $idproducto = $detalle->idproducto;
			  $nombre_producto = $detalle->nombre;
			  $descripcion_producto = $detalle->descripcion;
			  $pv = $detalle->pv;
			  $cantidad = $detalle->cantidad;
			  
			  $precio = $pv * $cantidad;
			  
			  $montoapagar = $montoapagar + $precio;
			  
			  $cantidadprodu = $cantidadprodu + $cantidad;
			  
			  
		  
		  ?>
          
          <tr class="item-row">
		      <td align="center" class="item-name">
              <div><?php echo $detalle->idproducto; ?></div>
		      </td>
		      <td class="description"><div><?php echo $nombre_producto; ?></div></td>
		      <td align="center"><div class="cost">$ <?php echo number_format($pv,2,'.',',') ?></div></td>
		      <td align="center"><div class="qty"><?php echo $cantidad; ?></div></td>
		      <td align="center">$ <?php echo number_format($precio,2,'.',','); ?></td>
		  </tr>
		  
		  <?php
		  }
		  	  
          //terminamos 
		  
		  //obtendremos el iva y el subtotal
		  
		  $iva = $montoapagar-($montoapagar / 1.16);
		  $subtotal = $montoapagar-$iva;
		  
		  
		  ?>
		  
         
		  
		  <tr>
		    <td colspan="2" class="blank"></td>
		    <td class="total-line">Cantidad Producto:</td>
		    <td align="center" valign="middle" class="total-line" style="text-align:center"><?php echo $cantidadprodu; ?></td>
		    <td class="total-value">&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="2" class="blank"></td>
		    <td colspan="2" class="total-line">&nbsp;</td>
		    <td class="total-value">&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="2" class="blank"></td>
		    <td colspan="2" class="total-line">&nbsp;</td>
		    <td class="total-value">&nbsp;</td>
	      </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$<?php echo number_format($subtotal,2,'.',',')?></div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">I.V.A</td>
		      <td class="total-value"><div id="total">$<?PHP echo number_format($iva,2,'.',',');?></div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Monto a Pagar</td>
		      <td class="total-value balance"><div class="due">$<?php echo number_format($montoapagar,2,'.',',');?></div></td>
		  </tr>
		
		</table>
		
		<div id="terms">
		  <h5>Terminos y condiciones</h5>
		  <div>Interes del 5% al no realizar la entrega y pago del producto a los 15 dias.</div>
		</div>
	
	</div>
    </div>
	</article>
    <footer>
				<div class="submit_link">
					<select>
						<option>Draft</option>
						<option>Published</option>
					</select>
					<input type="submit" value="Publish" class="alt_btn">
					<input type="submit" value="Reset">
				</div>
			</footer>