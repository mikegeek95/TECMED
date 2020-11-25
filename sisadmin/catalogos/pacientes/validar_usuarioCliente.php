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



$dc = new MySQL();

$clientes = new Clientes();



$clientes->db= $db;

try

{

$clientes->usuario = $_POST['usuario'];



$result = $clientes->validarUsuarioCliente();



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