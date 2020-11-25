<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Sesion.php");
require_once("../clases/class.Funciones.php");
require_once("../clases/class.Fechas.php");
///require_once("../clases/class.Devoluciones.php");
require_once("../clases/class.Configuracion.php");


$db = new MySQL();
$f = new Funciones();
$fec = new Fechas();
$conf = new Configuracion();

$conf->db = $db;


//$devoluciones = new Devoluciones();
//$devoluciones->db = $db;
$tipo = $_SESSION['se_sas_Tipo'];


//recibimos los valores para realizar la busqueda de la devolucion.

$iddevolucion = $_POST['v_iddevolucion'];
$v_idorden = $_POST['v_idorden'];
$inicio = $_POST['inicio'];
$f_fin = $_POST['f_fin'];
$v_idcliente = $_POST['v_idcliente'];
$estatust = $_POST['estatust'];


$inicio = ($_POST['inicio'] != '' ) ? $_POST['inicio'] : '';
$f_fin =($_POST['f_fin'] != '' ) ? $_POST['f_fin'] : '';

$fecha_actual = $fec->fechaaYYYY_mm_dd_guion();

//REALIZAMOS LA BUSQUEDA DE LA DEVOLUCIONES 


	  $sql_devolucion = "SELECT cd.*, n.idcliente, n.idsucursales, cdd.idnota_remision FROM cliente_devolucion cd, nota_remision n, cliente_devolucion_detalle cdd  WHERE cdd.idnota_remision = n.idnota_remision AND cdd.idcliente_devolucion = cd.idcliente_devolucion  ";	
	  $sql_devolucion.= ($iddevolucion != '') ? " AND cd.idcliente_devolucion = $iddevolucion ":"" ; 
	  $sql_devolucion.= ($v_idorden != '') ? " AND cd.idnota_remision = $v_idorden ":"" ;
	  $sql_devolucion.= ($v_idcliente != 0) ? " AND n.idcliente = $v_idcliente ":"" ; 
	  
	  $sql_devolucion.= ($inicio && $f_fin) ? " AND date(cd.fecha)>= date('$inicio') AND date(cd.fecha) <= date('$f_fin') " : " AND date(cd.fecha)>= '1900-01-01' AND DATE(cd.fecha) <= '$fecha_actual' ";

	  
	  //Validamos que sea superUsuario
/*if($tipo == 0){
	//die("superusuario TODAS");
}else{
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$sql_devolucion.= "AND n.idsucursales = '$idsucursales'";	
}*/

	  
	  //$sql_devolucion.= ( strlen($nombrec) > 2) ? " AND CONCAT(TRIM(cl.nombre),' ',TRIM(cl.paterno),' ',TRIM(cl.materno)) LIKE '%$nombrec%'  " : "" ;
	  
	  
	  $sql_devolucion.= " GROUP BY cd.idcliente_devolucion ORDER BY
	cd.idcliente_devolucion DESC";
	  
      $result_devo = $db->consulta($sql_devolucion);
	  $result_devo_row = $db->fetch_assoc($result_devo);
	  $result_devo_num = $db->num_rows($result_devo);     
	  
	  
	  $sql_enviar = $f->conver_especial($sql_devolucion); 

	$estatus  = array('Cancelada','Realizada');



//Consultamos configuracion para impresion
//$result_conf = $conf->ObtenerInformacionConfiguracion();
//$impresion = $result_conf['notas_print'];

//Consultamos configuracion de impresion por sucursal
$suc = $_SESSION['se_sas_Sucursal'];
$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
$result_imp = $db->consulta($sql_imp);
$result_imp_row = $db->fetch_assoc($result_imp);
$impresion = $result_imp_row['notas_print'];
?>

<script type="text/javascript" charset="utf-8">

var oTable = $('#d_modulos').dataTable( {	
	   "ordering": false,
	   "lengthChange": true,
	   "pageLength": 100,	
	   "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "Lo sentimos - Ningun registro encontrado",
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
	   "bScrollCollapse": true,
	} );

</script>
       
		<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th>NO. DEVOLUCION</th>
   					<!--<th>NO. DE VENTA</th> -->
    				<th>FECHA</th>
    				<th>NOMBRE</th>
                    <th>TOTAL</th>
                    <th>ESTATUS</th>
                    <!--<th>SUCURSAL</th>-->
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     if($result_devo_num != 0){
	 
	     do
				{
					
					
					if($result_devo_row['idcliente'] == 0)
					   {
						   $nombre = "PUBLICO GENERAL";
						}else
						{
							    
						  //buscamos al cliente
						  
						  $sql_cliente = "SELECT * FROM clientes WHERE idcliente = ".$result_devo_row['idcliente'] ;	
						  $result_cliente = $db->consulta($sql_cliente);
						  $result_cliente_row = $db->fetch_assoc($result_cliente);
						  
						  $nombre = $result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno'];
								
						}
					
				
					?>
            
          
            
				<tr> 
   				  <td align="center" style="text-align:center"><?php echo $result_devo_row['idcliente_devolucion']; ?></td>
   				  <!--<td align="center"><span style="text-align:center"><?php echo $result_devo_row['idnota_remision']; ?></span></td> -->
   				  <td align="center"><?php echo $result_devo_row['fecha']; ?></td>
   				  <td align="center"><?php echo utf8_encode($nombre); ?></td>
                  <td align="center">$ <?php echo number_format($result_devo_row['total'],2,'.',','); ?></td>
                  <td align="center"><?PHP echo $estatus[$result_devo_row['estatus']]; ?></td>
                  <?PHP
				   $idsucursal = $result_devo_row['idsucursales'];
				   $sql = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
				   $result_sucursal = $db->consulta($sql);
				   $result_sucursal_row = $db->fetch_assoc($result_sucursal);
				  ?>
                  <!--<td align="center"><?PHP echo utf8_encode($result_sucursal_row['sucursal']); ?></td>-->
                  <td align="center">
                    <!--<input type="image" src="images/icn_categories.png" title="DETALLE DEVOLUCI&Oacute;N" onclick="AbrirModalGeneral2('ModalPrincipal','900','560','ventas/vi_productosDevolucion.php?id=<?php echo $result_devo_row['idcliente_devolucion'];?>');">-->
                    
                    
					<!-- INICIA IMRPESION -->
					<?php
					if($impresion == 0){ 
					?>					  
					  <button type="button" onClick="imprimirPDF('ventas/pdf/devolucion.php?id=<?php echo $result_devo_row['idcliente_devolucion']; ?>');" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
					  
                    <?Php
					}else{
						if($impresion == 1){
					?>
					  <button type="button" onClick="imprimirPDF('ventas/pdf/devolucion_termica.php?id=<?php echo $result_devo_row['idcliente_devolucion']; ?>');" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
                    <?Php
						}else{
							?>
					  		<button type="button" onClick="imprimirPDF('ventas/pdf/devolucion_termica2.php?id=<?php echo $result_devo_row['idcliente_devolucion']; ?>');" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
                            <?php
						}
					}
					?>
                    
                    <!-- TEMRINA IMPRESION -->
                    
                    
                    
                    <!-- INICIA CANCELACION -->
                    
                    <?php 
					if($result_devo_row['estatus'] != 0){
					?>
                    
					  
					  <button type="button" onClick="cancelarDevolucion('<?php echo $result_devo_row['idcliente_devolucion'] ?>')" title="CANCELAR" class="btn btn-outline-danger"><i class="mdi mdi-block-helper"></i></button>
					                  
                <?php
					}
				?>
                	<!-- TERMINA CANCELACION -->
                    
                     
                  </td> 
				</tr>
                
                <?php
				}while($result_devo_row = $db->fetch_assoc($result_devo));
		 }
				?>
 
            	
			</tbody> 
			</table>


