 <?php
  header("Content-Type: text/text; charset=ISO-8859-1");
   require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}
    require_once("../clases/conexcion.php");
	require_once("../clases/class.Traspaso.php");
	 
	$db = new MySQL();
	$tra = new Traspaso();
	
	$tra->db = $db;
	
	$idtraspaso = $_GET['id'];
	
	$tra->idtraspaso = $idtraspaso;
	 
	$result_traspaso = $tra->buscarDetalle();
	$result_traspaso_row = $db->fetch_assoc($result_traspaso);
	$result_traspaso_num = $db->num_rows($result_traspaso);
 
 
 
 if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	
	echo $msj;
}
 ?>
 
 
 <link type="text/css" rel="stylesheet" href="css/modal.css" />
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
				
				var oTable = $('#d_modulos').dataTable( {		
					
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


 <article class="module width_full">
		<header>
			<h3 class="tabs_involved">DETALLE DE TRASPASOS</h3>
            <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('productos/vi_traslado.php','main');">Regresar</a></li>
			</ul>
		</header>
		
		<div id="li_modulos" class="tab_container">
       
			<table  class="tablesorter" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th>ID</th> 
    				<!--<th>USUARIO</th>
                    <th>DE</th>
                    <th>PARA</th>-->
                    <th>PRODUCTO</th>
                    <th>NOMBRE</th>
                    <th>CANTIDAD</th>
                    <!--<th>FECHA</th>-->
                    <!--<th>ACCI&Oacute;N</th>-->
				</tr> 
			</thead> 
			<tbody> 
            
            
            
            <?php
			if($result_traspaso_num != 0){
            do
			{  
				$idtraspaso = $result_traspaso_row['idtraspaso'];
				$idproducto = $result_traspaso_row['idproducto'];
				
				$sql = "SELECT * FROM productos WHERE idproducto = '$idproducto'";
				$result_producto = $db->consulta($sql);
				$result_producto_row = $db->fetch_assoc($result_producto);
				
				$nombre = utf8_encode($result_producto_row['nombre']);
				
				
			?>
				<tr> 
   					<td style="text-align:center"><?php echo $idtraspaso; ?></td> 
   				 
                   <!--<td><?php echo $result_usuarios_row['usuario'] ?></td>
                 
                   <td><?php echo $result_de_row['sucursal']; ?></td>
                   <td><?php echo $result_para_row['sucursal']; ?></td>-->
                   <td><?php echo $idproducto; ?></td>
                   <td><?php echo $nombre; ?></td>
                   <td><?php echo $result_traspaso_row['cantidad']; ?></td>
                   <!--<td><?php echo $result_traspaso_row['fecha'];?></td>-->
                 
                   <!--<td align="center">
                    <input type="image" src="images/icn_categories.png" title="VER DETALLE" onclick="aparecermodulos('productos/vi_traspasos_lista.php?id=<?php echo $result_traspaso_row['idtraspaso']; ?>','main')">
                    <!--<input type="image" src="images/icn_edit.png" title="EDITAR" onclick="aparecermodulos('productos/fc_etiquetas.php?id=<?php echo $result_etiquetas_row['idetiquetas']; ?>','main')">-->
                    <!--<input type="image"  title="IMPRIMIR LISTA" onclick="imprimirPDF('productos/pdf/OrdenTraslado.php?id=<?php echo $result_traspaso_row['idtraspaso']; ?>')"  src="images/print.png">-->

                  <!-- <input type="image" src="images/icn_trash.png" title="BORRAR" onclick="BorrarDatos('<?php echo $$result_etiquetas_row['idetiquetas'];?>','idetiquetas','etiquetas','n','productos/vi_etiquetas.php','main')">-->
                   <!-- </td>--> 
				</tr>
            <?php 
			   }
			   while($result_traspaso_row = $db->fetch_assoc($result_traspaso));
			}
			?>
            	
			</tbody> 
			</table>
	
        
		</div><!-- end of .tab_container -->		
</article>