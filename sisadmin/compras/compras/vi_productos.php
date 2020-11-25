<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}
     require_once("../../clases/conexcion.php");
     require_once("../../clases/class.Funciones.php");

	 $db = new MySQL();
	 $f = new Funciones();

	 $sql_producto = "SELECT subcategoria.nombre AS subcategoria, productos.idproducto, productos.nombre,productos.descripcion,productos.pv,productos.descuento, productos.foto, productos.thumb, productos.estatus FROM productos LEFT JOIN subcategoria ON productos.idsubcategoria = subcategoria.idsubcategoria ORDER BY productos.idsubcategoria";

	 $result_producto = $db->consulta($sql_producto);

	 $result_producto_row = $db->fetch_assoc($result_producto);

	 $result_producto_row_num = $db->num_rows($result_producto);

	 

	 $b_estatus = array("DESACTIVADO","ACTIVADO");

 

 ?>
 <script type="text/javascript">
$('#titulo-modal-forms').html("LISTA DE PRODUCTOS");
 	function colocar (id)

	{

		$('#v_codigo').val(id);

		/*$('#fondo').slideUp("slow");

		$('#modal').slideUp(2000,function (){

		$('#modal').html('');

					});*/
		$('#modal-forms').modal('hide');

	}

	

  </script>
 

		<script type="text/javascript" charset="utf-8">

		


				

				var oTable = $('#d_modulos').dataTable( {		

					

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

                


<div class="table-responsive">

			<table  class="table table-bordered"  width="100%" cellspacing="0" id="d_modulos" style="text-align: center; width: 100%;"> 

			<thead class="px-3 py-5 bg-gradient-primary text-white"> 

				<tr> 

   					 

                    <th>CODIGO</th>

                    <th>FOTO</th>

                    <th>SUBCATEGOR&Iacute;A</th>

    				<th>NOMBRE</th>

                    <!--<th>DESCRIPCI&Oacute;N</th>-->

                    <th>PRECIO VENTA</th>

                    <!--<th>DESCUENTO</th>-->

                    <!--<th>FOTO</th>-->

                    <!--<th>THUMB</th>-->

                    <!--<th>ENTRADAS</th>-->

                    <th>EXISTENCIA</th>

                    <!--<th>SALIDAS</th>-->

                   <!-- <th>ESTATUS</th>-->

                    <th>ACCI&Oacute;N</th>

				</tr> 

			</thead> 

			<tbody> 

            

            

            <?php

            do

			{  

			   

			  	$sql = "SELECT * FROM inventario WHERE idproducto = '".$result_producto_row['idproducto']."'";
				$result_inventario = $db->consulta($sql);
				$result_inventario_num = $db->num_rows($result_inventario);
				$result_inventario_row = $db->fetch_assoc($result_inventario);
			      
				  if($result_inventario_num == 0){
					  $existencia = 0;
				  }else{
					  $existencia = $result_inventario_row['existencia'];
				  }

			       

			?>

            

				<tr> 

   					  

   				   <td align="center" ><?php echo 
   				   $f->imprimir_cadena_utf8($result_producto_row['idproducto']); ?> </td>

   				   <td align="center"><img width="40" height="40"<?php if ($result_producto_row['foto']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/productos/imagenes/<?php echo $result_producto_row['foto'];} ?>" /></td>

                   

                  <td align="center"><?php echo  $f->imprimir_cadena_utf8($result_producto_row['subcategoria']) ;?></td>

                 

                   <td align="center"><?php echo  $f->imprimir_cadena_utf8($result_producto_row['nombre']); ?></td>

                 

                  <!-- <td align="center"><?php echo  $f->imprimir_cadena_utf8($result_producto_row['descripcion']); ?></td>-->

                   <td align="center"><?php echo  $f->imprimir_cadena_utf8($result_producto_row['pv']); ?></td>

                   

                   

                   <!--Aqui estaba el thum -->

                    

                  <td align="center"><?php echo  $f->imprimir_cadena_utf8($existencia); ?></td>

                    

                  <!-- <td align="center"><?php echo $b_estatus[$result_producto_row['estatus']]; ?></td>-->

                   

                   <td align="center"><button class="btn btn-outline-primary" onclick="colocar('<?php echo $result_producto_row['idproducto'];?>')"  > <i class="fas fa-sign-in-alt"></i>Seleccionar</button>
                    </td> 

				</tr>

            <?php 

			   }

			   while($result_producto_row = $db->fetch_assoc($result_producto));

			?>

            	

			</tbody> 

			</table>
</div>