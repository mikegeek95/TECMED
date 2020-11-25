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
require_once("../../clases/class.Usuarios.php");
require_once("../../clases/class.Funciones.php");

$db = new MySQL();
$us = new Usuarios();
$fu = new Funciones();

$us->db=$db;

$queryPerfil="SELECT idperfiles, perfil FROM perfiles WHERE estatus=1";
$resp= $db->consulta($queryPerfil);
$rows= $db->fetch_assoc($resp);
$total=$db->num_rows($resp);


$querySucursal="SELECT * FROM sucursales WHERE estatus=1";
$sucursal= $db->consulta($querySucursal);
$sucursal_rows= $db->fetch_assoc($sucursal);
$sucursal_num=$db->num_rows($sucursal);


$sololectura = 0;
$datos = null;

if(isset($_GET['id']))
{
	 
	$queryPerfil="SELECT idperfiles, perfil FROM perfiles WHERE estatus=1";
	$resp= $db->consulta($queryPerfil);
	$rows= $db->fetch_assoc($resp);
	$total=$db->num_rows($resp);
	
	$us->id_usuario=$_GET['id'];	
	$idusuario = $_GET['id'];
	$datos = $us->ObtenerDatosUsuario();

	$sololectura = 1;
	$titulo=$fu->imprimir_cadena_utf8("MODIFICACIÓN DE USUARIO");
	$perfil=$fu->imprimir_cadena_utf8($datos['idperfiles']);
	$nombre=$fu->imprimir_cadena_utf8($datos['nombre']);
	$paterno=$fu->imprimir_cadena_utf8($datos['paterno']);
	$materno=$fu->imprimir_cadena_utf8($datos['materno']);
	$celular=$fu->imprimir_cadena_utf8($datos['celular']);
	$telefono=$fu->imprimir_cadena_utf8($datos['telefono']);
	$email=$fu->imprimir_cadena_utf8($datos['email']);
	$usuario=$fu->imprimir_cadena_utf8($datos['usuario']);
	$t_usuario=$fu->imprimir_cadena_utf8($datos['tipo_usuario']);
	$clave=$fu->imprimir_cadena_utf8($datos['clave']);
	$sucursal=$fu->imprimir_cadena_utf8($datos['idsucursales']);
	
	$estatus = $fu->imprimir_cadena_utf8($datos['estatus']);
}else{
	$titulo=$fu->imprimir_cadena_utf8("ALTA DE USUARIO");
	$perfil="";
	$nombre="";
	$paterno="";
	$materno="";
	$celular="";
	$telefono="";
	$email="";
	$usuario="";
	$t_usuario="";
	$sucursal="";
	$clave="";
	$estatus="";
}

?>
	<form id="usuarios" action="javascript:void(0)">
	<div class="card">
		<div class="card-header">
			<h5 class="font-weight-bold text-primary m-b-0" style="float: left;"><?php echo ($titulo);?></h5>
			<button type="button" onClick="aparecermodulos('administrador/usuarios/vi_usuarios.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;"><i class="fas fa-undo"></i> VER USUARIOS</button>
			<div style="clear: both;"></div>
		</div>
		
		<div class="card-body">
			<div class="col-12">
				<div class="row">
				
					<div class=" col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group m-t-20">
				<label>PERFIL:</label>
				<select id="idperfiles" name="idperfiles" class="form-control">
					<?php if($total!=0){ do{?>
					<option value="<?php echo $rows['idperfiles'];?>" <?php if($perfil == $rows['idperfiles']){ echo "selected"; } ?> ><?php echo $fu->imprimir_cadena_utf8($rows['perfil']);?></option>
					<?php }while($rows= $db->fetch_assoc($resp)); }
					else{
						?>
						<option value=""  >No Hay Perfiles Registrados</option>
					<?php
					}
					?>
				</select>
			</div>

			<div class="form-group m-t-20">
				<label>NOMBRE :</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre" value="<?php echo $nombre; ?>"  />
			</div>

			<div class="form-group m-t-20">
				<label>APELLIDO PATERNO:</label>
				<input type="text" name="paterno" id="paterno" class="form-control" title="Apellido Paterno" value="<?php echo $paterno; ?>"  />
			</div>

			<div class="form-group m-t-20">
				<label>APELLIDO MATERNO:</label>
				<input type="text" name="materno" id="materno" class="form-control" title="Apellido Materno" value="<?php echo $materno; ?>" />
			</div>

			<div class="form-group m-t-20">
				<label>CELULAR:</label>
				 <input type="text" name="celular" id="celular" class="form-control" title="Celular" value="<?php echo $celular; ?>"  />
			</div>

			<div class="form-group m-t-20">
				<label>TEL&Eacute;FONO:</label>
				<input type="text" name="telefono" id="telefono" class="form-control" title="Tel&eacute;fono" value="<?php echo $telefono; ?>" />
			</div>
			</div>
			<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
			<div class="form-group m-t-20">
				<label>EMAIL:</label>
				<input type="text" name="email" id="email" class="form-control" title="Email" value="<?php echo $email; ?>"  />
			</div>
				
			<div class="form-group m-t-20">
				<label>USUARIO:</label>
				<input onKeyPress="bloquear_enie (event.Keycode)" type="text" onBlur="var resp=MM_validateForm('usuario','','R'); if(resp==1){validarUsuario();}" name="usuario" id="usuario" class="form-control" title="Usuario"  value="<?php echo $usuario; ?>" />
				<span style="float:left; font-size: 10px;" id="msj_error">&nbsp;</span>
				<div id="mensajes" class="width_3_quarter"></div>
            	<input type="hidden" name="user_valid" id="user_valid" value="no"  title="Usuario Válido"/>
			</div>
			
			<div class="form-group m-t-20">
				<label>CLAVE:</label>
				<input type="password" name="clave" id="clave" class="form-control" title="Clave" value="<?php echo $clave; ?>"  />
			</div>
			
			<div class="form-group m-t-20">
				<label>SUCURSAL:</label>
				<select id="idsucursal" name="idsucursal" class="form-control">
					<?php if($sucursal_num!=0){ do{?>
					<option value="<?php echo $sucursal_rows['idsucursales'];?>" <?php if($sucursal == $sucursal_rows['idsucursales']){ echo "selected"; } ?> ><?php echo $fu->imprimir_cadena_utf8($sucursal_rows['sucursal']);?></option>
					<?php }while($sucursal_rows= $db->fetch_assoc($sucursal)); }
					else{
						?>
						<option value=""  >No Hay Sucursales Activas o Registradas</option>
					<?php
					}
					?>
				</select>
			</div>	
				
			<div class="form-group m-t-20">
				<label>ESTATUS:</label>
				<select id="estatus" name="estatus"  class="form-control">
					<option value="0" <?php if($estatus==0){echo 'selected="selected"';}?>>DESACTIVADO</option>
					<option value="1" <?php if($estatus==1){echo 'selected="selected"';}?>>ACTIVO</option>
				</select>
			</div>
			
			
			
			<div class="form-group m-t-20">
				<label>TIPO DE USUARIO:</label>
				<select id="tipo_usuario" name="tipo_usuario"  class="form-control">
					<option value="0" <?php if($t_usuario==0){echo 'selected="selected"';}?>>INTERNO</option>
					<option value="1" <?php if($t_usuario==1){echo 'selected="selected"';}?>>EXTERNO</option>
				</select>
			</div>
				</div>
			</div>	
		</div>
			</div>
	
	
<div class="card-footer">
			<input type="hidden" id="v_id" name="v_id" value="<?php echo $idusuario; ?>" />
			<button type="button" id="alt_btn" onClick=" GuardarEspecial('usuarios','administrador/usuarios/ga_usuarios.php','administrador/usuarios/vi_usuarios.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success" style="float: right;"><i class="far fa-save"></i> GUARDAR</button>
	<br><br>
		</div>
</div>	
</form>
<script type="text/javascript"	src="js/validaciones/usuarios.js"></script><!-- Valida los campos de login(vacios, caracteres, tamaño de cadena, etc) -->	

