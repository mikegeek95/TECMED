<?php


//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];
    
//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Compras.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Categorias.php");
require_once("../../clases/class.Botones.php");

//Declaramos los objetos de clase
$db = new MySQL();
$gu = new Compras();
$fe = new Fechas();
$fu = new Funciones();
$bt = new Botones_permisos();
$cat = new Categoria();
//Enviamos el objeto de la conexión a las clases que lo requieren.
$gu->db = $db;
$cat->db =$db;

//Recibimos parametros enviados por GET
$idcompra = $_GET['id'];

$gu->id_compra = $idcompra;

$result = $gu->detallecompra($gu->id_compra);
$result_num = $db->num_rows($result);
$result_row = $db->fetch_assoc($result);




$t_estatus = array('DESACITVADO','ACTIVADO');


//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



?>

<script type="text/javascript">
		$('#titulo-modal-forms').html("Detalles de compra # <?php echo $idcompra; ?>");
</script>
<div class=" card">


	

	<div class="card-header col-md-12">
		
		
		<div style="clear: both;"></div>
	</div>


<div class="card-body row">
	<div class="col-md-12">
		<table class="table table-bordered table-responsive" id="guias_pedidos" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
					<tr>
					<th align="center" style="text-align: center;">CODIGO</th> 
					<th align="center" style="text-align: center;">FOTO</th> 
					<th align="center" style="text-align: center;">NOMBRE</th>
					
					<th align="center" style="text-align: center;">SUBCATEGORIA</th>
					<th align="center" style="text-align: center;">CANTIDAD</th>
					<th align="center" style="text-align: center;">PRECIO</th>
					<th align="center" style="text-align: center;">SUBTOTAL</th>
					
				</tr>
			</thead>
			<tbody>
				<?php
				if($result_num != 0){
					do
					{
				?>	
						<tr>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['idproducto']); ?></td>
							<td align="center"><img width="40" height="40" src="productos/productos/imagenes/<?php echo $fu->imprimir_cadena_utf8($result_row['foto']); ?>"></td>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['nombre']); ?></td>
							<?php
								$scat=$cat->buscar_subcat($result_row['idsubcategoria']);
								$nom_subcat=$db->fetch_assoc($scat);
								$subcat=$nom_subcat['nombre'];

								$subt= $result_row['cantidad'] * $result_row['pc'] ;
							?>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($subcat); ?></td>
							<td align="center"><?php echo $fu->imprimir_cadena_utf8($result_row['cantidad']); ?></td>
							<td align="center">$<?php echo $fu->imprimir_cadena_utf8($result_row['pc']); ?></td>
							
							<td align="center">$<?php echo number_format($subt,2,'.',','); ?></td>
	
							
						</tr>
				<?php
					}while($result_row = $db->fetch_assoc($result));
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</div>


<script type="text/javascript" charset="utf-8">
var oTable = $('#guias_pedidos').dataTable( {		
"pageLength": 5,	
  "oLanguage": {
				"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
				"sZeroRecords": "NO EXISTEN DETALLES DE COMPRA",
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
   "sPaginationType": "full_numbers"

});
</script>