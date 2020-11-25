<?php

header("Content-Type: text/text; charset=ISO-8859-1");



if (!isset($_SESSION)) 

{

  session_start();

}



try{

//conecto a la base de datos



require_once("../clases/conexcion.php");

require_once("../clases/class.Productos.php");

require_once("../clases/class.Funciones.php");







  



	

   $db = new MySQL();

   $fn = new Funciones ();

   

    //tomamos el id del producto

   $id = $_GET['id'];

   //creacion de objetos

	

	

	$cadena_id = $fn->desconver_especial($id);

   

   // hacemos la consulta para imprimir el nombre del producto

   $sql_producto = "SELECT * FROM productos WHERE idproducto = '$cadena_id'";

   $result_producto = $db->consulta($sql_producto);

   $result_producto_row = $db->fetch_assoc($result_producto);

   $result_producto_row_num = $db->num_rows($result_producto);

   

    





?>

<article class="module width_full">

		<header>

			<h3 class="tabs_involved">DATOS DE ENTRADA DEL PRODUCTO</h3>



  <ul class="tabs">

                <li><a href="#" onClick="aparecermodulos('productos/fa_productos.php','main');">Agregar Productos</a></li>

                </ul>

               <ul class="tabs"> 

                 <li><a href="#" onClick="aparecermodulos('productos/vi_productos.php','main');">Ver Productos</a></li>

			</ul>

</header>

 <div class="module_content">

<?php  echo "el id es :".$cadena_id ?>

   

     <form action="productos/ga_subirImagen.php" method="post" enctype="multipart/form-data" target="a_subir" name="f_subirarchivo" id="f_subirarchivo" >

     <fieldset>

		<label style="display:block; width:100%">IMAGEN DEL PRODUCTO: <?php echo $result_producto_row['nombre'];?> ID: <?php echo $result_producto_row['idproducto'];?> </label>

        <input name="archivo" style="width:250px; display:block" type="file" id="archivo"/>

        <input name="tipo" type="hidden" value="1" id="tipo"/>

        <input name="id_producto" type="hidden" value="<?php echo $result_producto_row['idproducto']; ?>" id="id_producto"/>

        <input type="button" name="buttonsubir" id="buttonsubir" class="alt_btn" value="Subir" onclick="comprueba_extension(this.form, this.form.archivo.value, this.form.archivo.disabled)"/> 

        Tama&ntilde;o de Imagen 280px x 280px, Peso M&aacute;ximo 250 KB(. jpg)

        </fieldset>

     </form>

    

     

          

 

    <fieldset>

       <div style=" float:left" id="d_logos">

          <a href="#">

          <img style="margin-left:10px; border-radius:5px" height="302" width="271" onclick="mostrarImagen('d_logos',1,'<?php echo $result_producto_row['idproducto'];?>')" src="<?php if ( $result_producto_row['foto'] != "" ){ echo 'productos/imagenes/'.$result_producto_row['foto'];} else { echo "images/sin_logotipo.jpg"; }?>" />

          </a>

      </div>

      <div style="vertical-align:top">

            <iframe name="a_subir" width="60%" height="70px" scrolling="no" style="border:0; color:#FFF; border-radius:5px" id="a_subir">

                    

            </iframe>

        </div>

    </fieldset>

    </form>

    </div>

    <footer>

      

    </footer>        

</article>



<?php

}

catch (Exception $e)

{

	echo "Error: ".$e;

}

?>