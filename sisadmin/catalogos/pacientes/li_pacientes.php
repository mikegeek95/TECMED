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
	 
	 $db = new MySQL();
$f = new Funciones();
$bt = new Botones_permisos();

$estatus=$f->guardar_cadena_utf8($_POST['v_estatus']);
$sexo=$f->guardar_cadena_utf8($_POST['v_sexo']);
$nombre=$f->guardar_cadena_utf8($_POST['v_nombre']);
$paterno=$f->guardar_cadena_utf8($_POST['v_paterno']);
$materno=$f->guardar_cadena_utf8($_POST['v_materno']);
$email=$f->guardar_cadena_utf8($_POST['v_email']);
//$idclientes=$f->guardar_cadena_utf8($_POST['idcliente']);
$idclientes="";
	 
	 $sql_cliente = "SELECT * FROM clientes where 1=1 ";
	 $sql_cliente .= ($estatus != '') ? " AND estatus = '$estatus'":" ";
	 $sql_cliente .= ($sexo != '') ? " AND sexo = '$sexo'":" ";
	 $sql_cliente .= ($nombre != '') ? " AND nombre like '%$nombre%'":" ";
	 $sql_cliente .= ($paterno != '') ? " AND paterno like '%$paterno%'":" ";
	 $sql_cliente .= ($materno != '') ? " AND materno like '%$materno%'":" ";
	 $sql_cliente .= ($email != '') ? " AND email like '%$email%'":" ";
 	 $sql_cliente .= ($idclientes != '') ? " AND idcliente = '$idclientes'":" ";



	 $result_cliente = $db->consulta($sql_cliente);
	 $result_row = $db->fetch_assoc($result_cliente);
	 $result_row_num = $db->num_rows($result_cliente);

//*================== INICIA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/

	
?>



                <table class="table table-bordered " id="zero_config" width="100%" cellspacing="0" style="text-align: center; ">
				<thead class="mb-4 py-3 px-3 py-5 bg-gradient-primary text-white" >
					<tr>
						<th width="20">ID CLIENTE</th> 
						<th>NOMBRE</th>
						<th>NIVEL</th>
						<th width="60">DIRECCI&Oacute;N</th>
						<th>TELEFONO</th>
						<th width="30">EMAIL</th>
						<th>ACCI&Oacute;N</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if( $result_row_num  != 0)
					{
						do
						{
							$idniveles = $result_row['idniveles'];

							$sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
							$result_nivel = $db->consulta($sql);
							$result_nivel_row = $db->fetch_assoc($result_nivel);
							$result_nivel_num = $db->num_rows($result_nivel);

							if($result_nivel_num == 0){
								$nivel = "0";
							}else{
								$nivel = $result_nivel_row['nombre'];
							}

							
					?>

						<tr> 
						  	<td width="20" style="text-align:center;"><?php echo $result_row['idcliente']; ?></td> 
						  	<td><?php echo $f->imprimir_cadena_utf8( $result_row['nombre']." ".$result_row['paterno']." ".$result_row['materno']); ?></td>
						  	<td><?php echo $nivel; ?></td>
							<td width="60"><?php echo $f->imprimir_cadena_utf8($result_row['direccion']); ?></td>
						  	<td><a href="tel://<?php echo $f->imprimir_cadena_utf8($result_row['telefono']); ?>"><?php echo $f->imprimir_cadena_utf8($result_row['telefono']); ?></a></td>
							<td width="30"><?php echo $f->imprimir_cadena_utf8($result_row['email']); ?></td>
						  	
						  	<td align="center">
								
								
								<?php
										//SCRIPT PARA CONSTRUIR UN BOTON
										$bt->titulo = "";
										$bt->data_toggle='data-toggle="modal"';
										$bt->data_target='data-target="#modal-forms"';
										$bt->icon = "far fa-edit";
										$bt->funcion = "AbrirModalGeneral2 ('ModalPrincipal','900','560','catalogos/pacientes/fa_pacientes.php?id=".$result_row['idcliente']."&idmenumodulo=$idmenu')";
										$bt->estilos = "";
										$bt->permiso = $permisos;
										$bt->tipo = 2;

										$bt->armar_boton();
									?>
							
								
								<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "";
												$bt->data_toggle='';
												$bt->data_target='';
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos('".$result_row['idcliente']."','idcliente','clientes','n','catalogos/pacientes/vi_pacientes.php','main',".$idmenu.")";
												$bt->estilos = "";
												$bt->permiso = $permisos;
												$bt->tipo = 3;

												$bt->armar_boton();
											?>
								
							</td> 
						</tr>
					<?php 
						}while($result_row = $db->fetch_assoc($result_cliente));

					}else{
					}
					?>
				</tbody>
			</table>

<script type="text/javascript" charset="utf-8">

	//$(document).ready(function() {

		var oTable = $('#zero_config').dataTable( {		

			  "oLanguage": {
							"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
							"sZeroRecords": "LO SENTIMOS, NO SE HAN ENCONTRADO REGISTROS.",
							"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
							"sInfoEmpty": "desde 0 a 0 de 0 records",
							"sInfoFiltered": "",
							"sSearch": "Buscar",
							"oPaginate": {
										 "sFirst":    "Inicio",
										 "sPrevious": "Anterior",
										 "sNext":     "Siguiente",
										 "sLast":     "&Uacute;ltimo"
										 }
							},
			   "sPaginationType": "full_numbers",
		} );
		//} );
</script>