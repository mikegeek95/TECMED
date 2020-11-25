<?php
     header("Content-Type: text/text; charset=ISO-8859-1");
    
	require_once("../clases/conexcion.php");	 
    require_once("../clases/class.Ventas.php");
	require_once("../clases/class.Clientes.php");
    require_once("../clases/class.ShoppingCar.php");




	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
	  $carrito = new ShoppingCar();  

		
	  $vent->db = $db;
	  $client->db = $db;
	 
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');

 ?>
 
 
 <!--INICIAMOS A COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	<link rel="stylesheet" href="js/calendarios//themes/base/jquery.ui.all.css">
	<!--<script src="js/calendarios/jquery-1.7.2.js"></script>--> <!--QUITO ESTA LIBRERIA POR QUE CHOCA JUNTO CON LA TABLA-->
	<script src="js/calendarios/ui/jquery.ui.core.js"></script>
	<script src="js/calendarios/ui/jquery.ui.widget.js"></script>
	<script src="js/calendarios/ui/jquery.ui.datepicker.js"></script>
	
	
	
	<!--TERMINAMOS DE COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	
	
  
 <script>
 
  $(document).ready(function() {
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
	   
	
  });
  </script>
 
 <div class="module width_full">
 
 <article class="module width_full" style="display:none">
		<header>
			<h3 class="tabs_involved">CAJA</h3>
           <ul class="tabs">
   			<li><a href="#tab1">Clientes</a></li>
    		<li><a href="#tab2">Productos</a></li>
		</ul>
                        
		</header>
		
		  <div id="li_modulos" class="module_content">
         
         <div id="cod_product">
         <fieldset>
            <label>C&oacute;digo del Producto</label>
            <input name="codigo" id="codigo" type="text" style=" width:80%; border-radius: 3px; border:#000000 solid 1px; padding:3px;">
             
            <input type="button" value="Agregar" style=" float:left; margin-top: 3px; border-radius: 3px; border:#000000 solid 1px; padding:3px;">
            </fieldset>
         </div>
         
         
      
         <div id="botonera_puntodeventa" style="height:350px; width:100%; overflow:auto; border:#000000 solid 1px;">
          
             <?php 
                $carrito->verCarritoPuntodeVenta();
             ?>     
         
         </div>
           <div class="clear"></div>
       <div id="totales" style=" margin-top: 3px;width:100%; height:150px; overflow:auto; border:#000000 solid 1px;">
         
         </div>
         <div class="clear"></div>
         <div class="spacer"></div>
         
          </div>
          <footer>
          <div class="submit_link">
<!--           <input type="button" value="Buscar" onClick="buscarPedido('filtro');" >
-->           </div>
          </footer>
  </article>        
  


  <article class="module width_3_quarter">
		<header>
        <h3 class="tabs_involved">Productos</h3>
		<ul class="tabs">
   			<li style="background-color: #A7DDFF; color:#FFF; font-size:18px"><a href="#tab2">$ 4500,000.00 </a></li>
		</ul>
		</header>
        
        <div class="tab_container" style="min-height:400px; height:400px;">
        
          <div class="message_list" style="height:290px; overflow:auto; ">
                <div class="module_content" >
				
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                      
                      	<thead> 
                          
                      	</thead> 
                        <tbody> 
                          <tr class="message" onclick="alert('descripcion del producto')">
                            <td>PRODUCTO DE CAMISAS Y JOYAS HERMOSAS</td>
                            <td align="center">5</td>
                            <td>$ 50.00</td>
                          </tr>
                          
                          <tr class="message" onclick="alert('descripcion del producto')">
                            <td>PRODUCTO DE CAMISAS Y JOYAS HERMOSAS</td>
                            <td align="center">5</td>
                            <td>$ 50.00</td>
                          </tr>
                          
                          <tr class="message" onclick="alert('descripcion del producto')">
                            <td>PRODUCTO DE CAMISAS Y JOYAS HERMOSAS</td>
                            <td align="center">5</td>
                            <td>$ 50.00</td>
                          </tr>
                        <tbody>
                        </table>
                    
			 </div>
		  </div>
            <div>
            
             <table width="100%" border="0" cellspacing="2" cellpadding="2">
                      
                      	<thead> 
                        </thead> 
                        <tbody> 
                          <tr  onclick="alert('descripcion del producto')">
                            <td width="88%" align="right">CANTIDAD DE PRODUCTOS</td>
                            <td width="5%" align="center">5</td>
                            <td width="7%">&nbsp;</td>
                          </tr>
                          
                          <tr  onclick="alert('descripcion del producto')">
                            <td colspan="2" align="right">SUBTOTAL</td>
                            <td>$ 50.00</td>
                          </tr>
                          
                          <tr  onclick="alert('descripcion del producto')">
                            <td colspan="2" align="right">DESCUENTO</td>
                            <td>$ 50.00</td>
                          </tr>
                          <tr  onclick="alert('descripcion del producto')">
                            <td colspan="2" align="right">I.V.A.</td>
                            <td>$ 50.00</td>
                          </tr>
                          <tr onclick="alert('descripcion del producto')">
                            <td colspan="2" align="right">TOTAL</td>
                            <td>$ 50.00</td>
                          </tr>
                        <tbody>
                        </table>
               
            </div>
        </div>
            <footer>
				<div class="submit_link">
					<input type="submit" value="PAGAR" class="alt_btn">
				</div>
			</footer>
  </article>
  
  		<article class="module width_quarter">
        
        <header>
        <h3 class="tabs_involved">Productos</h3>
		
		</header>
        
        		<div class="message_list" style="height:400px; overflow:auto">
                <div>COD. </div>
			</div>
			<footer>
				
			</footer>
		</article>
        <DIV class="clear"> </DIV>
<div class="spacer"></div>
</div>