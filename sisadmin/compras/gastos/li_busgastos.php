<?php

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Gastos.php");
require_once("../../clases/class.Botones.php");
require_once("../../clases/class.Funciones.php");

$idmenu=$_GET['idmenumodulo'];

$db = new MySQL();
$fe = new Fechas();
$gas = new Gastos();
$bt = new Botones_permisos();
$fu= new Funciones();

$gas->db = $db;

$mesactual = $fe->mesAnho();
$anhoactual = $fe->anho();


$mesbuscar = $_POST['mes'];
$anhobuscar = $_POST['anho'];
$tipo = $_POST['tipo'];

//BUSCAMOS LOS CORTES QUE EXISTEN DEL MES ACTUAL


//echo "Entramos a realizar la consulta";

$result = $gas->VerGastosMes($mesbuscar,$anhobuscar,$tipo);

 $result_num = count($result);

$e_estatus = array('PENDIENTE','PAGADO','CANCELADO');

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/


?>  

<table  cellspacing="0"  class="table data-table table-bordered " id="tablacolores" > 
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
			
			if($result_num != 0)
			 {
				 
				$total = 0;
				foreach($result as $gastos)
				{
					
					$total = $total + $gastos->monto;
					
				
			?>
           
				
				<tr  >
				   
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
												$bt->funcion = "BorrarDatos('".$gastos->idgastos_detalles."','idgasto_detalles','gastos_detalles','n','compras/gastos/vi_ingreso_gastos.php','main',".$idmenu.")";
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