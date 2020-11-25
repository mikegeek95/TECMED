<?PHP
require_once("../clases/conexcion.php");
require_once("../clases/class.Sucursales.php");
require_once("../clases/class.Funciones.php");


$db = new MySQL();
$suc = new Sucursales();

$f = new Funciones();


$suc->db = $db;

//$result_clientes = $cli->ObtenerInformacionClientes();

$result_sucursales = $suc->todasSucursales();
$result_sucursales_row = $db->fetch_assoc($result_sucursales);
$result_sucursales_num = $db->num_rows($result_sucursales);


 

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
				
				var oTable = $('#d_clientes').dataTable( {		
					
					  "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "Nada Encontrado - Disculpa",
									"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
									"sInfoEmpty": "desde 0 a 0 de 0 records",
									"sInfoFiltered": "",
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
                
      <article class="module width_full" style="background-color:#CCC">
<div id="li_modulos" class="tab_container">
<table  border="0" cellspacing="2" cellpadding="2"  id="d_clientes" style="color:#999" >
<thead > 
  <tr >
    <th width="11%" align="center" style="border-top-left-radius: 5px">ID  </th>
    <th width="81%" align="center">SUCURSAL</th>
    <th width="8%" align="center" style="border-top-right-radius: 5px">ACCION</th>
    </tr>
</thead>    

<tbody>
<!--<tr>
            <td align="center" >0</td>
            <td >Publico General</td>
            <td align="center" ><input type="button" name="button" id="button" value="Seleccionar" onClick="S_cliente(0,'Publico General'); CerrarModalGeneral('ModalPrincipal');"></td>
      </tr>-->
  
  <?php
    do
	{
		$id = $result_sucursales_row['idsucursales'];
		$nombre = $result_sucursales_row['sucursal'];
		?>
	<tr>
            <td align="center" ><?php echo $id;?></td>
            <td ><?php echo $nombre; ?></td>
            <td align="center" ><input type="button" name="button" id="button" value="Seleccionar" onClick="S_sucursal('<?php echo $id;?>','<?php echo $nombre; ?>'); CerrarModalGeneral('ModalPrincipal');"></td>
      </tr>
		
		
		<?php
	}while($result_sucursales_row = $db->fetch_assoc($result_sucursales));
  
  ?>

    </tbody>
</table>
    </div>

</article>
    