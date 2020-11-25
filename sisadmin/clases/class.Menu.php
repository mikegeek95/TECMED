<?php
require_once("class.Funciones.php");
require_once("class.Sesion.php");
class Menu extends Funciones
{   
    public $db;///objeto de la base de datos
    public $idusuario;//id de usuario del cual se va a buscar el menu
	public $idperfil;//id de usuario del cual se va a buscar el menu
    public $idmenu;//id del menu para buscar sus submenus	
	
	private $sesion;
	
	
	function Menu()
	{
		$this->sesion = new Sesion();
	}
	
		
	//funcion para armar el menu principal	
	public function ArmarMenu()
	{
		$menu="";
		$query_modulos="SELECT modulo, idmodulos, estatus,icono FROM modulos WHERE estatus=1 ORDER BY nivel ";
		$result = $this->db->consulta($query_modulos);
	    $rows = $this->db->fetch_assoc($result);
		$total = $this->db->num_rows($result);
		
		if($total>0)
		{
			do
			{
				$query_menu="SELECT modulos_menu.menu,
				modulos_menu.idmodulos_menu,
		modulos_menu.archivo, 
		modulos_menu.icono, 
		modulos_menu.ubicacion_archivo, 
		modulos_menu.estatus,
		perfiles_permisos.insertar,
		perfiles_permisos.borrar,
		perfiles_permisos.modificar
	FROM perfiles_permisos INNER JOIN modulos_menu ON perfiles_permisos.idmodulos_menu = modulos_menu.idmodulos_menu
	WHERE modulos_menu.estatus=1 AND perfiles_permisos.idperfiles=$this->idperfil AND modulos_menu.idmodulos=".$rows['idmodulos']." ORDER BY nivel";
				$resp = $this->db->consulta($query_menu);
				$row = $this->db->fetch_assoc($resp);
				$totalRow = $this->db->num_rows($resp);  
				
				
				
        
          
            

          
						
				if($totalRow>0)
				{
					$menu.='<li class="nav-item"><a style="cursor: pointer;" class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsemenu'.$rows['idmodulos'].'" aria-expanded="true" aria-controls="collapsemenu'.$rows['idmodulos'].'"><i class="'.$rows['icono'].'"></i><span>'.$rows['modulo'].'</span></a>';
					$menu.='<div id="collapsemenu'.$rows['idmodulos'].'" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar"><div class="bg-white py-2 collapse-inner rounded"> <h6 class="collapse-header">'.$rows['modulo'].':</h6>';
					
					do
					{
						$permisos = $row['insertar']."|".$row['modificar']."|".$row['borrar'];
						
						
						if(!isset($_SESSION['permisos_acciones_aexa'])){
							$this->sesion->crearSesion("permisos_acciones_aexa",null);
							$_SESSION['permisos_acciones_aexa']['pag-'.$row['idmodulos_menu']] = $permisos;
						}else{
							$_SESSION['permisos_acciones_aexa']['pag-'.$row['idmodulos_menu']] = $permisos;
						}
						
						

						$menu.='<a style="cursor: pointer;" class="collapse-item" onClick="aparecermodulos(\''.$row['ubicacion_archivo'].$row['archivo'].'?idmenumodulo='.$row['idmodulos_menu'].'\',\'main\'); return false;"><i class="'.$row['icono'].'"></i>  '. $row['menu'].'</a>';
					}while($row = $this->db->fetch_assoc($resp));
					
					$menu.='</div></div> </li>';
				}
				
			}while($rows = $this->db->fetch_assoc($result));
		}
		else
		{
			$menu.="No existen modulos";
		}
		
		
		return $menu;
	}
} /* end of class Menu */

?>