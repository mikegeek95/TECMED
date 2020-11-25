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
	require_once("../clases/class.Productos.php");
	require_once("../clases/class.Sucursales.php");
	 
	$db = new MySQL();
	$suc = new Sucursales();
	
	$suc->db = $db;

	$sql = "SELECT * FROM productos ORDER BY nombre ASC";
	$result_productos = $db->consulta($sql);
	$result_productos_row = $db->fetch_assoc($result_productos);
	$result_productos_num = $db->num_rows($result_productos);	
	
	
	$tipo = $_SESSION['se_sas_Tipo'];

	 
	 //Validamos que sea superUsuario
	if($tipo == 0){
		//Puede hacer movimientos de todas las sucursales
		$result_sucursal = $suc->todasSucursales();
		$result_sucursal_row = $db->fetch_assoc($result_sucursal);
		
	}else{
		//solo hace movimientos para su sucursal
		$idsucursales = $_SESSION['se_sas_Sucursal'];
		
		//Obtenemos los datos de la sucursal
		$suc->idsucursales = $idsucursales;
		$result_sucursal = $suc->buscarSucursal();
		$result_sucursal_row = $db->fetch_assoc($result_sucursal);
		
		//$n_sucursal = "Sucursal: ".$result_sucursal_row['sucursal'];
		
	}
	
	
	//Todas las sucursales
	$result_sucursales = $suc->todasSucursales();
	$result_sucursales_row = $db->fetch_assoc($result_sucursales);
 	
	
	
?>

<article class="module width_full">

    <header>

   		<h3 class="tabs_involved">TRASPASO DE PRODUCTO A SUCURSAL</h3>

        <ul class="tabs">

                <li><a href="#" onClick="aparecermodulos('productos/vi_traslado.php','main');">Ver Traspasos</a></li>

			</ul>

    </header>

    

    <div class="module_content">

    <form id="alta_etiquetas" name="alta_etiquetas" method="post" action="">

    

        <fieldset>   

        <!--</fieldset>

    	<fieldset>-->
          
          <label class="width_full" for="producto">
                 <span id="requerido">&bull;</span> Producto</label>
           
           		<select id="producto">
             
                	<?php
					if($result_productos_num != 0){
						do
						{ 
					?>
                   		<option value="<?php echo $result_productos_row['idproducto'] ?>"><?php echo utf8_encode($result_productos_row['nombre']); ?></option>
                    <?php
						}while($result_productos_row = $db->fetch_assoc($result_productos));
					}else{
					?>
                    	<option value="">&nbsp;</option>
                    <?php
					}
					?>
                </select>
           
           
           <label class="width_full" for="cantidad">
                 <span id="requerido">&bull;</span>Cantidad</label>
           
           <select id="cantidad">
                    	<option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                </select>
           
           <label class="width_full" for="de">
                 <span id="requerido">&bull;</span>De</label>
           <select id="de">
             
                	<?php
						do
						{ 
					?>
                   		<option value="<?php echo $result_sucursal_row['idsucursales']; ?>"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></option>
                    <?php
						}while($result_sucursal_row = $db->fetch_assoc($result_sucursal));
					?>
                </select>
           
           <label class="width_full" for="para">
                 <span id="requerido">&bull;</span>Para</label>
                 <select id="para">
             
                	<?php
						do
						{ 
					?>
                   		<option value="<?php echo $result_sucursales_row['idsucursales']; ?>"><?php echo utf8_encode($result_sucursales_row['sucursal']); ?></option>
                    <?php
						}while($result_sucursales_row = $db->fetch_assoc($result_sucursales));
					?>
                </select>
           
           

      </fieldset>

    </form>

    </div>

    <footer>

        <div class="submit_link">

            <input type="button" value="Guardar" class="alt_btn" onclick="var resp=MM_validateForm('cantidad','','R isNum'); if(resp==1){ GuardarTraspaso('alta_etiquetas','productos/ga_traslado.php','productos/vi_traslado.php','main');}">

        </div>

    </footer>        

</article>