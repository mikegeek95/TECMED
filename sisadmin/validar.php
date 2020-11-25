<?php
if(!isset($_SESSION)) 
{
  session_start();
}

require_once("clases/class.Login.php");
$lo = new Login();

$lo->usuario = $_POST['usuario'];
$lo->contrasena = $_POST['contrasena'];
$lo->tabla = "usuarios";

$quepaso = $lo->ValidandoDatos();
echo $quepaso;

?>