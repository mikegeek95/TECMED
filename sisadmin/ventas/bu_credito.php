<?php



 require_once("../clases/conexcion.php");	 

     require_once("../clases/class.Credito.php");

	 require_once("../clases/class.Clientes.php");

try{

	  $db = new MySQL();



	  $client = new Clientes();

		

	$idcliente = $_POST['id_cliente'];

	$nombre = $_POST['nombre'];

	$paterno = $_POST['paterno'];

	$materno = $_POST['materno'];

	

	 $nombrec = $nombre." ".$paterno." ".$materno;

	/*echo "el ancho de la cadena es = ". strlen($nombrec)*/;

	  $client->db = $db;

	  

	  $sql_credito = "SELECT c.idcredito , c.fecha , c.idcliente , c.cantidad , c.estatus ,cl.nombre , cl.paterno , cl.materno  FROM credito c , clientes cl WHERE c.idcliente = cl.idcliente ";

	  

	  $sql_credito.= ($idcliente != '') ? " AND c.idcliente = $idcliente ":"" ; 

	  $sql_credito.= ( strlen($nombrec) > 2) ? " AND CONCAT(TRIM(cl.nombre),' ',TRIM(cl.paterno),' ',TRIM(cl.materno)) LIKE '%$nombrec%'  " : "" ;

	  

	  /*echo $sql_credito ;

	  exit ;*/

	  

	  $result_credito = $db->consulta($sql_credito );

	  $result_credito_row = $db->fetch_assoc($result_credito);

	  

	$estatus = array ("DEBE","PAGADO");

	  





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

				

				var oTable = $('#tbl_credito_r').dataTable( {		

					

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







<table  class="display" cellspacing="0" id="tbl_credito_r"> 

			<thead> 

				<tr> 

   					<th>ID CREDITO</th> 

    				<th>FECHA</th>

                    <th>CLIENTE</th>

                    <th>TOTAL</th>

                    <th>ESTATUS</th>

                    <th>ACCI&Oacute;N</th>

				</tr> 

			</thead> 

			<tbody> 

             <?php 

	 

	    do{

	 

	     

					

					

					

						$cliente = $result_credito_row['nombre'].' '.$result_credito_row['paterno'] .' '.$result_credito_row['materno'];

				    

					

					

					?>

            

          

            

				<tr> 

   				  <td style="text-align:center"><?php echo $result_credito_row['idcredito']; ?></td> 

   				  <td><?php echo $result_credito_row['fecha']; ?></td>

                  <td align="center"><?PHP echo utf8_encode ($cliente) ?></td>

                  <td align="center">$ <?php echo number_format($result_credito_row['cantidad'],2,'.',','); ?></td>

                  

                  <td style="text-align:center"><?php echo $estatus [ $result_credito_row['estatus']] ?></td> 

                  <td align="center"><input type="image" src="images/pay.png" title="PAGAR" onclick="aparecermodulos('ventas/fc_credito.php?id=<?php echo $result_credito_row['idcredito']?>','main')">

                    </td> 

				</tr>

                

                <?php

				}while ($result_credito_row= $db->fetch_assoc($result_credito));

				?>

 

            	

			</tbody> 

			</table>

	

        

		</div>







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