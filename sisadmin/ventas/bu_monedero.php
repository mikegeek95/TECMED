<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


require_once("../clases/conexcion.php");
require_once("../clases/class.Productos.php");
require_once("../clases/class.Funciones.php");

try 
{

    $db= new MySQL();
	$pro = new Producto();
	$f = new Funciones();
	
	$pro->db = $db;
	
	 
	
	//enviamos datos a las variables de la tablas	
	$nombre =  utf8_decode($_POST['nombre']);
	$paterno = utf8_decode($_POST['paterno']);
	$materno = utf8_decode($_POST['materno']);
	$tarjeta = utf8_encode($_POST['tarjeta']);
	
		
 	$idsucursales = $_SESSION['se_sas_Sucursal'];
	
	$p_nombre = ($nombre != "" ) ? " AND c.nombre LIKE '%$nombre%' " : '';
	$p_paterno = ($paterno != "" ) ? "AND  c.paterno LIKE '%$paterno%' " : '';
	$p_materno = ($materno != "" ) ? " AND c.materno LIKE '%$materno%' " : '';
	$p_tarjeta = ($tarjeta != "" ) ? "AND  c.no_tarjeta LIKE '%$tarjeta%' " : '';
	
	
	//$p_pago = ($pago != "" ) ? "AND  est_pago in($pago) " : '';
	//$p_ini = ($ini != "" ) ? " est_recibido != $ini" : '';
	
	
	
			$sql_guias = "SELECT * FROM clientes c WHERE estatus IN(0,1,2) $p_nombre $p_materno $p_paterno $p_tarjeta";
	
	
	//die($sql_guias);
	//echo $sql_guias;
	
	$sql_mandar = $f->conver_especial($sql_guias);
		
//ejecuto la consulta y creo un fecth assoc	
	$result_gastos = $db->consulta($sql_guias);
	$result_gastos_row = $db->fetch_assoc($result_gastos); 
	$result_gastos_row_num = $db->num_rows($result_gastos);
	 //error por si no se encuentra ni un registro
	 if ($result_gastos_row_num <= 0)
	 {
		 echo "<p style='text-align:center; color:red;'>Lo sentimos no se encontraron los resultados de la busqueda</p> ";
		 
		 }
	else 
	{	 
?>

		<script type="text/javascript" charset="utf-8">
		
				
				var oTable = $('#d_modulos').dataTable( {	
				 "ordering": false,	
					   "lengthChange": true,
					   "pageLength": 50,		
					
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
				
				</script>


			

			<table  cellspacing="0"  class="table table-bordered" id="d_modulos"> 
		   <thead> 
			   <tr style="background-color:#DBD7D7">
			     
			     <!--<th align="center" style="text-align:center"> FECHA</th>--> 
                 	<th align="center" style="text-align:center"> ClIENTE</th>
                    <th align="center" style="text-align:center">NO. TARJETA</th>
				   <th align="center" style="text-align:center">SALDO</th>
				   <!--<th align="center" style="text-align:center">MODALIDAD</th> 
   				   <th align="center" style="text-align:center"> TIPO</th>-->
   				                      
                   <!--<th align="center" style="text-align:center">ACCIONES</th>-->
			   </tr> 
		   </thead> 
		   <tbody> 
            
            <?php
			
			if($result_gastos_row_num != 0)
			 {
					$modalidad = array('PAGO CAJA','DEVOLUCION','DEPOSITO');
					$tipo = array('ABONO','CARGO');
		           do
			         {
						?>
           
			   <tr style="cursor:pointer" onDblClick="AbrirModalGeneral2('ModalPrincipal','940','460','ventas/vi_m_monedero.php?idcliente=<?php echo $result_gastos_row['idcliente']; ?>');">
			   
			     <!--<td align="center"><?PHP echo $result_gastos_row['fecha']; ?></td> -->
                 <td align="center" style="text-transform:uppercase;"><?PHP echo utf8_encode($result_gastos_row['nombre']." ".$result_gastos_row['paterno']." ".$result_gastos_row['materno']); ?></td> 
			     <td align="center"><?php echo $result_gastos_row['no_tarjeta']; ?></td>
			     <td align="center"><?php echo "$ ".$result_gastos_row['saldo_monedero']; ?></td>
			     <!--<td align="center"><?php echo $modalidad[$result_gastos_row['modalidad']]; ?></td> 
			     <td align="center"><?php echo  $tipo[$result_gastos_row['tipo']]; ?></td>-->
			     
   			
   			     <!--<td align="center">
                     <input type="hidden" id="sql_regresar" value="<?Php echo $sql_guias; ?>" />
                     <input type="image" src="images/icn_edit.png" title="EDITAR" onclick=" AbrirModalGuias('ModalPrincipal','900','560','catalogos/fc_guias.php?id=<?php echo $result_gastos_row['idguias_pedidos'];?>');">
                     
                     
                     <input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarDatos('<?php echo $result_gastos_row['idguias_pedidos'];?>','idguias_pedidos','guias_pedidos','n','catalogos/vi_guias2.php','main')" />
                     
                     <input type="image" src="images/print.png" title="IMPRIMIR" onclick="imprimirPDF('catalogos/pdf/reporteGuia.php?id=<?php echo $result_gastos_row['idguias_pedidos']; ?>')">
                 
                 
                 </td> -->
			   </tr>
            <?php
			}
			while($result_gastos_row = $db->fetch_assoc($result_gastos));
			
			?>
            <?php
			
			 }
			   else
			 {
				 ?>
				<tr  >
			   
			     <td align="center" colspan="3">NO EXISTE NINGUN CONCEPTO DE GASTO EN ESTE MOMENTO</td> 
			     
			   </tr>
           	   <?php

			  }
			?>
		   </tbody> 
     </table>  
          
           <?php 
		     } 
		   }
		   catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}		


		   ?> 