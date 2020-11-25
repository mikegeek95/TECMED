<?php
    require_once("../clases/class.Devoluciones.php");
	require_once("../clases/conexcion.php");

	$db = new MySQL();	
		
	try
	{
	$carrito = new Devoluciones();
	
	
	$carrito->db = $db;
	$carrito->idproducto = $_POST['v_idproducto'];	
	$carrito->delProductoDevolucion($cod);	
	$carrito->VerDevoluciones('1|producto eliminado');
	
	} catch(Exception $e) 
	    {
		  $db->rollback();	
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo "Se hizo rollback ". $db->m_error($n[0]);   
		 }
	
?>