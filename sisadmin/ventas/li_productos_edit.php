<?PHP
//Validamos que exista una sesión
/*=================================================*/
	require_once("../clases/class.Sesion.php");
	$se = new Sesion();
	if(!isset($_SESSION['se_SAS']))
	{
		//Si no existe la sesión mandamos a login
		header("Location: ../login.php");
		exit;
	}
/*================================================*/

//Importamos clases a utilizar
require_once("../clases/conexcion.php");
require_once("../clases/class.Productos.php");
require_once("../clases/class.Funciones.php");
require_once("../clases/class.Tallas.php");

//Declaraciones de objetos de clases
$db = new MySQL();
$pro = new Producto();
$ta = new Tallas();
$f = new Funciones();

//Enviamos objeto de conexión a las clases que lo requieren
$pro->db = $db;
$ta->db = $db;

//Declaramos variables, recibimos y asignamos valor.
$idsucursales = $_SESSION['se_sas_Sucursal'];
$idnota_remision = $_GET['idnota_remision'];



	
/*===========================//INICIA CONSULTAS//=================================*/


	$pro->idsucursales = $idsucursales;

	$result_productos = $pro->obtenerProductosSucursal();
	$result_productos_row = $db->fetch_assoc($result_productos);



/*===========================//TERMINA CONSULTAS//=================================*/


?>

<script type="text/javascript" charset="utf-8">

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
	} );

</script>
                
<div id="li_modulos" class="tab_container">
	<table  border="0" cellspacing="2" cellpadding="2"  id="d_productos" style="color:#999; font-size: 12px;" class="table table-bordered">
		<thead> 
  			<tr>
				<th width="11%" align="center" style="border-top-left-radius: 5px">ID  </th>
				<th width="81%" align="center">PRODUCTO</th>
				<th width="8%" align="center" style="border-top-right-radius: 5px">COSTO</th>
				<th width="8%" align="center" style="border-top-right-radius: 5px">EXISTENCIA</th>
				<th width="8%" align="center" style="border-top-right-radius: 5px">CANTIDAD</th>
				<th width="8%" align="center" style="border-top-right-radius: 5px">TALLA</th>
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
				$talla = $result_productos_row['TALLA'];
			
				$result_tallas = $ta->TallasActivas();
				$result_tallas_row = $db->fetch_assoc($result_tallas);
				$result_tallas_num = $db->num_rows($result_tallas);
		?>
			<tr>
            	<td align="center" ><?php echo $id;?></td>
            	<td><?php echo utf8_encode($producto); ?></td>
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
              		<select name="<?php echo $id."|".$talla; ?>-cantidad" id="<?php echo $id."|".$talla; ?>-cantidad" <?php echo $desactivado; ?> >
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
				<td align="center" >
              		<select name="<?php echo $id."|".$talla; ?>-tallas" id="<?php echo $id."|".$talla; ?>-tallas" disabled>
						<option>&nbsp;</option>
              			<?php
						do
						{
						?>
							<option <?php if($talla == $result_tallas_row['idtallas']){ echo "selected"; } ?> value="<?php echo $result_tallas_row['idtallas']; ?>"><?php echo utf8_encode($result_tallas_row['talla']); ?></option>
						<?php
					}	while($result_tallas_row = $db->fetch_assoc($result_tallas));
						?>
            		</select>
            	</td>
            	<td align="center" >
					<input type="button" name="button" id="button" value="Agregar" onClick="S_Producto_edit('<?php echo $id;?>',document.getElementById('<?php echo $id."|".$talla; ?>'+'-cantidad').value,'<?php echo $idnota_remision; ?>',document.getElementById('<?php echo $id."|".$talla; ?>'+'-tallas').value); CerrarModalGeneral('ModalPrincipal');" <?php echo $desactivado; ?> >
				</td>
			</tr>
		<?php
		}while($result_productos_row = $db->fetch_assoc($result_productos));
		?>
    	</tbody>
	</table>
</div>    