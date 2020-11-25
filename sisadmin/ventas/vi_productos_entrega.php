<?php
/*echo 1;
exit;*/
require_once("../clases/conexcion.php");
require_once("../clases/class.Sesion.php");


$db = new MySQL ();
$s = new Sesion();

if (isset ($_SESSION['vi_productos_entrega']) )
{
	$s->eliminarSesion('vi_productos_entrega');
	 //$_SESSION['vi_productos_entrega'] ;
	 $s->crearSesion('vi_productos_entrega',null) ;
}
else 
{
	//$_SESSION['vi_productos_entrega'];
	$s->crearSesion('vi_productos_entrega',null) ;
}




$id = $_POST['idnota_remision'];
 $sql_tabla = "SELECT
					nd.idproducto ,
					nd.cantidad,
					p.nombre
					FROM
					nota_descripcion nd , productos p
					WHERE
					
					nd.idproducto = p.idproducto
					
					AND
					
					nd.idnota_remision = '$id'
					";
		 $result_tabla = $db->consulta($sql_tabla);			
		 $result_tabla_row = $db->fetch_assoc($result_tabla);
		 
 ?>		
         
         <div class="module_content">
         
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
         do
		 {
			 //creo la sesion y en la sesion le pongo el valor del idproducto, y le igualo la cantidad
			 $_SESSION['vi_productos_entrega'][$result_tabla_row['idproducto']] = $result_tabla_row['cantidad'];
			 
			 
		 ?>
         <tr <?php
		 		foreach($_SESSION['itemsEnCestaEntrega'] as $k => $v)
				{
					if ($k == $result_tabla_row['idproducto'] && $v == $result_tabla_row['cantidad'])
					{
						echo 'style="color:green;font-size:12px "';
						
					}
				}
		 
		  ?> > 
   				  <td style="text-align:center; "><?php echo $result_tabla_row['idproducto']; ?></td> 
   				  <td><?php echo utf8_encode($result_tabla_row['nombre']); ?></td>
                  <td style="text-align:center"><?php echo $result_tabla_row['cantidad']; ?></td> 
                 
                 
				</tr>
                
              <?php  
 					}while($result_tabla_row = $db->fetch_assoc($result_tabla));
            ?>	
			</tbody> 
			</table>
         
         </div>
         
         <?php
		/* $productos = $s->obtenerSesion('vi_productos_entrega');
         foreach($productos as $p => $v)
		 {
			 echo "
			 hola soy p del array vi_productos = ".$p."   
			 ";
			 echo "
			 hola soy v del array vi_productos = ".$v."   
			 ";
		 }*/
		 
		 ?>
         