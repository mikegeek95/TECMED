<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Al incluir este header nos olvidamos de colocar el utf8_encode para visualizar caracteres especiales á ñ etc.
header("Content-Type: text/text; charset=ISO-8859-1");
    
//Importamos las clases que vamos a utilizar
require_once("../clases/conexcion.php");	 
require_once("../clases/class.Sobrepedidos.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Tallas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$sp = new Sobrepedidos();
$fe = new Fechas();
$ta = new Tallas();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$sp->db = $db;
$ta->db = $db;

//Recibimos parametros enviados por GET
$idsobrepedido = $_GET['id'];

//Declaramos variables a utilizar
$estatus  = array('Pendiente','Generado','Cancelado');
$ruta = "../../appphp/fotos_anticipos/";

//Realizamos consultas
$sp->idsobrepedido = $idsobrepedido;

//Obtenemos los anticipos del sobrepedido
$result_anticipos = $sp->obtener_img_anticipos();
$result_anticipos_num = $db->num_rows($result_anticipos);
$result_anticipos_row = $db->fetch_assoc($result_anticipos);

?>

<script type="text/javascript">
	$('#titulo-visor').html("ANTICIPOS DE SOBRE PEDIDO # <?php echo $idsobrepedido; ?>");
</script>


<div class="row el-element-overlay">
	<?php
	if($result_anticipos_num != 0){
		do
		{
	?>
	<div class="col-lg-3 col-md-6">
		<div class="card">
			<div class="el-card-item">
				<div class="el-card-avatar el-overlay-1"> 
					<img src="<?php echo $ruta.$result_anticipos_row['imagen']; ?>" alt="user">
					<div class="el-overlay">
						<ul class="list-style-none el-info">
							<li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link verfoto" href="<?php echo $ruta.$result_anticipos_row['imagen']; ?>"><i class="mdi mdi-magnify-plus"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		}while($result_anticipos_row = $db->fetch_assoc($result_anticipos));
	}else{
	?>
	<div style="color: #777; text-align: center; width: 100%; padding: 10px;">
		Lo sentimos, no se han podido encontrar anticipos de este sobre pedido.
	</div>
	<?php
	}
	?>
</div>


<script>
	$('.verfoto').magnificPopup({
	  type: 'image'
	  // other options
	});
</script>
