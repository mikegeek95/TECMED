<?php
     
	
     require_once("../clases/conexcion.php");

	 require_once("../clases/class.ShoppingCar.php");


	 $db = new MySQL ();
	 
	$carrito = new ShoppingCar ();

	 


 ?>
 
 


<article   class="module width_full">

		<header>
			<h3 class="tabs_involved">ENTREGA</h3>
            
            
             
		</header>
        
        <div  class="module_content">
        
        	<fieldset>
             <div>
              <form>
                <label for="id_nota_remision">Id Nota de Remisi&oacute;n:</label>
            	<input title="Id Nota de Remision"  value="<?php if (isset ($_GET['idnota_remision'])){ echo $_GET['idnota_remision']; }?>" type="text" style="width:200px;" id="id_nota_remision" onKeyUp="vallida_idnota_remision_Entrega(); " />
                <span id="msj_erro"></span>
                <br><br>
                <input id="alt_btn" style="margin-left:20px;" onClick="var resp = MM_validateForm('id_nota_remision','','RisNum'); if (resp == 1) { buscarEntrega();   }" type="button" value="Aceptar">
             
             <!--g_entrega();-->
             
             </form>
             </div>
             </fieldset>
             
             
             
             <fieldset>
            	<table>
            		<tr>
            			<td align="right">Nombre:</td>
            			<td align="center"><span id="nombre"></span></td>
           		  </tr>
            		<tr>
            			<td align="right">Id Pedido:</td>
            			<td align="center"><span id="idPedido"></span></td>
           		  </tr>
            		<tr>
            			<td align="right">Cantidad Productos:</td>
            			<td align="center"><span id="candidadP"></span></td>
           		  </tr>
            	</table>
          </fieldset>
            
        </div>
        
</article>        





<article style="height:300px; overflow:auto;"   class="module width_full">

		<header>
			<h3 class="tabs_involved">LISTA DE PRODUCTOS</h3>
            
            
             
		</header>
        <div id="tabla_result">
        <div class="module_content" >
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
				
				var oTable = $('#tbl_totalP').dataTable( {		
					
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
        
        
        <table  class="tablesorter" cellspacing="0" id="tbl_totalP"> 
			<thead> 
				<tr> 
   					<th>ID PRODUCTO</th> 
    				<th>NOMBRE</th>
                    <th>CANTIDAD</th>
                    
				</tr> 
			</thead> 
			<tbody> 
             <?php 
			 
	 	/*if ($result_historial_row_num != 0 ){
	    do{
	 */
	     
					
					
					
													
						
				    
					
					
					?>
            
          
            
				<tr> 
   				  <td style="text-align:center"><?php //echo $result_historial_row['idcredito']; ?></td> 
   				  <td><?php //echo $result_historial_row['fecha']; ?></td>
                  <td style="text-align:center"><?php //echo $result_historial_row['idnota_remision']; ?></td> 
                 
                 
				</tr>
                
                <?php
				//}while ($result_historial_row = $db->fetch_assoc($result_historial));
		//}//fin del if ($result_historial_row_num != 0 )
				?>
 
            	
			</tbody> 
			</table>
        
        </div>
        </div>
        
        
        
</article>



<article id="ordeEntrega" class="module width_full" >
		<header>
        <h3 id="titulo" class="tabs_involved">PRODUCTO</h3>
        
        
		</header>

		<div class="module_content">
        <fieldset>
            <form>
                 <label for="alt_btn">Codigo Producto</label>
                 <input style="width:200px; margin-left:-20px;" onKeyPress="bloquear_enie(event.keyCode); AgregarCestaEntrega(event.keyCode);"  type="text"  id="v_codigo" onclick="">
             </form>
        </fieldset> 
        </div>
        <footer>
          <div class="submit_link">
        	<input  type="submit" value="Generar Entrega" id="ent_btn" class="alt_btn" onclick="g_entrega ();">
           </div> 
        </footer>
</article>        



	<article id="reporteEntrega" class="module width_full" >
		<header>
        <h3 id="titulo" class="tabs_involved">DESCRIPCION ENTREGA</h3>
         
        
         
		<ul class="tabs">
        <li><a href="#tab2" onclick="eliminarTodoCarritoEntrega('itemsEnCestaEntrega','descripcion_carrito');">Eliminar Productos</a></li>
        </ul>
        
        
       
		</header>



		<div class="tab_container">
			<div id="descripcion_carrito" class="tab_content" style="height:200px; overflow:auto;" >
        <?php
          $carrito->verCarritoEntrega();		
		?>
        </div>
       </div>
</article>



<?php if (isset ($_GET['idnota_remision'])){ echo '

<script type="text/javascript"> 
		buscarEntrega();
</script>
'; }?>
