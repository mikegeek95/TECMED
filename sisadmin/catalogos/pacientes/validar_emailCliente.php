<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");



$db = new MySQL();
$clientes = new Clientes();

$clientes->db = $db;

try
{

$clientes->selected = $_POST['selected'];
$clientes->email = $_POST['email'];

	if($clientes->selected != $clientes->email){
		$result = $clientes->validarEmailCliente();
	}else{
		$result = 0;
	}
	
echo $result;
}

catch(Exception $e)

{

	$v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;

}





?>