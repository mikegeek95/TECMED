<?php



require_once ("../clases/conexcion.php");

require_once ("../clases/class.Credito.php");

try{



$db = new MySQL ();

$credito = new creditos ();



$credito->db = $db ;







 $credito->idcretdito= $_GET['id'];



$result_credito = $credito->obtenerDatosCredito();









?>





<article class="module width_full">

		<header>

			<h3 class="tabs_involved">HISTORIAL DE PAGOS</h3>

            <ul class="tabs">

                <li><a href="#" onClick="aparecermodulos('ventas/vi_credito.php','main');">Ver Creditos</a></li>

                

			</ul>

            

            <ul class="tabs">

            <li><a href="#" onclick="reciboCreditoH ('<?php echo $credito->idcretdito ?>')">Imprimir Historial</a></li>

            </ul>

             

		</header>

        

        <div id="result_historial" style="height:250px; overflow:auto">

        

        

        <?php

         $sql_historial = "SELECT 

 cd.idcredito ,

 c.idnota_remision , 

 DATE(cd.fecha_deposito) AS fecha, 

cd.deposito ,

 CONCAT(cl.nombre,' ',cl.paterno,' ',cl.materno) AS cliente





 FROM credito c , credito_detalle cd , clientes cl 

WHERE

c.idcredito = cd.idcredito 

AND

c.idcliente = cl.idcliente AND c.idcredito = '$credito->idcretdito'";

			

			$result_historial = $db->consulta($sql_historial);

			$result_historial_row = $db->fetch_assoc($result_historial);

			$result_historial_row_num = $db->num_rows($result_historial);

		

		?>

        

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

				

				var oTable = $('#tbl_historial').dataTable( {		

					

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

        

        

        <table  class="display" cellspacing="0" id="tbl_historial"> 

			<thead> 

				<tr> 

   					<th>ID CRÉDITO</th> 

    				<th>FECHA</th>

                    <th>ID NOTA REMISIÓN</th>

                    <th>CLIENTE</th>

                    <th>PAGO</th>

				</tr> 

			</thead> 

			<tbody> 

             <?php 

			 

	 	if ($result_historial_row_num != 0 ){

	    do{

	 

	     

					

					

					

													

						

				    

					

					

					?>

            

          

            

				<tr> 

   				  <td style="text-align:center"><?php echo $result_historial_row['idcredito']; ?></td> 

   				  <td><?php echo $result_historial_row['fecha']; ?></td>

                  <td style="text-align:center"><?php echo $result_historial_row['idnota_remision']; ?></td> 

                  <td align="center"><?PHP echo utf8_encode ($result_historial_row['cliente']) ?></td>

                  

                  <td align="center">$ <?php echo number_format($result_historial_row['deposito'],2,'.',','); ?></td>

                 

				</tr>

                

                <?php

				}while ($result_historial_row = $db->fetch_assoc($result_historial));

		}//fin del if ($result_historial_row_num != 0 )

				?>

 

            	

			</tbody> 

			</table>

        

        

        

        

        

        

        </div>

        

        

        

</article>        







<article  class="module width_half">

		<header>

			<h3 class="tabs_involved">CRÉDITO</h3>

            <!--<ul class="tabs">

                <li><a href="#" onClick="aparecermodulos('ventas/vi_credito.php','main');">Ver Creditos</a></li>

			</ul>-->

            

             

		</header>

        

          <div class="module_content">

        

       <fieldset>

       		<div style="width:150px; margin-right:20px; ">

                    <label for="pago" >Pago:</label>

                    <input type="text"  name="pagoC" id="pagoC" title="Pago" />

           

           </div>

           

           <div style="width:150px;  margin-left:10px;">

           		<label for="tipo">Tipo de Pago:</label>

                <select id="tipo" name="tipo">

                	<option value="0">Efectivo</option>

                    <option value="1">Tarjeta</option>

                    <option value="2">Deposito</option>

                </select>

           

           </div>

           

           <div style="width:200px;">

           	<label>Descripción</label>

            <textarea name="descr" rows="5" id="descr"></textarea>

           

           </div>

           

           

           

           

       

       </fieldset>

       </div>

       

       <footer>

            <div class="submit_link">

           			<input type="button" id="btn_alt" class="alt_btn" value="Pagar" onClick="var resp = MM_validateForm('pagoC','','RisNum'); if (resp == 1){ pagarC ('<?php echo $credito->idcretdito ?>'); }" >

           </div>

          </footer>

</article>





<article id="deuda"  class="module width_half">

<?php



$deuda = $credito->obtenerDeuda();

$pagos = $credito->totalPagos();

?>

		<header>

			<h3 class="tabs_involved">DATOS DE ADEUDO</h3>

            

            

             

		</header>

        

          <div class="module_content">

          	<center>

            <table width="413" border="0">

              <tr>

                <td width="142" align="right">Cliente:</td>

                <td width="261"><?php echo utf8_encode ($deuda['cliente']);?></td>

              </tr>

              <tr>

                <td align="right">Id Nota Remision:</td>

                <td><?php echo $deuda['idnota_remision'];?></td>

              </tr>

              <tr>

                <td align="right">Total de Pagos:</td>

                <td><?php echo $pagos['totalp'];?></td>

              </tr>

              <tr>

                <td align="right">Adeudo:</td>

                <td>$<?php echo $deuda['debe'];?></td>

              </tr>

            </table>

            </center>

          </div>

</article> 







<div class="clear"></div>



<article id="ventanaR" style="margin-top:50px; margin-top:20px; display:none;" class="module width_full">

		<header>

			<h3 id="tituloC" class="tabs_involved">COMPROBANTE DE PAGO</h3>

            

            

             

		</header>

        <div class="module_content">

         <center>

        	

        	<iframe src="ventas/pdf/recibo_pago.php" height="600" width="600" id="recibo"></iframe>

        	

         </center>

        </div> 

</article>        











<?php

}//fin del try

catch (Exception $e)

{

	$v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;

	

}









?>