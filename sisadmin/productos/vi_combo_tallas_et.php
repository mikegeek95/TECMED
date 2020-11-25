<?php
//header("Content-Type: text/text; charset=ISO-8859-1");

require_once("../clases/class.Sesion.php");

//creamos nuestra sesion.
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Sucursales.php");
require_once("../clases/class.ShoppingCar.php");
require_once("../clases/class.Tallas.php");


$db = new MySQL();
$carrito = new ShoppingCar();
$suc = new Sucursales();
$ta = new Tallas();

$suc->db = $db;
$ta->db = $db;

$sql="select t.* from tallas t, productos p where t.unidad = p.unidad and p.idproducto='".$_POST['producto']."'";

$result_tallas = $db->consulta($sql);

$result_tallas_num = $db->num_rows($result_tallas);
$result_tallas_row = $db->fetch_assoc($result_tallas);


?>


					
					<div class="row">
						<div class="col-6">
							<label>Unidad:</label>
					<input type="text" name="v_talla" id="v_talla" title="Cantidad del Producto"  placeholder="Unidad" value="<?php echo $result_tallas_row['unidad']; ?>" class="form-control" disabled/>
							<br></div>
							<div class="col-6 ">
								<label>Tallas:</label>
					<select name="talla" id="talla" class="form-control">
						
						<?php
						if($result_tallas_num==0){
							?><option value="">INGRESA UN PRODUCTO</option><?php
						}
						else{
						
						do
						{
						?>
						<option value="<?php echo $result_tallas_row['idtallas']; ?>"><?php echo utf8_encode($result_tallas_row['valor']." ".$result_tallas_row['unidad']); ?></option>
						<?php
						}while($result_tallas_row = $db->fetch_assoc($result_tallas));}
						
						?>
					</select>
								</div>
						</div>