<?php
//header("Content-Type: text/text; charset=ISO-8859-1");

require_once("../../clases/class.Sesion.php");

//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Funciones.php");



$db = new MySQL();
$f = new Funciones();

$subcategoria=$_POST['subcategoria'];

$sql="select * FROM subcategoria where idcategoria='".$_POST['categoria']."'";

$result_tallas = $db->consulta($sql);

$result_tallas_num = $db->num_rows($result_tallas);
$result_tallas_row = $db->fetch_assoc($result_tallas);


?>


					<label>SUBCATEGORIA:</label>
					<select name="subcategoria" id="subcategoria" class="form-control">
						
						<?php
						if($result_tallas_num==0){
							?><option value="">NO HAY REGISTROS PARA ESTA CATEGORIA</option><?php
						}
						else{
						
						do
						{
						?>
						<option value="<?php echo $result_tallas_row['idsubcategoria']; ?>" <?php if($subcategoria==$result_tallas_row['idsubcategoria']){ echo ("selected");}?>><?php echo $f->imprimir_cadena_utf8($result_tallas_row['nombre']); ?></option>
						<?php
						}while($result_tallas_row = $db->fetch_assoc($result_tallas));}
						
						?>
					</select>