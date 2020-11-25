<?php
     require_once("../clases/class.Sesion.php");
   

     $se = new Sesion();
	
	 
	 $cadena = $_SESSION['vs_totalproductos']."|".$_SESSION['vs_montodescuento']."|".$_SESSION['vs_descuento']."|".$_SESSION['vs_totalcondescuento']; 
	 
	 echo  $cadena;
	 
?>