<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Clientes.php");
require_once("../../clases/class.Categoria_Descuento.php");
require_once("../../clases/class.Usuarios.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Funciones.php");


$db = new MySQL();
$cli = new Clientes();
$us = new Usuarios();
$fec = new Fechas();
$f = new Funciones();

$cli->db = $db;
$us->db = $db;

$cd = new categoria_descuento();

$cd->db = $db;


//obtenemos el id del usuario de su perfil para saber si puede modificar el nivel de un cliente
$idusuarios = $_SESSION['se_sas_Usuario'];
$us->id_usuario = $idusuarios;
$result_usuario = $us->ObtenerDatosUsuario();

$idperfiles = $result_usuario['idperfiles'];

//Validamos si el usuario puede modificar el nivel de un cliente solo el perfil 1 y 2 peuden modificar
if($idperfiles >= 3){
	$disabled = 'disabled';
}

//recibo el id del cliente
if(isset($_GET['id'])){
$cli->idCliente = $_GET['id'];

//obtenemos los valores del cliente
$result_clientes = $cli->ObtenerInformacionCliente();
	$titulo=$f->imprimir_cadena_utf8("MODIFICACI&Oacute;N DE PACIENTE");
	$idcliente=$f->imprimir_cadena_utf8($cli->idCliente);
	$nivel=$f->imprimir_cadena_utf8($result_clientes['idniveles']);
	$sexo=$f->imprimir_cadena_utf8($result_clientes['sexo']);
	$f_nacimiento=$f->imprimir_cadena_utf8($result_clientes['f_nacimiento']);
	$nombre=$f->imprimir_cadena_utf8($result_clientes['nombre']);
	$paterno=$f->imprimir_cadena_utf8($result_clientes['paterno']);
	$materno=$f->imprimir_cadena_utf8($result_clientes['materno']);
	$direccion=$f->imprimir_cadena_utf8($result_clientes['direccion']);
	$telefono=$f->imprimir_cadena_utf8($result_clientes['telefono']);
	$fax=$f->imprimir_cadena_utf8($result_clientes['fax']);
	
	$razonsocial=$f->imprimir_cadena_utf8($result_clientes['fis_razonsocial']);
	$rfc=$f->imprimir_cadena_utf8($result_clientes['fis_rfc']);
	$direccionfiscal=$f->imprimir_cadena_utf8($result_clientes['fis_direccion']);
	$f_no_int=$f->imprimir_cadena_utf8($result_clientes['fis_no_int']);
	$f_no_ext=$f->imprimir_cadena_utf8($result_clientes['fis_no_ext']);
	$fis_col=$f->imprimir_cadena_utf8($result_clientes['fis_col']);
	$fis_ciudad=$f->imprimir_cadena_utf8( $result_clientes['fis_ciudad']);
	$fis_estado=$f->imprimir_cadena_utf8($result_clientes['fis_estado']);
	$fis_cp=$f->imprimir_cadena_utf8($result_clientes['fis_CP']);
	

	$email=$f->imprimir_cadena_utf8($result_clientes['email']);
	
	$estatus=$f->imprimir_cadena_utf8($result_clientes['estatus']);
	

	
	$disabled="disabled";
}else{
	$titulo=$f->imprimir_cadena_utf8("ALTA DE PACIENTE");
	$idcliente=0;
	$nivel="";
	$sexo="";
	$f_nacimiento="";
	$nombre="";
	$paterno="";
	$materno="";
	$direccion="";
	$telefono="";
	$fax="";
	
	$razonsocial="";
	$rfc="";
	$direccionfiscal="";
	$f_no_int="";
	$f_no_ext="";
	$fis_col="";
	$fis_ciudad="";
	$fis_estado="";
	$fis_cp="";
	
	
	$email="";
	
	$estatus="";
	

	
	$disabled="";
}



	$result_niveles = $cd->todosNiveles();
	$result_niveles_row = $db->fetch_assoc($result_niveles);

?>

<script type="text/javascript">
	$('#titulo-modal-forms').html("<?php echo ($titulo); ?>");
</script>

<form name="form_paciente" id="form_paciente">
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Datos Generales</span></a> </li>
				<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Datos Fiscales</span></a> </li>
				
				
			</ul>
			<!-- Tab panes -->

			<div class="tab-content " style=" padding-top: 0px; margin-left: 10px; margin-right: 10px; margin-top: 10px;">

				<div class="tab-pane active p-20" id="home" role="tabpanel">
					<div class="form-group m-t-20">
						<label>NIVEL:</label>
						<select name="v_nivel" id="v_nivel" title="Nivel" class="form-control" <?php echo $disabled; ?> >
						   <?PHP 
							  do
							  {
							?>
								<option value="<?php echo $result_niveles_row['idniveles'] ?>" <?php if($nivel == $result_niveles_row['idniveles']){ echo "selected";} ?> ><?php echo utf8_encode($result_niveles_row['nombre']);?></option>
							<?php
								}while($result_niveles_row = $db->fetch_assoc($result_niveles));
						   ?>
						</select>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>SEXO:</label>
								<select name="v_sexo" id="v_sexo" title="sexo" class="form-control">
									<option value="H" <?php if ($sexo == "H")echo "selected";?> selected="selected">HOMBRE</option>
									<option value="M" <?php if($sexo == "M") echo "selected";?> >MUJER</option>
								</select>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>FECHA DE NACIMIENTO:</label>
								<!--<input name="v_f_nacimiento" type="text" id="v_f_nacimiento" value="" placeholder="06/11/2012" class="form-control">-->
								
								<div class="input-group">
									<input type="text" class="form-control" name="v_f_nacimiento" id="v_f_nacimiento" value="<?php echo $f_nacimiento; ?>" placeholder="yyyy-mm-dd">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
										</div>
								</div>
								
							</div>
							
							
						</div>
					</div>


					

					<div class="form-group m-t-20">
						<label>NOMBRE:</label>
						<input name="v_nombre" id="v_nombre" title="Tu Nombre" type="text" class="form-control" value="<?php echo $nombre;?>"   required>
					</div>
					
					<div class="form-group m-t-20">
						<label>PATERNO:</label>
						<input name="v_paterno" id="v_paterno" title="Apellito Paterno" type="text" value="<?php echo $paterno; ?>" class="form-control"   required>
					</div>
					
					<div class="form-group m-t-20">
						<label>MATERNO:</label>
						<input name="v_materno" id="v_materno" title="Apellido Materno" type="text" value="<?php echo $materno;?>" class="form-control"  required>
					</div>					
					
					<div class="form-group m-t-20">
						<label>DIRECCI&Oacute;N:</label>
						<textarea name="v_direccion" rows="5" required id="v_direccion" class="form-control" title="Dirección"><?php echo $direccion;?></textarea>
					</div>
					
					<div class="form-group m-t-20">
						<label>TEL&Eacute;FONO:</label>
						<input name="v_telefono" id="v_telefono" title="Telefono" type="text" value="<?php echo $telefono; ?>" class="form-control"   required>
					</div>
					
					<div class="form-group m-t-20">
						<label>FAX:</label>
						<input name="v_fax" id="v_fax" title="FAX" type="text" value="<?php echo $fax; ?>" class="form-control"   required>
					</div>
					<div class="form-group m-t-20">
						<label>EMAIL:</label>
						<input name="v_email" id="v_email" title="Email" onBlur="validarEmailCliente('<?php echo $email; ?>');" type="text" value="<?php echo $email; ?>" class="form-control"   required>
						<span id="msj_error"></span>
					</div>
					
					
					
					<div class="form-group m-t-20">
						<label>ESTATUS:</label>
						<select name="v_estatus" id="v_estatus" title="Estatus" class="form-control">
							<option value="0" <?php if ($estatus==0)echo "selected";?> >NO ACTIVO</option>
							<option value="1" <?php if($estatus==1) echo "selected";?> selected="selected">ACTIVO</option>
						</select>
					</div>
				</div>


				<div class="tab-pane  p-20" id="profile" role="tabpanel">
					<div class="form-group m-t-20">
						<label>RAZON SOCIAL:</label>
						<input name="v_fis_razonsocial" id="v_fis_razonsocial" title="Razon Social" value="<?php echo $razonsocial; ?>" type="text" class="form-control"   required>
					</div>

					<div class="form-group m-t-20">
						<label>RFC:</label>
						<input name="v_fis_rfc" id="v_fis_rfc" title="RFC" type="text" value="<?php echo $rfc; ?>" class="form-control"   required>
					</div>

					<div class="form-group m-t-20">
						<label>DIRECCI&Oacute;N FISCAL:</label>
						<textarea name="v_fis_direccion" required id="v_fis_direccion" class="form-control"  title="Direccion Fiscal"><?php echo $direccionfiscal;?></textarea>
					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>NO. INTERIOR:</label>
								<input name="v_fis_no_int" id="v_fis_no_int" title="Numero Interior Fiscal" type="text" value="<?php echo $f_no_int; ?>" class="form-control"   required>
							</div>	
						</div>

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>NO. EXTERIOR:</label>
								<input name="v_fis_no_ext" id="v_fis_no_ext" title="No. Ext. Fiscal" type="text" class="form-control" value="<?php echo $f_no_ext; ?>"   required>
							</div>
						</div>
					</div>

					<div class="form-group m-t-20">
						<label>COLONIA FISCAL:</label>
						<input name="v_fis_col" id="v_fis_col" title="Colonia Fiscal" type="text" class="form-control" value="<?php echo $fis_col; ?>"  required >
					</div>	

					<div class="form-group m-t-20">
						<label>CIUDAD FISCAL:</label>
						<input name="v_fis_ciudad" id="v_fis_ciudad" title="Ciudad Fiscal" type="text" value="<?php echo $fis_ciudad;?>" class="form-control"   required>
					</div>

					<div class="form-group m-t-20">
						<label>ESTADO FISCAL:</label>
						<input name="v_fis_estado" id="v_fis_estado" title="El estado de tu direccion Fiscal" value="<?php echo $fis_estado; ?>" type="text" class="form-control"   required>
					</div>	

					<div class="form-group m-t-20">
						<label>CP FISCAL:</label>
						<input name="v_fis_cp" id="v_fis_cp" title="El CP de tu direccion Fiscal" value="<?php echo $fis_cp; ?>" type="text" class="form-control"   required>
					</div>
				</div>



				
				

			</div>


			<div style="width: 100%;">
				<input name="id" id="id" type="hidden" value="<?php echo $idcliente; ?>" />
				<button type="button" onClick="GuardarEspecialClientes('form_paciente','catalogos/pacientes/ga_pacientes.php','catalogos/pacientes/vi_pacientes.php?idmenumodulo=<?php echo ($idmenu);?>','main')" class="btn btn-outline-success alt_btn3" style="float: right; margin-top: 10px;"> <i class="far fa-save"></i> GUARDAR</button>
			</div>

		</div>
	</div>
</form>



<script>
	jQuery('#v_f_nacimiento').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
</script>

<script type="text/javascript"	src="js/validaciones/paciente.js"></script>