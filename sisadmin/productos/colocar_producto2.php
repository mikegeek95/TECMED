<?php

header("Content-Type: text/text; charset=ISO-8859-1");

     require_once("../clases/conexcion.php");

	 

	 $db = new MySQL();

	 

	 $sql_producto = "SELECT p.*, sc.nombre as subcategoria FROM productos p, subcategoria sc where p.idsubcategoria=sc.idsubcategoria order by p.idsubcategoria";

	 $result_producto = $db->consulta($sql_producto);

	 $result_producto_row = $db->fetch_assoc($result_producto);

	 $result_producto_row_num = $db->num_rows($result_producto);

	 

	 $b_estatus = array("DESACTIVADO","ACTIVADO");

 

 ?>

<script type="text/javascript">
	$('#titulo-modal-forms').html("LISTA DE PRODUCTOS");
</script>

<table  class="table table-bordered" cellspacing="0" id="d_products" style="font-size: 12px;"> 
	<thead> 
		<tr> 
        	<th>CODIGO</th>
           	<th>FOTO</th>
         	<th>SUBCATEGOR&Iacute;A</th>
    		<th>NOMBRE</th>
          	<!--<th>DESCRIPCI&Oacute;N</th>-->
           	<th>PRECIO VENTA</th>
         	<!--<th>ESTATUS</th>-->
           	<th>ACCI&Oacute;N</th>
		</tr> 
	</thead> 
	
	<tbody> 
    	<?php
       		do
			{  

		?>

            

				<tr> 

   					  

   				   <td align="center" ><?php echo $result_producto_row['idproducto']; ?> </td>
   				   <td align="center"><img width="40" height="40"<?php if ($result_producto_row['foto']==""){ echo 'src="images/sinfoto.png" ';   } else { ?> src="productos/imagenes/<?php echo $result_producto_row['foto'];} ?>" /></td>
                  <td align="center"><?php echo $result_producto_row['subcategoria'] ;?></td>
                   <td align="center"><?php echo $result_producto_row['nombre']; ?></td>
                   <!--<td align="center"><?php echo $result_producto_row['descripcion']; ?></td>-->
                   <td align="center"><?php echo $result_producto_row['pv']; ?></td>

                   <!--Aqui estaba el thum -->

                 <!-- <td align="center"><?php echo $result_producto_row['existencia']; ?></td>-->

                   <!--<td align="center"><?php echo $b_estatus[$result_producto_row['estatus']]; ?></td>-->

                   <td align="center">
					   <input type="button" onclick="colocar2('<?php echo $result_producto_row['idproducto'];?>','<?php echo $result_producto_row['unidad'];?>');combotallasvaloretiquetas();" value="Colocar" >
                    </td> 
				</tr>

            <?php 

			   }

			   while($result_producto_row = $db->fetch_assoc($result_producto));

			?>

            	

			</tbody> 

			</table>


<script type="text/javascript" charset="utf-8">

		
			function colocar2 (id,unidad)

	{

		$('#v_codigo').val(id);
		

		$('#Modal-productos').modal('hide');

	}

				

				var oTable = $('#d_products').dataTable( {		

					

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
				} );

				

				</script>