<?php
    require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   require_once("../clases/class.Fechas.php");
   require_once("../clases/class.Ventas.php");
   require_once("../clases/class.Clientes.php");

   $db = new MySQL();
   $carrito = new ShoppingCar(); 
   $f = new Fechas(); 
   $ven = new Ventas();
   $cli = new Clientes();
   
   $ven->db = $db;
   $cli->db = $db;
   
   $idcotizazion = $_GET['id'];
   $ven->idcotizacion = $idcotizazion;
   
   //Obtenemos la cotizacion
   $result_cotizacion = $ven->verDatosReciboCotizacion();
   
   $idcliente = $result_cotizacion['idcliente'];
   $cli->idCliente = $idcliente;
   
   $result_cliente = $cli->ObtenerInformacionCliente();
   $nombre = utf8_encode($result_cliente['nombre']." ".$result_cliente['paterno']." ".$result_cliente['materno']);
   
   
   
   $idsucursales = $_SESSION['se_sas_Sucursal'];

	//$fecha_fin = $f->diaultimodelsiguientemes();
	
	
	//Levantamos de nuevo el shopping car
	$carrito->levantarShoppingCotizacion($idcotizazion,$idsucursales);
	

?>

<script type="text/javascript" src="js/fn_PuntodeVenta.js"></script>

<!--INICIAMOS A COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	<link rel="stylesheet" href="js/calendarios//themes/base/jquery.ui.all.css">
	<script src="js/calendarios/jquery-1.7.2.js"></script>
	<script src="js/calendarios/ui/jquery.ui.core.js"></script>
	<script src="js/calendarios/ui/jquery.ui.widget.js"></script>
	<script src="js/calendarios/ui/jquery.ui.datepicker.js"></script>
<!--TERMINAMOS DE COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	 
 <script>

  $(document).ready(function() {
    $("#f_fin").datepicker({ 
	   dateFormat: "yy-mm-dd", 
	   timeFormat: 'hh:mm:00',
	   changeMonth: true,
       changeYear: true,
	   inline: true
	   });
	   
	
  });
  </script>

<div id="ModalSecundaria" class="ventana">
<div id="Close" style="text-align: right">
      <img src="images/004.png" width="16" height="16" onClick="$('#ModalSecundaria').css('display','none'); $('#contenido_modal_dos').html('');" style="cursor:pointer">
</div>

    <div id="contenido_modal_dos" >
   
    </div>

</div>


<div id="main2">
   <form id="alta_categorias" name="alta_categorias" method="post" action="">


<div class="module width_full"> 
   <header>
   		<h3 class="tabs_involved">GENERAR COTIZACI&Oacute;N</h3>
   </header> 

<article class="module width_half">

  <header>
   		<h3 class="tabs_involved">CLIENTES</h3>
        <!--<ul class="tabs">
             <li class="alt_btn">
                 <a href="#" onClick="L_Clientes_cotizacion();">Clientes</a></li>
             </ul>-->
       
  </header>
    
    <div class="module_content">

       <fieldset  > 
          <label  for="v_nombre_cliente">
              <span id="requerido">&bull;</span> CLIENTES 
          </label>
          <input name="v_nombre_cliente" type="text" id="v_nombre_cliente" placeholder="Jose Luis Gomez Aguiar" style="width:90%;" title="Campo Nombre de la Categor&iacute;a" onkeypress="bloquearMas(event.keyCode);" value="<?php echo $nombre; ?>" readonly />
          
          <input name="v_idcliente" type="hidden" id="v_idcliente" value="<?php echo $idcliente; ?>" />
          
          <!--<label>Abono</label>
          <input type="text" id="abono" name="abono" title="Campo Abono" style="width:90%;" />
          
          <label>Fecha Fin</label>
          <input type="text" id="f_fin" name="f_fin" title="Campo F. Fin" value="<?php echo $fecha_fin; ?>" style="width:90%;" />-->
          
      </fieldset>
      

   </div>
</article>



<article class="module width_half">

  <header>
  
   		<h3 class="tabs_involved">AGREGA PRODUCTOS</h3>
       <ul class="tabs">
             <li><a href="#" onClick="L_Productos_cotizacion();">Productos</a></li> 
        </ul>    
  </header>
  
    
   <div class="module_content"> 
     <fieldset>
       <label for="v_idproducto" >ID PRODUCTO</label>
      <input type="text" name="v_idproducto" id="v_idproducto" style="width:90%;" onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); addproductoCotizacion()"/>
      
      <input name="v_cantidad" type="hidden" id="v_cantidad" value="1" />
     </fieldset>
   </div>
</article>
<div class="clear"></div>
<div class="spacer"></div>

</div>





<article class="module width_full">

  <header>
  
   		<h3 class="tabs_involved">DETALLES</h3>
       <!-- <ul class="tabs">
             <li><a href="#" onClick="G_Pedido();">Guardar F4</a></li>
             <li><a href="#" onClick="L_Productos();">Productos F8</a></li> 
        </ul>    -->
  </header>
  
    
   <div class="module_content" >    
       
    
    
       
            <div id="d_productos_shoping" >
             <?php 
                $carrito->verCarritoCotizacion($idcliente);
             ?>
            </div>
    
      
    
    
  </div>
    <footer>

        <div class="submit_link">
        	<input name="idCotizacion" type="hidden" id="idCotizacion" value="<?php echo $idcotizazion; ?>" />
        	<input name="v_sucursal" type="hidden" id="v_sucursal" value="<?php echo $idsucursales;  ?>" />
            <input type="button" value="Generar Cotizaci&oacute;n" class="alt_btn" onclick="Act_Cotizacion();" style=" background-repeat:repeat">
        </div>
    </footer>        
</article>

    </form>
    
    </div>