<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Al incluir este header nos olvidamos de colocar el utf8_encode para visualizar caracteres especiales á ñ etc.
header("Content-Type: text/text; charset=ISO-8859-1");
    
//Importamos las clases que vamos a utilizar
require_once("../clases/conexcion.php");	 
require_once("../clases/class.Sobrepedidos.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Tallas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$sp = new Sobrepedidos();
$fe = new Fechas();
$ta = new Tallas();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$sp->db = $db;
$ta->db = $db;

//Recibimos parametros enviados por GET
$idsobrepedido = $_GET['id'];

//Declaramos variables a utilizar
$estatus  = array('Pendiente','Autorizado','Cancelado');

//Realizamos consultas
$sp->idsobrepedido = $idsobrepedido;

//Obtenemos los datos del sobrepedido
$result_sobrepedido = $sp->buscar_sobrepedido();
$result_sobrepedido_row = $db->fetch_assoc($result_sobrepedido);

//Obtenemos los productos del sobrepedido
$result_detalle_sobrepedido = $sp->obtener_detalle_sobrepedido();
$result_detalle_sobrepedido_num = $db->num_rows($result_detalle_sobrepedido);
$result_detalle_sobrepedido_row = $db->fetch_assoc($result_detalle_sobrepedido);

?>

<script type="text/javascript">
	$('#titulo-visor').html("SOBRE PEDIDO # <?php echo $idsobrepedido; ?>");
</script>

<div class="card" style="border-bottom: 1px #eaeaea solid;">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				FECHA: <?php echo $fe->f_esp($result_sobrepedido_row['fecha']); ?>
			</div>
			<div class="col-md-6">
				CAMPA&Ntilde;A: <?php echo $result_sobrepedido_row['campana']; ?>
			</div>
			
			<div class="col-md-6" style="margin-top: 15px;">
				CLIENTE: <?php echo $result_sobrepedido_row['nombre']." ".$result_sobrepedido_row['paterno']." ".$result_sobrepedido_row['materno']; ?>
			</div>
			<div class="col-md-6" style="margin-top: 15px;">
				ESTATUS: <?php echo $estatus[$result_sobrepedido_row['estatus']]; ?>
			</div>
			
			
		</div>
	</div>
</div>     


<div class="card">
	<div class="card-body">
		<div id="li_modulos" class="module_content">
    		<div id="li_sobrepedidos" class="tab_container">
    			<table  class="table table-bordered" cellspacing="0" id="d_sobrepedidos"> 
        			<thead> 
            			<tr> 
							<th align="center" style="text-align: center;">PRODUCTO</th> 
							<th align="cealign=" style="text-align: center;">TALLA</th>
							<th align="center" style="text-align: center;">CANTIDAD</th>
							<th align="center" style="text-align: center;">PV</th>
							<th align="center" style="text-align: center;">SUBTOTAL</th>
            			</tr> 
        			</thead>
					
        			<tbody> 
        			<?php
						if($result_detalle_sobrepedido_num != 0){
							$total = 0;
							$cantidadproducts = 0;
	     					do
            				{
								$ta->idtallas = $result_detalle_sobrepedido_row['talla'];
								
								$result_tallas = $ta->buscarTalla();
								$result_tallas_row = $db->fetch_assoc($result_tallas);
                	?>
            			<tr> 
					  		<td style="text-align:center"><?php echo $result_detalle_sobrepedido_row['nombre']; ?></td> 
					  		<td align="center"><?php echo $result_tallas_row['talla']; ?></td>
					  		<td align="center"><?php echo $result_detalle_sobrepedido_row['cantidad']; ?></td>
					  		<td align="center">$ <?php echo $result_detalle_sobrepedido_row['pv']; ?></td>
					  		<td align="center"><?PHP echo $result_detalle_sobrepedido_row['subtotal']; ?></td> 
            			</tr>
            			<?php
								$total = $total + $result_detalle_sobrepedido_row['subtotal'];
								$cantidadproducts = $cantidadproducts + $result_detalle_sobrepedido_row['cantidad'];
            				}while($result_detalle_sobrepedido_row = $db->fetch_assoc($result_detalle_sobrepedido));
						}
						?>
        			</tbody> 
        		</table>
				
				<div style="text-align: right; font-size: 18px; padding-right: 7px;">
					CANTIDAD DE PRODUCTOS: <?php echo $cantidadproducts; ?> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					TOTAL $ <?php echo number_format($total,2,'.',','); ?>
				</div>
			</div>
		</div>	
	</div>
</div>  