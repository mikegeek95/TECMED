<?php

require_once ("../clases/conexcion.php");
require_once ("../clases/class.Credito.php");
try{

$db = new MySQL ();
$credito = new creditos ();

$credito->db = $db ;

//$result_credito = $credito->obtenerDatosCredito();
?>

<div class="module width_full">

<article id="article_bu"  class="module width_full" >
<?php

/*$deuda = $credito->obtenerDeuda();
$pagos = $credito->totalPagos();*/
?>

<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
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
					   "sScrollX": "100%",
		               "sScrollXInner": "100%",
		               "bScrollCollapse": true
					  
					  
						
				} );
				} );
				
				</script>
		<header>
			<h3 class="tabs_involved">LISTA DE CREDITOS CON ADEUDO</h3>     
		</header>
        
        <div style="height:auto; width:100%; overflow:auto;" id="tbl_creditos">
        <?php
        	$creditos = $credito->verListaNotaderemisionCreditos();
			$estatus = array("DEBE","PAGADO");
		?>

        <table  class="tablesorter" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr>
				  <th align="center">ID CREDITO</th> 
   					<th align="center">ORD. COMPRA</th> 
    				<!--<th>FECHA</th>-->
                  <th align="center">TOTAL</th>
                    <th align="center">ESTATUS</th>
                  <th align="center">ACCI&Oacute;N</th>
			  </tr> 
			</thead> 
			<tbody> 
          <?PHP foreach($creditos as $c )
				{
				?>
          <tr <?php if($c->estatus == 1 ){ echo 'style="background-color:#CEFFC0 "'; }?>  >
            <td align="center"><?php echo $c->idcredito?></td>
          
            <td align="center"><?php echo $c->idnota_remision?></td>
            <td align="center">$<?php echo $c->cantidad?></td>
            <td align="center"><?php echo $estatus[ $c->estatus]?></td>
            <td align="center"><input type="button" onClick="colocarIdNotaCaja(<?php echo $c->idnota_remision?>);buscarCredito();" value="COLOCAR"  /></td>
          </tr>
          <?PHP
          	 
				}
		  
		  ?>
        </table>
        </div>
</article>        


<!--
<article id="cliente"  class="module width_half">
<?php

/*$deuda = $credito->obtenerDeuda();
$pagos = $credito->totalPagos();*/
?>
		<header>
			<h3 class="tabs_involved">CLIENTE</h3> 
		</header>
        
          <div class="module_content">
          	<center>
            <table width="413" border="0">
              <tr>
                <td width="142" align="right">Cliente:</td>
                <td width="261"><span id="nom_cliente"></span></td>
              </tr>
              
              <tr>
                <td align="right">Email:</td>
                <td><span id="email" ></span></td>
              </tr>
              <!--<tr>
                <td align="right">Adeudo:</td>
                <td>$<span ></span></td>
              </tr>
            </table>
            </center>
          </div>
</article> 

<article id="article_bu"  class="module width_full">
<?php

/*$deuda = $credito->obtenerDeuda();
$pagos = $credito->totalPagos();*/
?>
		<header>
			<h3 class="tabs_involved">BUSCAR</h3>
		</header>
        
        <div class="module_content">
        	<fieldset>
            	<form >
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="16%"><label for="id_nota_remision">Ord. de Compra</label></td>
    <td width="64%"><input title="Id Nota Remision" value="<?php //if (isset ($_GET['idnota_remision']) ){ echo $_GET['idnota_remision'];}?>" type="text" style="width:200px; float:left" id="id_nota_remision" /></td>
    <td width="20%"><input  style=" margin-left:16px; float:left" type="button" id="alt_btn" value="Buscar" onclick="var resp = MM_validateForm('id_nota_remision','','RisNum'); if (resp == 1) {buscarCredito();}" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><span id="msj_erro" style="text-align:center; font-size:12px; width:100%"></span></td>
    </tr>
        </table>
               </form>
            </fieldset>
        </div>
        
</article>        
-->



<!-- <article id="deuda"  class="module width_full">
<?php

/*$deuda = $credito->obtenerDeuda();
$pagos = $credito->totalPagos();*/
?>
		<header>
			<h3 class="tabs_involved">DATOS DE ADEUDO</h3>
     
		</header>
        <input title="Id Nota Remision" value="<?php //if (isset ($_GET['idnota_remision']) ){ echo $_GET['idnota_remision'];}?>" type="hidden" style="width:200px; float:left" id="id_nota_remision" />
          <div class="module_content">
          	<center>
           <table width="100%" border="0">
            <tr>
                <td width="136" align="right">Cliente:</td>
                <td width="824"><span ></span></td>
              </tr>
              
              <tr>
                <td align="right">Email:</td>
                <td><span id="email" ></span></td>
              </tr>
              <tr>
                <td width="136" align="right">Id Credito:</td>
                <td width="824"><span id="idcredito"></span></td>
              </tr>
              <tr>
                <td width="136" align="right">Id Nota Remision:</td>
                <td width="824"><span id="idn"></span></td>
              </tr>
              <tr>
                <td align="right">Total de Pagos:</td>
                <td><span id="totalPagos"><?php // echo $pagos['totalp'];?></span></td>
              </tr>
              <tr>
                <td align="right">Adeudo Total:</td>
                <td>$<span id="deudatotal"><?php //echo $deuda['debe'];?></span></td>
              </tr>
              <tr>
                <td align="right">Adeudo Pendiente:</td>
                <td>$<span id="adeudo"><?php //echo $deuda['debe'];?></span></td>
              </tr>
            </table>
            </center>
          </div>
</article> -->

<div class="clear"></div>
<div class="spacer"></div>
</div>

<article  class="module width_full">
		 <header>
			<h3 class="tabs_involved">ABONAR</h3>
		</header>
        
       <div class="module_content">
       <fieldset>
       	<legend><h3>Datos de Adeudo</h3></legend>
            <input title="Id Nota Remision" value="<?php if (isset ($_GET['idnota_remision']) ){ echo $_GET['idnota_remision'];}?>" type="hidden" style="width:200px; float:left" id="id_nota_remision" />
            <label style="width:100%; float:left; font-size:14px;">Nombre Cliente: &nbsp;
                <span id="nom_cliente" style="font-size:16px; color:#006"></span>
            </label>
            <label style="width:100%; float:left; font-size:14px;">E-mail: &nbsp;
                <span id="email" style="font-size:16px; color:#006"></span>
            </label>
            <label style="float:left; font-size:14px;">ID Credito: &nbsp;
                <span id="idcredito" style="font-size:16px; color:#006"></span>
            </label>
            <label style="float:left; font-size:14px;">ID Nota Remisi&oacute;n: &nbsp; 
                <span id="idn" style="font-size:16px; color:#006"></span>
            </label>
            <label style="float:left; font-size:14px;">Total de pagos: &nbsp;
                <span id="totalPagos" style="font-size:16px; color:#006"></span>
            </label>
            <label style="float:left; font-size:14px;">Adeudo Total: &nbsp;$ 
                <span id="deudatotal" style="font-size:16px; color:#006"></span>
            </label>
            <label style="width:100%;float:left; font-size:14px;">Adeudo Pendiente: &nbsp;$ 
                <span id="adeudo" style="font-size:16px; color:#006"></span>
            </label>   
        </fieldset>
       <fieldset>
       
       <table width="90%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="6%" align="right"><label for="pagoC">Abono:</label></td>
    <td width="44%" align="left"><input type="text" style="width:200px;"  name="pagoC" id="pagoC" title="Pago" /></td>
    <td width="24%" align="right"><label for="tipo">Tipo Pago:</label> </td>
    <td width="26%" align="left"><select style="width:150px; height:24px;  " id="tipo" name="tipo">
      <option value="0">Efectivo</option>
      <option value="1">Tarjeta</option>
      <option value="2">Deposito</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><label for="descrip">Descripcion:</label></td>
    <td colspan="3">
    	<textarea name="descrip" style="width:70%;" id="descrip" cols="2" rows="3">
        </textarea>
      	<input style="float:left; margin-top:25px;" type="button" id="pagar" class="alt_btn" value="Pagar" onclick="var resp = MM_validateForm('pagoC','','RisNum'); if (resp == 1){ pagarC ('<?php //echo $credito->idcretdito ?>'); }" />  
    </td>
  </tr>
</table>
       
       				
       </fieldset>
       
<!--#### Historial #######-->
	<div id="result_historial" style="height:auto; overflow:auto">    
    </div>    
<!--#### fin de tabla #######-->
       
       </div>
          
</article>





        
        
        <?php
        /* $sql_historial = "SELECT 
 cd.idcredito ,
 c.idnota_remision , 
 DATE(cd.fecha_deposito) AS fecha, 
cd.deposito ,
 CONCAT(cl.nombre,' ',cl.paterno,' ',cl.materno) AS cliente


 FROM credito c , credito_detalle cd , clientes cl 
WHERE
c.idcredito = cd.idcredito 
AND
c.idcliente = cl.idcliente AND c.idcredito = '$credito->idcretdito'";
			
			$result_historial = $db->consulta($sql_historial);
			$result_historial_row = $db->fetch_assoc($result_historial);
			$result_historial_row_num = $db->num_rows($result_historial);*/
		
		?>
        
           

<!--<article class="module width_full">
		<header>
			<h3 class="tabs_involved">HISTORIAL DE PAGOS</h3>
            
            
            <ul class="tabs">
            <li><a href="#"  onclick="reciboCreditoH('<?php //echo $credito->idcretdito ?>')">Imprimir</a></li>
            </ul>
             
		</header>
        
      
</article>

<article id="ventanaR" style="margin-top:50px; margin-top:20px; display:none;" class="module width_full">
		<header>
			<h3 id="tituloC" class="tabs_involved">COMPROBANTE DE PAGO</h3>  
		</header>
        <div class="module_content">
         <center>
        	
        	<iframe src="ventas/pdf/recibo_pago.php" height="600" width="600" id="recibo"></iframe>
        	
         </center>
        </div> 
</article>  -->      
<?php


		if (isset ($_GET['idnota_remision']) )
		{ 
			echo '<script>
						buscarCredito();
			
				  </script>';
		}

}//fin del try
catch (Exception $e)
{
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
	
}

?>