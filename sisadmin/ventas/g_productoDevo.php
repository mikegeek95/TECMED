<?php
    require_once("../clases/class.Devoluciones.php");
	require_once("../clases/conexcion.php");
	
	try
	{
		$db = new MySQL();
    	$de = new Devoluciones();
		
		//die("salimos");
		
		$de->db = $db;
		
		
		
			$de->idnotaremision = $_POST['idnotaremision'];
			$de->idproducto = trim($_POST['idproducto']);
			$de->idtallas = $_POST['idtallas'];
			//$de->desc = $_POST['desc'];
			$add = $de->AddDevolucion();
			
			$de->VerDevoluciones($add);	
			
			
	   
	
	} catch(Exception $e) 
	    {
		  $db->rollback();	
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo "Se hizo rollback ". $db->m_error($n[0]);   
		 }
		  
	



?>