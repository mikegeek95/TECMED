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
   require_once("../../clases/class.Categoria_Descuento.php");
   require_once("../../clases/class.Funciones.php");
   require_once("../../clases/class.Botones.php");
   
   $db = new MySQL();
   $cd = new categoria_descuento();
   $f= new Funciones();
   $bt = new Botones_permisos();



  if(isset($_GET['id'])){
   $id = $_GET['id'];
   
   $cd->db = $db;
   $cd->idniveles = $id;
   
   $result_categorias = $cd->buscarNivel();
   $result_categorias_row = $db->fetch_assoc($result_categorias);
   $result_categorias_num = $db->num_rows($result_categorias);
   
   $titulo=$f->imprimir_cadena_utf8("MODIFICACIÓN DE NIVEL");
   $nombre = $f->imprimir_cadena_utf8($result_categorias_row['nombre']);
   $estatus=$f->imprimir_cadena_utf8($result_categorias_row['estatus']);
   $tipo=5;
  }
else{
	$titulo=$f->imprimir_cadena_utf8("ALTA DE NIVEL");
	$id=0;
	$nombre = "";
	$estatus="";
	$tipo=4;
}


//*================== COEMINZA RECIBIMOS PARAMETRO DE PERMISOS =======================*/
if(isset($_SESSION['permisos_acciones_aexa'])){
						//Nombre de sesion | pag-idmodulos_menu
	$permisos = $_SESSION['permisos_acciones_aexa']['pag-'.$idmenu];	
}else{
	$permisos = '';
}
//*================== TERMINA RECIBIMOS PARAMETRO DE PERMISOS =======================*/


?>

<script type="text/javascript">
	$('#titulo-modal-forms').html("<?php echo ($titulo);?>");
</script>

<form id="nivel_descuento" method="post" action="">
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<!--<h5 class="card-title m-b-0"></h5>-->

			<div class="form-group m-t-20">
				<label>Nombre del Nivel:</label>
				<input type="text" name="nivel" id="nivel" class="form-control" title="Campo Nombre del Nivel"  value="<?php echo $nombre; ?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="1" <?php if($estatus==1){echo "selected" ;}?>>ACTIVADO</option>
					<option value="0" <?php if($estatus==0){echo "selected" ;}?>>DESACTIVADO</option>
				</select>
			</div>
		</div>
	</div>
		
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
			
			
			<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "GUARDAR";
												$bt->data_toggle='';
												$bt->data_target='';
												$bt->icon = 'far fa-save';
												$bt->funcion = "GuardarEspecial2('nivel_descuento','catalogos/nivel/ga_niveles.php','catalogos/nivel/vi_categorias_precios.php?idmenumodulo=$idmenu','main');";
												$bt->estilos = "float: right; margin-right: 10px;";
												$bt->permiso = $permisos;
												$bt->tipo = $tipo;
											
												$bt->armar_boton();
											
											?>
			
			
			<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "ELIMINAR";
												$bt->data_toggle='';
												$bt->data_target='';
												$bt->icon = 'fas fa-trash';
												$bt->funcion = "BorrarDatos2('".$id."','idniveles','niveles','n','catalogos/nivel/vi_categorias_precios.php','main',".$idmenu.")";
												$bt->estilos = "float: right; margin-right: 10px;";
												$bt->permiso = $permisos;
												$bt->tipo = 3;
											if($id!=0){
												$bt->armar_boton();
											}
											?>
		</div>
	</div>
</form>

<script type="text/javascript"	src="js/validaciones/nivel_descuento.js"></script>