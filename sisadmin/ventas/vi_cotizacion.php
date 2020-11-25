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
	 require_once("../clases/class.Funciones.php");
	 require_once("../clases/class.Sucursales.php");
	 
	 $db = new MySQL();
	 $fn = new Funciones();
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
	 
	 
try{	 
	
 
 
 
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
 
        
         
    
        
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 
    
    <!--INICIAMOS A COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO   -->

	<link rel="stylesheet" href="js/calendarios//themes/base/jquery.ui.all.css">

	<script src="js/calendarios/jquery-1.7.2.js"></script>

	<script src="js/calendarios/ui/jquery.ui.core.js"></script>

	<script src="js/calendarios/ui/jquery.ui.widget.js"></script>

	<script src="js/calendarios/ui/jquery.ui.datepicker.js"></script>

	<!--TERMINAMOS DE COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->

	

		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_modulos').dataTable( {		
				       "ordering": false,	
					   "lengthChange": true,
					   "pageLength": 100,						
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
					   "sScrollX": "100%",
		               "sScrollXInner": "100%",
		               "bScrollCollapse": true,
					  
					  
						
					} );
					
					
					

				

				} );
								
				$("#f_alta").datepicker({ 
			
				   dateFormat: "yy-mm-dd", 
			
				   changeMonth: true,
			
				   changeYear: true,
			
				   showButtonPanel: true,
			
				   inline: true
			
				   });
				   
				   
				   
				   $("#f_recibido").datepicker({ 
			
				   dateFormat: "yy-mm-dd", 
			
				   changeMonth: true,
			
				   changeYear: true,
			
				   showButtonPanel: true,
			
				   inline: true
			
				   });
				
				</script>
                
      <article class="module width_full">
		<header>
			<h3 class="tabs_involved">COTIZACI&Oacute;N</h3>
         <ul class="tabs">
          <!--<li><a href="#" onClick="/*aparecermodulos('catalogos/fa_guias.php','main');*/ AbrirModalGeneral2('ModalPrincipal','900','360','ventas/fa_monedero.php');">Agregar Saldo</a></li>-->
          
          <li><a href="#" onClick="/*aparecermodulos('ventas/fa_apartado.php','main');*/ AbrirModalGeneral2('ModalPrincipal','900','560','ventas/fa_cotizacion.php');">Agregar Cotizaci&oacute;n</a></li>
		  
          </ul>
		</header>
		
 		<div  id="li_modulos" class="module_content">
    		<fieldset>
         		<table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <th scope="col"  align="left" style=" padding-left:15px;">Nombre</th>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">&nbsp;</th>
                      </tr>
                      <tr>
                        <td align="center" >
                            <input name="n_nombre" type="text" id="n_nombre" placeholder="Jose Luis Gomez Aguilar"  title="Nombre" style="width:75%" />
                            <img src="images/search.png" onClick="L_Clientes_venta_cliente();" width="16" style="margin-top:5px; cursor:pointer; float:left;" />
                            <input type="hidden" id="nombre" />
                        </td>
                      
                        <!--<td align="center">
                            <select id="v_sucursal" name="v_sucursal">
                                <?php
                                            if($tipo == 0){ 
                                            ?>
                                             <option value="0" selected>Todas</option>
                                             
                                             <?php
                                            }
                                             ?>
                                             
                                <?php
                                do
                                { 
                                ?>
                                <option value="<?php echo $result_sucursal_row['idsucursales']; ?>"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></option>
                                <?php
                                }while($result_sucursal_row = $db->fetch_assoc($result_sucursal));
                                ?>
                            </select>
                        </td>-->
                        
                        <td align="center">&nbsp;</td>
                        
                        <td align="center">
                            <select id="v_estatus" name="v_estatus">
                                <option value="1">ACTIVO</option>
                                <option value="0">CANCELADO</option>
                            </select>
                        </td>
                        
                        <td align="center">&nbsp;</td>
                      
                      </tr>
  				</table>
         </fieldset>
        
        
        </div>  
        <footer>
				<div class="submit_link">
					
					<input type="submit" value="Buscar Movimientos" class="alt_btn" onClick=" b_cotizacion('li_guias');">
					
				</div>
			</footer>          
        </article>       
        
        

                
                
                
    <article class="module width_full">
		<header>
		<!--	<h3 class="tabs_involved">PRODUCTOS</h3>
            <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('productos/fa_productos.php','main');">Agregar Productos</a></li>
			</ul>-->
		</header>
		
		<div  id="li_guias" class="tab_container" style="overflow:auto;">
       
	
	
        
		</div><!-- end of .tab_container -->		
</article>
<?php
}//fin del try
catch (Exception $e)
{
	 $v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
		 echo $db->m_error($n[0]);
}
?>