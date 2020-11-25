<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Importamos las clases a utilizar
require_once("../clases/conexcion.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Sobrepedidos.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Configuracion.php");


//Declaramos los objetos de clase
$db = new MySQL();
$fe = new Fechas();
$sp = new Sobrepedidos();
$cl = new Clientes();
$conf = new Configuracion();


//Enviamos el objeto de la conexión a las clases que lo requiren
$conf->db = $db;
$cl->db = $db;
$sp->db = $db;


//Declaramos variables a utilizar
$tipo = $_SESSION['se_sas_Tipo'];
$fecha_actual = $fe->fechaaYYYY_mm_dd_guion();
$estatus  = array('Pendiente','Autorizado','Cancelado','Despachado');
$suc = $_SESSION['se_sas_Sucursal'];



//Recibimos los parametros enviados por la funcion buscar
$fecha = ($_POST['inicio'] != '' ) ? $_POST['inicio'] : '';
$fecha_fin =($_POST['f_fin'] != '' ) ? $_POST['f_fin'] : '';
$nombre = trim($_POST['nombre']);
$estatust = $_POST['estatust'];
$idsobrepedido_camp = $_POST['campanas'];
$idsobrepedido = $_POST['v_idsobrepedido'];

//Enviamos los parametros a la clase
$sp->fecha_inicio = $fecha;
$sp->fecha_fin = $fecha_fin;
$sp->nombre = $nombre;
$sp->estatus = $estatust;
$sp->idsobrepedido_camp = $idsobrepedido_camp;
$sp->idsobrepedido = $idsobrepedido;
$sp->fecha_actual = $fecha_actual;


//Obtenemos los sobrepedidos dependiendo de la configuracion del filtro
$result_sobrepedidos = $sp->obtener_filtro();
$result_sobrepedidos_num = $db->num_rows($result_sobrepedidos);
$result_sobrepedidos_row = $db->fetch_assoc($result_sobrepedidos);

//Consultamos configuracion de impresion por sucursal
$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
$result_imp = $db->consulta($sql_imp);
$result_imp_row = $db->fetch_assoc($result_imp);
$impresion = $result_imp_row['notas_print'];

?>

<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_sobrepedidos').dataTable( {	
		   //"ordering": false,
		"order": [[ 2, 'asc' ]],
		   "lengthChange": true,
		   "pageLength": 100,	
		   "oLanguage": {
						"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
						"sZeroRecords": "Lo sentimos, no se han encontrado sobre pedidos.",
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
       
			
<table  class="table table-bordered" cellspacing="0" id="d_sobrepedidos"> 
	<thead> 
		<tr>
			<th align="center" style="text-align: center;"># SOBREPEDIDO</th> 
			<th align="cealign=" style="text-align: center;">FECHA</th>
			<th align="center" style="text-align: center;">NOMBRE</th>
			<th align="center" style="text-align: center;">TOTAL</th>
			<th align="center" style="text-align: center;">ESTATUS</th>
			<th align="center" style="text-align: center;">ACCI&Oacute;N</th>
		</tr> 
	</thead>
	
	<tbody> 
	<?php 	 
		if($result_sobrepedidos_num != 0){
			do
 			{	
				$sp->idsobrepedido = $result_sobrepedidos_row['idsobrepedido'];
				$total = $sp->obtener_total_sobrepedido();
				
				switch ($result_sobrepedidos_row['estatus']) {
					case 0:
						$color = '#fff600';
						break;
					case 1:
						$color = '#2ba500';
						break;
					case 2:
						$color = '#ff0000';
						break;
					case 3:
						$color = '#ad3273';
						break;
				}
				
				
	?>
				<tr> 
   					<td style="text-align:center"><?php echo $result_sobrepedidos_row['idsobrepedido']; ?></td> 
   				  	<td align="center"><?php echo $fe->f_esp($result_sobrepedidos_row['fecha']); ?></td>
   				  	<td align="center"><?php echo utf8_encode($result_sobrepedidos_row['nombre']." ".$result_sobrepedidos_row['paterno']." ".$result_sobrepedidos_row['materno']); ?></td>
                  	<td align="center">$ <?php echo number_format($total,2,'.',','); ?></td>
                  	<td align="center" style="background: <?php echo $color; ?>; color:#000; "><?PHP echo $estatus[$result_sobrepedidos_row['estatus']]; ?></td>
                  	<td align="center">    
						
						
						<button type="button" onClick="abrir_detalle_sobrepedido('ventas/vi_anticipos_sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="VER ANTICIPOS" class="btn btn-outline-info"><i class="mdi mdi-square-inc-cash"></i></button>
												
						<?php
						if($result_sobrepedidos_row['estatus'] == 0){
						?>
						
						<button type="button" onClick="autorizar_sobrepedido('<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="AUTORIZAR" class="btn btn-outline-info"><i class="mdi mdi-briefcase-check"></i></button>
						
						<?php
						}
						?>
						
						<?php
						if($result_sobrepedidos_row['estatus'] == 1){
						?>
						
						<button type="button" onClick="abrir_detalle_sobrepedido('ventas/fa_despechar_sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="DESPACHAR" class="btn btn-outline-info"><i class="mdi mdi-check-all"></i></button>
						
						<?php
						}
						?>


						<button type="button" onClick="abrir_detalle_sobrepedido('ventas/vi_detalle_sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>');" title="VER DETALLE" class="btn btn-outline-info"><i class="mdi mdi-arrange-send-backward"></i></button>						
						
                    	<?php
						if($impresion == 0){ 
						?>
					  		<!--<a href="#" onClick="imprimirPDF('ventas/pdf/sobrePedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>-->
						
							<div class="btn-group">	
								<button type="button" class="btn btn-outline-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="IMPRIMIR" >
									<i class="mdi mdi-printer"></i>
								</button>

								<div class="dropdown-menu">
									<a class="dropdown-item" onClick="imprimirPDF('ventas/pdf/sobrePedido_termico.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" href="#">TICKET</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#" onClick="imprimirPDF('ventas/pdf/sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')">CARTA</a>
								</div>
							</div>	
						
                    	<?php
						}else{
							if($impresion == 1){
						?>
						
								<div class="btn-group">
									
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="IMPRIMIR" >
										<i class="mdi mdi-printer"></i>
									</button>
									
									<div class="dropdown-menu">
								  		<a class="dropdown-item" onClick="imprimirPDF('ventas/pdf/sobrePedido_termico.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" href="#">TICKET</a>
									  	<div class="dropdown-divider"></div>
									  	<a class="dropdown-item" href="#" onClick="imprimirPDF('ventas/pdf/sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')">CARTA</a>
									</div>
								</div>
						
                    	<?php
							}else{
						?>
					 	 		<!--<a href="#" onClick="imprimirPDF('ventas/pdf/sobrePedido_termico2.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>-->
						
								<div class="btn-group">
									
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="IMPRIMIR" >
										<i class="mdi mdi-printer"></i>
									</button>
									
									<div class="dropdown-menu">
								  		<a class="dropdown-item" onClick="imprimirPDF('ventas/pdf/sobrePedido_termico.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')" href="#">TICKET</a>
									  	<div class="dropdown-divider"></div>
									  	<a class="dropdown-item" href="#" onClick="imprimirPDF('ventas/pdf/sobrepedido.php?id=<?php echo $result_sobrepedidos_row['idsobrepedido']; ?>')">CARTA</a>
									</div>
								</div>
                     	<?php
							}
						}
						?>
							
						<?php
						if($result_sobrepedidos_row['estatus'] != 2){ 
						?>
							
							<button type="button" onClick="cancelarSobrePedido('<?php echo $result_sobrepedidos_row['idsobrepedido'] ?>')" title="CANCELAR" class="btn btn-outline-danger"><i class="mdi mdi-block-helper"></i></button>
						
                		<?php
						}
						?>   
                  	</td> 
				</tr>
                
     	<?php
			}while($result_sobrepedidos_row = $db->fetch_assoc($result_sobrepedidos));
		}
		?>
	</tbody> 
</table>


