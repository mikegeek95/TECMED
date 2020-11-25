<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

     header("Content-Type: text/text; charset=ISO-8859-1");
    
	 require_once("../clases/conexcion.php");	 
     require_once("../clases/class.Ventas.php");
	 require_once("../clases/class.Clientes.php");

	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
		
	  $vent->db = $db;
	  $client->db = $db;
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');
	  
if(isset($_GET['ac']))
{
	if($_GET['ac']==1){
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}else{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	echo $msj;
}

 ?>
 
 
 <!--INICIAMOS A COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	<link rel="stylesheet" href="js/calendarios//themes/base/jquery.ui.all.css">
	<!--<script src="js/calendarios/jquery-1.7.2.js"></script>--> <!--QUITO ESTA LIBRERIA POR QUE CHOCA JUNTO CON LA TABLA-->
	<script src="js/calendarios/ui/jquery.ui.core.js"></script>
	<script src="js/calendarios/ui/jquery.ui.widget.js"></script>
	<script src="js/calendarios/ui/jquery.ui.datepicker.js"></script>
	
	
	
	<!--TERMINAMOS DE COLOCAR LOS ARCHIVOS PARA HACER FUNCIONA EL CALENDARIO -->
	
	
  
 <script>
 
    $("#f_inicio").datepicker({ 
	   dateFormat: "yy-mm-dd", 
	   changeMonth: true,
       changeYear: true,
	   inline: true
	   });
	   
	   $("#f_fin").datepicker({ 
	   dateFormat: "yy-mm-dd", 
	   changeMonth: true,
       changeYear: true,
	   inline: true
	   });
	   
	
  </script>
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
 
 <div class="card ">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">VENTAS CLIENTES</h5>
 	</div>
 		<div class="card-body">
			<form action="" name="filtro" id="filtro">
				<div class="row">
					<div class="col-md-4">
						<div class="input-group">
							<label for="nombre" style=" width: 100%; display: block;"  >Nombre:</label>
							<input class="form-control" type="text" id="n_nombre" placeholder="Jose Luis Gomez Aguilar" name="nombre" title="Campo Nombre">
							<div class="input-group-append" onClick="L_Clientes_venta_cliente();" >
								<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
							</div>

							<!--<img src="images/search.png" onClick="L_Clientes_venta_cliente();"  width="16" style="margin-top:5px; cursor:pointer;" />-->
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">	
							 <input type="hidden" id="nombre" />
							 <label for="f_inicio" >Fecha Inicio:</label>
							 <input class="form-control" placeholder="2016-01-01" type="text" title="Campo Fecha Inicio" id="f_inicio" name="f_inicio" >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">	
							<label for="f_fin" style="width:100px;display: block; ">Fecha Fin:</label>
							<input class="form-control" type="text" placeholder="2016-12-31" title="Campo Fecha Fin" id="f_fin" name="f_fin">
						</div>
					</div>	
					<div class="col-md-12">
						<div class="f-right">
							<input class="btn btn-info" type="button" value="Buscar" onClick="var resp=MM_validateForm('nombre','','R'); if(resp==1){ buscarVentaCliente('filtro'); }" >
						</div>
					</div>


				</div>	
			</form>
		</div>	


					
		  <!--<div id="li_modulos" class="module_content">
          <fieldset style="width:100%">
          
          	<form action="" name="filtro" id="filtro">
            <table>
              
              <tr>
              	<td align="center"><label for="nombre"  style="width:100px; " >Nombre:</label></td>
                <td align="left"><input style="width:110px; " type="text" id="n_nombre" placeholder="Jose Luis Gomez Aguilar" name="nombre" title="Campo Nombre"><img src="images/search.png" onClick="L_Clientes_venta_cliente();" width="16" style="margin-top:5px; cursor:pointer;" />
                <input type="hidden" id="nombre" /></td>
                <td  align="center"><label for="f_inicio" style="width:100px; ">Fecha Inicio:</label></td>
                <td  align="left"><input style="width:110px; " placeholder="2016-01-01" type="text" title="Campo Fecha Inicio" id="f_inicio" name="f_inicio" ></td>
                <td  align="center"><label for="f_fin" style="width:100px; ">Fecha Fin:</label></td>
                <td  align="left"><input style="width:110px; " type="text" placeholder="2016-12-31" title="Campo Fecha Fin" id="f_fin" name="f_fin"></td>
                <td>&nbsp;</td>
                <td align="center">
                	<div class="submit_link">
                    	<input type="button" value="Buscar" onClick="var resp=MM_validateForm('nombre','','R','f_inicio','','R','f_fin','','R'); if(resp==1){ buscarVentaCliente('filtro'); }" >
                    </div>
                </td>
              </tr>
              
            </table>
            </form>
          </fieldset>
         
          <!--############### tabla de pedidos #############-->
                          

    	

</div>
 <div class="card ">
 		<div class="card-body">

    <div id="li_pedidos" class="tab_container">
</div>

</div>

    
  
    
 
 
