<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();
$idmenu=$_GET['idmenumodulo'];

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

if (!isset($_SESSION)) 
{
  session_start();
}
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Gastos.php");
require_once("../../clases/class.Botones.php");


$db = new MySQL();
$fe = new Fechas();
$gas = new Gastos();
$fu = new Funciones();
$bt = new Botones_permisos();
$gas->db = $db;



$mesactual = $fe->mesAnho();
$anhoactual = $fe->anho();


//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/




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

<div class="card">
	<div class="card-header">
		
		
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;">GASTOS AL MES</h5>
		

		
							<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "Nuevo Gasto";
										$bt->icon = "fas fa-plus";
										$bt->funcion = "aparecermodulos('compras/gastos/fa_ingreso_gastos.php?idmenumodulo=".$idmenu."','main');";
										$bt->estilos = "float:right;margin-right: 10px; margin-top: 6px;";
										$bt->permiso = $permisos;
										$bt->tipo = 1;

										$bt->armar_boton();
									?>
		
		
	</div>


	<div class="card-body">
		<div class="row">
			<div class="col-md-12" ></div>
			
			<div class="col-md-3">
				<div class="form-group">
					<label for="mes_gastos" style="width:50px;">MES</label>
					 <select name="mes_gastos" id="mes_gastos" class="form-control">
					 	<option value="0">TODOS LOS MESES</option>
						<?php 
					   	for($i = 1 ; $i<= 12 ; $i++)
					   	{
						?>
					 	<option value="<?php echo $i; ?>" <?php if($i == $mesactual) { echo 'selected'; } ?>><?php echo $fe->mesesAnho[$i-1]; ?></option>            
						<?php 
						}
						?>
					 </select>
				</div>	
			</div>
			
			<div class="col-md-3">
				<div class="form-group">
					<label for="anho_gastos">A&Ntilde;O</label>
            		<select name="anho_gastos" id="anho_gastos" class="form-control">
             		<?php 
			   		for($i = 2011 ; $i<= 2020 ; $i++)
			   		{
					?>
            			<option value="<?php echo $i; ?>" <?php if($i == $anhoactual) { echo 'selected'; } ?>><?php echo $i; ?> </option>            
            		<?php 
			   		}
			   		?>
         			</select>
				</div>
			</div>
			
			<div class="col-md-3">
				<label for="v_tipo" >Estatus</label>
            	<select name="v_tipo" id="v_tipo"  class="form-control">
           	 		<option value="todo" selected="selected" >Todo</option>    
            		<option value="0" >PENDIENTE</option>  
            		<option value="1" >PAGADO</option>  
            		<option value="2" >CANCELADO</option>  
        	 	</select>
			</div>
			
			<div class="col-md-3">
				<br>
				
				<button  onClick="b_gastos(<?php echo $idmenu; ?>)" class="btn btn-outline-primary"  style="margin-top: 5px; " >  <i class="fas fa-sliders-h"></i>  BUSCAR</button>
				
			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-body" id="li_modulos">
		<table  cellspacing="0"  class="table data-table table-bordered " id="tablacolores"> 
			<thead> 
				<tr class="px-3 py-5 bg-gradient-info text-white">
				 	<th style="text-align:center">FECHA GASTO</th> 
    				<th style="text-align:center">CODIGO GASTO</th> 
    				<th style="text-align:center">DESCRIPCION</th> 
                    <th style="text-align:center">MONTO GASTADEO</th>
                    <th style="text-align:center">EST.</th>
                    <th style="text-align:center">ACCIONES</th>
				</tr> 
			</thead>
			
			<tbody> 
            
            <?php			
				//echo "Entramos a realizar la consulta";
				$result = $gas->VerGastosMes($mesactual,$anhoactual,'todo');
				$result_num = count($result);
				$e_estatus = array('PENDIENTE','PAGADO','CANCELADO');
			
				if($result_num != 0)
				{
					$total = 0; 
		  			foreach($result as $gastos)
					{
						$total = $total + $gastos->monto;	
			?>
           
				<tr>
				   
   				  <td align="center"><?php echo $fu->imprimir_cadena_utf8($fe->fechaadd_mm_YYYY_guion($gastos->fecha)); ?></td> 
   				  <td align="center"><?php echo $fu->imprimir_cadena_utf8($gastos->categoria); ?></td> 
   				  <td align="center"><?php echo $fu->imprimir_cadena_utf8($gastos->descripcion); ?></td> 
         		  <td align="right">$ <?php echo $fu->imprimir_cadena_utf8(number_format($gastos->monto,2,'.',',')); ?></td>
         		  <td align="center"><?php echo $fu->imprimir_cadena_utf8($e_estatus[$gastos->estatus]); ?></td> 
       
    
                  <td align="center">
					  
					 
					  
					    <?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos ('compras/gastos/fa_ingreso_gastos.php?id=".$gastos->idgastos_detalles."&idmenumodulo=$idmenu','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
					  
                  
				 <?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$gastos->idgastos_detalles."','idgastos_detalles','gastos_detalles','n','compras/gastos/vi_ingreso_gastos.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>	
                  </td> 
				</tr>
            <?php
			}; //termina el each			
			?>
        <tr>
            
            <td colspan="4" align="right">TOTALES</td>
            <td align="right" bgcolor="#FFFFCC">&nbsp;</td>
            <td align="right" bgcolor="#FFFFCC">$ <?php echo number_format($total,2,'.',','); ?></td>
             </tr> 
			<?php
			
			 }
			   else
			 {
				 ?>
				
   				
				
            	<tr>
                	<td colspan="6" align="center">
                  		  <h4 class="alert_warning">EN ESTE MOMENTO NO EXISTE NINGUN GASTO</h4>
                    </td>
                </tr> <?php

			  }
			?>
			</tbody> 
		   </table>
	</div>
</div>