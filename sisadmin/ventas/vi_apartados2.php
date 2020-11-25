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
			$msj='<div id="mens" class="alert alert-success" role="alert">'.$_GET['msj'].'</div>';
		}
		else
		{
			$msj='<div id="mens" class="alert alert-danger" role="alert">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
		}

		echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';

		echo $msj;
	}	
 
 
 ?>

		<script type="text/javascript" charset="utf-8">
				
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



<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">APARTADOS</h5>
		<button type="button" onClick="aparecermodulos('ventas/fa_apartado.php','main'); /*AbrirModalGeneral2('ModalPrincipal','900','560','ventas/fa_apartado.php');*/" class="btn btn-info" style="float: right;">AGREGAR APARTADO</button>
		<div style="clear: both;"></div>
	</div>
  	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Nombre:</label>
							<div class="input-group">
								<input name="n_nombre" type="text" id="n_nombre" placeholder="Jose Luis Gomez Aguilar"  title="Nombre" class="form-control" />                   				
								<div class="input-group-append" onClick="L_Clientes_venta_cliente();">
									<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
								</div>
								<input type="hidden" id="nombre" />
							</div>
						</div>
					</div>
				
					<div class="col-md-3">
						<div class="form-group">
							<label>Estatus:</label>
							<select id="v_estatus" name="v_estatus" class="form-control">
								<option value="1">ACTIVO</option>
								<option value="0">CANCELADO</option>
							</select>
						</div>
					</div>
			</div>
		</form>
  	</div>
	
	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="b_apartado('li_apartados');" style="margin-top: 5px;" >
	</div>
</div>


<div class="card">
	<div class="card-body">
		<div id="li_modulos" class="module_content">
    		<div id="li_apartados" class="tab_container">
    			
			</div>
		</div>	
	</div>
</div>

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