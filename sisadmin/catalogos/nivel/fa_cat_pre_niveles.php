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

$cd->db = $db;

	$result_categorias = $cd->todasCategoriasPrecio();
   $result_categorias_row = $db->fetch_assoc($result_categorias);
   
   $result_niveles = $cd->todosNiveles();
   $result_niveles_row = $db->fetch_assoc($result_niveles);
   
   
   if(isset($_GET['idcategoria_precio']) && isset($_GET['idniveles'])){
   $idcategoria_precio = $_GET['idcategoria_precio'];
   $idniveles = $_GET['idniveles'];
   
   $cd->idniveles = $idniveles;
   $cd->idcategoria_precio = $idcategoria_precio;
   
   


	$result = $cd->buscarCategoriaPrecioNiveles();
	$result_row = $db->fetch_assoc($result);
	   
	  $categoria=$f->imprimir_cadena_utf8($result_row['idcategoria_precio']);
	  $nivel=$f->imprimir_cadena_utf8($result_row['idniveles']);
	  $descuento =$f->imprimir_cadena_utf8($result_row['descuento']);
	   
	  $tipo=5;
}
else{
		 $idcategoria_precio = "";
   $idniveles = "";
	$tipo=4;
	$categoria="";
	$nivel="";
	$descuento="";
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
	$('#titulo-modal-forms').html("ALTA DE CATEGORIA");
</script>

<form id="cat_nivel" method="post" action="">
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<!--<h5 class="card-title m-b-0"></h5>-->

			<div class="form-group m-t-20">
				<label>Categoria:</label>
				<select id="categoria" name="categoria" class="form-control">
					<?php
					do
					{ 
						if($result_categorias_row['estatus'] != 0){
					?>
					<option value="<?php echo $result_categorias_row['idcategoria_precio'] ?>" <?php if($categoria == $result_categorias_row['idcategoria_precio']){ echo "selected";} ?> ><?php echo $f->imprimir_cadena_utf8($result_categorias_row['nombre']); ?></option>
					<?php
						}
					}while($result_categorias_row = $db->fetch_assoc($result_categorias));
					?>
				</select>
			</div>

			<div class="form-group m-t-20">
				<label>Nivel:</label>
				<select id="nivel" name="nivel" class="form-control">
					<?php
					do
					{ 
						if($result_niveles_row['estatus'] != 0){
					?>
					<option value="<?php echo $result_niveles_row['idniveles'] ;?>" <?php if($nivel == $result_niveles_row['idniveles']){ echo "selected";} ?> ><?php echo $f->imprimir_cadena_utf8($result_niveles_row['nombre']); ?></option>
					<?php
						}
					}while($result_niveles_row = $db->fetch_assoc($result_niveles));
					?>
				</select>
			</div>
			
			
			
			<div class="form-group m-t-20">
				 <label>Porc. Descuento:</label>
				<div class="input-group">
					
    			<select id="descuento" name="descuento" class="form-control" >
					<?php
						for($x=0;$x<=100;$x++){
							/*if($x<10){
								$x = "0".$x;
							}*/
					?>
					<option value="<?php echo $x; ?>" <?php if($descuento == $x){ echo "selected";} ?> ><?php echo $x; ?></option>
					<?php
						}
					?>
				</select>
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">%</span>
				</div>
  			</div>
			
		</div>
	</div>
		
	<div class=" ">
		<div class="card-body" style="padding: 0;">
			<input type="hidden" name="idniveles" id="idniveles" value="<?php echo $idniveles; ?>" />
            <input type="hidden" name="idcategoria_precio" id="idcategoria_precio" value="<?php echo $idcategoria_precio; ?>" />
			
			
			<?php
												//SCRIPT PARA CONSTRUIR UN BOTON
												$bt->titulo = "GUARDAR";
												$bt->data_toggle='';
												$bt->data_target='';
												$bt->icon = 'far fa-save';
												$bt->funcion = "GuardarEspecial2('cat_nivel','catalogos/nivel/ga_cat_pre_niveles.php','catalogos/nivel/vi_categorias_precios.php?idmenumodulo=$idmenu','main');";
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
												$bt->funcion = "BorrarDatosCategoriaPreciosNiveles('".$idcategoria_precio."','".$idniveles."','idniveles','niveles','n','catalogos/nivel/vi_categorias_precios.php','main',".$idmenu.")";
												$bt->estilos = "float: right; margin-right: 10px;";
												$bt->permiso = $permisos;
												$bt->tipo = 3;
											if($idcategoria_precio!="" && $idniveles!=""){
												$bt->armar_boton();
											}
											?>
		</div>
	</div>
</form>
	
	<script type="text/javascript"	src="js/validaciones/cat_nivel.js"></script>