<?PHP
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


$db = new MySQL();
$pro = new Producto();

$f = new Funciones();


$pro->db = $db;

$idsucursales = $_SESSION['se_sas_Sucursal'];

$pro->idsucursales = $idsucursales;

$result_productos = $pro->obtenerProductosSucursal();
$result_productos_row = $db->fetch_assoc($result_productos);


 

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
				
				var oTable = $('#d_productos').dataTable( {		
					
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
       <div id="main2">         
      <article class="module width_full" style="background-color:#CCC">
<div id="li_modulos" class="tab_container">
<table  border="0" cellspacing="2" cellpadding="2"  id="d_productos" style="color:#999" class="tablesorter">
<thead > 
  <tr >
    <th width="11%" align="center" style="border-top-left-radius: 5px">ID  </th>
    <th width="81%" align="center">PRODUCTO</th>
    <th width="8%" align="center" style="border-top-right-radius: 5px">COSTO</th>
    <th width="8%" align="center" style="border-top-right-radius: 5px">EXISTENCIA</th>
    <th width="8%" align="center" style="border-top-right-radius: 5px">CANTIDAD</th>
    <th width="8%" align="center" style="border-top-right-radius: 5px">ACCION</th>
    </tr>
</thead>    

<tbody>
  
  <?php
		do
		{
		
		$id=$result_productos_row['CODIGOPRODUCTO'];
		$producto=$result_productos_row['NOMBREPRODUCTO'];
		$pv=$result_productos_row['COSTOACTUAL'];
		$existencia = $result_productos_row['EXISTENCIA'];
		$sucursasl = $result_productos_row['SUCURSAL'];
		?>
	<tr>
            <td align="center" ><?php echo $id;?></td>
            <td ><?php echo utf8_encode($producto); ?></td>
            <td align="center" >$ <?php echo $pv; ?></td>
            <td align="center" ><?php echo $existencia; ?></td>
            <td align="center" ><label for="textfield"></label>
              <label for="cantidad"></label>
              
              <?php
			      $desactivado= '';
			     
                 if($existencia <= 0)
				 {
					 $desactivado = 'disabled="disabled"';
				 }
				
			  
			  ?>
              
              <select name="<?php echo $id; ?>-cantidad" id="<?php echo $id; ?>-cantidad" <?php echo $desactivado; ?> >
              
              <?php 
			  
			  		  
			  for($i = 1; $i <= $existencia ; $i++)
			  {
				  ?>
				  
				  <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
				  <?php
				  
			  }
			  
			  ?>
              
                
            </select>
            </td>
            <td align="center" ><input type="button" name="button" id="button" value="Agregar" onClick="S_Producto_cotizacion('<?php echo $id;?>',document.getElementById('<?php echo $id; ?>'+'-cantidad').value,'<?php echo $idsucursales; ?>'); $('#ModalSecundaria').css('display','none'); $('#contenido_modal_dos').html('');" <?php echo $desactivado; ?> ></td>
      </tr>
		
		
		<?php
		}while($result_productos_row = $db->fetch_assoc($result_productos));
	
  
  ?>

    </tbody>
</table>
    </div>

</article>
</div>    