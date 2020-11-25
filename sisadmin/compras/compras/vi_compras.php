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

     require_once("../../clases/conexcion.php");
     require_once("../../clases/class.Funciones.php");
     require_once("../../clases/class.Botones.php");
	require_once("../../clases/class.Sucursales.php");
	 
	 $db = new MySQL();
	 $f = new Funciones();
	$suc = new Sucursales();
	 $bt = new Botones_permisos();

$suc->db=$db;

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/



try { 
	 $sql_compras = "SELECT
usuarios.nombre AS nombreu,
compras.idcompras,
compras.idusuarios,
compras.fecha,
compras.idsucursales,
compras.fecha_compra,
compras.prioridad,
compras.descripcion,
compras.estatus
FROM
compras
INNER JOIN usuarios ON compras.idusuarios = usuarios.idusuarios order by fecha desc";
	 $result_compras = $db->consulta($sql_compras);
	 $result_compras_row = $db->fetch_assoc($result_compras);
	 $result_compras_row_num = $db->num_rows($result_compras);
	 
	 $b_estatus = array("ACTIVO","CANCELADO","COMPRADO");
	 $b_prioridad = array ("NORMAL","URGENTE","ALTA");
	 
 	 /*$sql_usuario = "SELECT * FROM usuarios WHERE idusuarios = ".$result_compras_row['idusuarios'];
	 $result_usuario = $db->consulta($sql_usuario);
	 $result_usuario_row = $db->fetch_assoc($result_usuario);*/
	
 ?>
<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_modulos').dataTable( {		

	  "oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
					"sZeroRecords": "Nada Encontrado - Lo sentimos",
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
</script>
                
 <div class="card">
	<div class="card-header">
		
		
		
		<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 15px;">LISTA DE COMPRAS</h5>
		
		

					<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "Nueva Compra";
										$bt->icon = "fas fa-plus";
										$bt->funcion = "aparecermodulos('compras/compras/fa_compras.php?idmenumodulo=".$idmenu."','main');";
										$bt->estilos = "float:right;margin-right: 10px; margin-top: 6px;";
										$bt->permiso = $permisos;
										$bt->tipo = 1;

										$bt->armar_boton();
									?>
			
		
		</div>
		<div class="card-body">
		
		<div class="table-responsive">
			<table id="d_modulos" class="table table-striped table-bordered">
				<thead class="px-3 py-5 bg-gradient-primary text-white">
					<tr>
						<th>ID COMPRA</th>
						<th>USUARIO</th>
						<th>SUCURSAL</th>
						<th>FECHA REGISTRO</th>
						<th>FECHA-COMPRA</th>
						<th>PRIORIDAD</th>
						<th>DESCRIPCION</th>
						<th>ESTATUS</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
 <?php
			if($result_compras_row_num == 0){
			}else{
            do
			{  
			   
			  
			      
			       
			?>
            
				<tr> 
   					  
   				   <td align="center" ><?php echo $result_compras_row['idcompras']; ?> </td>
   				   
                  <td align="center"><?php echo  $result_compras_row['nombreu'] ;?></td>
					<?php  
						$suc->idsucursales= $result_compras_row['idsucursales'];
						$nomsuc=$suc->buscar_sucursal();
						$suc_nom= $db->fetch_assoc($nomsuc);
					?>
					<td align="center"><?php echo  $suc_nom['sucursal'] ;?></td>
                 
                   <td align="center"><?php  $fecha=explode(" ",$result_compras_row['fecha']); echo $fecha[0]?></td>
                   
                   <td align="center"><?php echo $result_compras_row['fecha_compra']; ?></td>
                 
                   <td align="center"><?php echo $b_prioridad[$result_compras_row['prioridad']]; ?></td>
                   <td align="center"><?php echo $result_compras_row['descripcion']; ?></td>
                 
                    
                   <td align="center"><?php echo $b_estatus[$result_compras_row['estatus']]; ?></td>
                   
                   <td align="center">
                    
						

						<?php
								if($result_compras_row['estatus'] != 2){
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->icon = "far fa-edit";
										$bt->funcion = "aparecermodulos('compras/compras/fc_compras.php?id=".$result_compras_row['idcompras']."&idmenumodulo=".$idmenu."','main')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
								}
									?>
							
								<button data-toggle="modal" data-target="#modal-forms" type="button" onClick="AbrirModalGeneral2('ModalPrincipal','900','560','compras/compras/detalle_compra.php?id=<?php echo $result_compras_row['idcompras'];?>&idmenumodulo=<?php echo $idmenu ?>');" title="DETALLE DE COMPRA" class="btn btn-outline-primary"><i class="fas fa-list"></i></button>
					   
					   			<button data-toggle="modal" data-target="#modal-forms" type="button" onClick="imprimirPDF('compras/compras/pdf.php?id=<?php echo $result_compras_row['idcompras']; ?>','REPORTE DE COMPRAS');" title="IMPRIMIR" class="btn btn-outline-danger">
							<i class="far fa-file-pdf"></i>
					 	</button>

								<?php
										if($result_compras_row['estatus'] != 2){
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_compras_row['idcompras']."','idcompras','compras','n','compras/compras/vi_compras.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
										}
											?>
                   
                    </td> 
				</tr>
            <?php 
			   }
			   while($result_compras_row = $db->fetch_assoc($result_compras));
			}
			?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
}
catch (Exception $e)
{
	echo "Error:".$e ;
}

?>