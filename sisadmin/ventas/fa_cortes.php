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
   require_once("../clases/class.Sucursales.php");
   
   
   $db = new MySQL();
   $suc = new Sucursales();
   
   $suc->db = $db;
   	  
	  
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
<div id="main2">
<article class="module width_full">

    <header>

   		<h3 class="tabs_involved">INICIO DE CAJA</h3>

    </header>

    

    <div class="module_content">

    <form id="alta_categoria" name="alta_categoria" method="post" action="">

        <fieldset>

        	<label class="width_full" for="estado">

                 <span id="requerido">&bull;</span> Caja chica

           </label>

           <input type="text" name="caja_chica" id="caja_chica" style="width:190px; display:block" title="Campo Caja Chica" placeholder="550.00" />

           
           <label class="width_full">Sucursal:</label>
            <select id="sucursal" name="sucursal" style=" width:200px; display:block" title="Sucursal">
						<?php 
				
							  do
							   {
						?> 					  
								<option value="<?php echo $result_sucursal_row['idsucursales'];?>"><?php echo $result_sucursal_row['sucursal']; ?></option>
                       <?php 	   
								}while($result_sucursal_row = $db->fetch_assoc($result_sucursal));
						?>
            		</select>
        </fieldset>

    </form>

    </div>

    <footer>

        <div class="submit_link">

            <input type="button" value="Iniciar Caja" class="alt_btn" onclick="var resp=MM_validateForm('caja_chica','','R isNum'); if(resp==1){ G_corte();}">

        </div>

    </footer>        

</article>

</div>