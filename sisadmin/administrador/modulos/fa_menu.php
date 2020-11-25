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
require_once("../../clases/class.ModulosMenu.php");
require_once("../../clases/class.Funciones.php");

try
{
	$db = new MySQL();
	$mm = new ModulosMenu();
	$fu = new Funciones();
	
	$mm->db=$db;
	
	if(isset($_GET['id'])){
	$id=$_GET['id'];
	$mm->idmenu=$id;	
	$datos=$mm->ObtenerInfoMenu();
		$titulo=$fu->imprimir_cadena_utf8("MODIFICACIÓN DE MENÚ");
		$modulo=$datos['idmodulos'];
		$menu=$fu->imprimir_cadena_utf8($datos['menu']);
		$archivo=$fu->imprimir_cadena_utf8($datos['archivo']);
		$ubicacion=$fu->imprimir_cadena_utf8($datos['ubicacion_archivo']);
		$nivel=$fu->imprimir_cadena_utf8($datos['nivel']);
		$estatus=$datos['estatus'];
		$icono= $fu->imprimir_cadena_utf8($datos['icono']);
		$tipo=4;
	}else{
		$titulo=$fu->imprimir_cadena_utf8("ALTA DE MENÚ");
		$id=0;
		$modulo="";
		$menu="";
		$archivo="";
		$ubicacion="";
		$nivel="";
		$estatus="";
		$icono="";
		$tipo=3;
	}
	
	$query="SELECT * FROM modulos WHERE estatus=1";
	$resp=$db->consulta($query);
	$row=$db->fetch_assoc($resp);
	$total=$db->num_rows($resp);
	
	$disabled='';
?>

<form id="alta_menu" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left;"><?php echo ($titulo);?></h5>

			<div style="padding: 20px;">
				<button type="button" onClick="aparecermodulos('administrador/modulos/vi_modulos.php?idmenumodulo=<?php echo $idmenu; ?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i> Ver Modulos</button>
				<div style="clear: both;"></div>
			</div>
		</div>
		<div class="card-body row ">
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
<?php
        	if($total==0)
			{
				$disabled='disabled="disabled"';
?>
        		<label>No existen modulos disponibles, por lo que no es posible crear menus</label>
<?php
			}else{
?>
        		<label>Modulo</label>
				<select name="idmodulos" id="idmodulos" class="form-control">
					<?php do{?>
					<option value="<?php echo $row['idmodulos'];?>" <?php if($modulo==$row['idmodulos']){echo 'selected="selected"';}?> ><?php echo $fu->imprimir_cadena_utf8($row['modulo']); ?></option>   
					<?php }while($row=$db->fetch_assoc($resp));?>         
				</select>
<?php
			}
?>
			</div>
			

			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Nombre del Menu:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre"  value="<?php echo $menu; ?>" />
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Nombre del Archivo:</label>
				<input type="text" name="archivo" id="archivo" class="form-control" title="Archivo"  value="<?php echo $archivo; ?>" />
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Ubicacion del Archivo:</label>
				<input type="text" name="ubi" id="ubi" class="form-control" title="Ubicaci&oacute;n del Archivo" value="<?php echo $ubicacion; ?>" />
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Nivel en el Orden:</label>
				<input type="text" name="nivel" id="nivel" class="form-control" title="Nivel de Orden"  value="<?php echo $nivel; ?>" />
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="1" <?php if($estatus==1){echo 'selected="selected"';}?> >Activo</option>
					<option value="0" <?php if($estatus==0){echo 'selected="selected"';}?> >Inactivo</option>
				</select>
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>&Iacute;cono:</label>
				<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"><div id="mostraricono" class ="col-4"><i class="<?php echo $icono; ?>"></i></div></span>
			  </div>
				<input type="text" name="icono" id="icono" class="form-control" title="Icono" onchange="actualizaricono();" placeholder="fas fa-bars" value="<?php echo $icono; ?>" />
				
			</div>
				</div>
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<label>* Para asignar un &iacute;cono a tu men&uacute; <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank"> click aqui </a> </label><br>
				<label>* Asegurece de usar los &iacute;conos gratuitos, estos se pueden diferenciar por su tono oscuro </label><br>
				<label>* Al seleccionar un icono, este se mostrara de forma individual, en la parte superior encontrara la siguiente referencia:  <?php echo ('<-i class="fas fa-bars" ></-i>');?> </label><br>
				<label>* Asegurece solo de copiar el texto dentro de las comillas class: class"este texto" </label><br>
				<label>* Al introducir el c&oacute;digo podra ver cambiar el icono de la izquierda;</label><br>
			</div>
		</div>
		
		
		<div class="card-footer">
			<input type="hidden" name="tipo" id="tipo" value="<?php echo ($tipo);?>" />
    		<input type="hidden" name="idmodulos_menu" id="idmodulos_menu" value="<?php echo $id;?>" />
			<button type="button" onClick="GuardarEspecial('alta_menu','administrador/modulos/ga_modulosMenu.php','administrador/modulos/vi_modulos.php?idmenumodulo=<?php echo $idmenu; ?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" > <i class="far fa-save"></i> Guardar</button>
		</div>
		</div>
	</div>
</form>

<?php
}
catch(Exception $e)
{
	echo $e;
}

?>
<script type="text/javascript" charset="utf-8">
 function actualizaricono(){
	
	var icono = $("#icono").val();
	
	$("#mostraricono").html("<i class='"+icono+"' > </i>")
	
}
</script>

<script type="text/javascript"	src="js/validaciones/menu.js"></script>