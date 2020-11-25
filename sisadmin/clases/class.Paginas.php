<?php
class Paginas
{
	public $totalPaginas;//total de paginas 
	public $PaginaActual;//pagina actual
	public $LimitePaginas = 4;//limite de numeros a mostrar  a la derecha e izquierda
	public $pagina;//nombre de la pagina donde se esta realizando la consulta
	public $pagina2="";//segunda pagina a aparecer
	public $parametros;//cadena que se envia  por get de los valores que se van a mandar
	public $div_cargar;//div donde se va a cargar la paginacion
	public $div_cargar2;//segundo div a mostrar
	
	public function LinkPagSencillo()
	{
		$output = '';
		// if the current page is not the first
		if ($this->PaginaActual > 1) 
		{
			$count = 1;
			for($i = $this->PaginaActual; $i >= 1; $i --)
			 {
				if ($count > $this->LimitePaginas)
					break;
				
				if ($i == $this->PaginaActual)
					continue;
				
				$output = "<li><a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$i."&".$this->parametros."','".$this->div_cargar."') \" >".$i."</a></li>".$output;
				
				$count ++;
			}
			
			//previous page link
			$prevPage = $this->PaginaActual - 1;
			$output = "<li><a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$prevPage."&".$this->parametros."','".$this->div_cargar."')\" >Ant.</a></li>".$output;
			
			if ($prevPage > 1)
			{
				// first page link
				$output = "<li><a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=1&".$this->parametros."','".$this->div_cargar."')\" >Inicio</a></li>".$output;
			}
			
			
			
		}
		
		$output .= "<li><span class='thispage'>".$this->PaginaActual."</span></li>\r\n";
		
		// next pages
		$count = 1;
		for($i = $this->PaginaActual; $i < $this->totalPaginas; $i ++) 
		{
			if ($count > $this->LimitePaginas)
				break;
			
			if ($i == $this->PaginaActual)
				continue;
			
			$output .= "<li><a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$i."&".$this->parametros."','".$this->div_cargar."')\" >".$i."</a></li>";
			
			$count ++;
		}
		// next and last links
		if ($this->PaginaActual < $this->totalPaginas) 
		{
			// next link
			$next = $this->PaginaActual + 1;
			$output .= "<li><a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$next."&".$this->parametros."','".$this->div_cargar."')\" >Sig.</a></li>";
			
			if ($this->totalPaginas != $next)
			{
				// last page link
				$output .= "<li><a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$this->totalPaginas."&".$this->parametros."','".$this->div_cargar."')\" >Ultimo</a></li>";
			}
			
		}
		
		return $output;
	}
/************************************************************************************************************************************************************************************************************/	
	
	///funcion para la paginacion de la paginas
	public function LinckPagDoble()
	{
		$output = '';
		// if the current page is not the first
		if ($this->PaginaActual > 1) 
		{
			$count = 1;
			for($i = $this->PaginaActual; $i >= 1; $i --)
			 {
				if ($count > $this->LimitePaginas)
					break;
				
				if ($i == $this->PaginaActual)
					continue;
				
				$output = "<a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$i."&".$this->parametros."','".$this->div_cargar."'); aparecermodulos('".$this->pagina2."?pagina=".$i."&".$this->parametros."','".$this->div_cargar2."')\" >".$i."</a>\r\n".$output;
				
				$count ++;
			}
			
			//previous page link
			$prevPage = $this->PaginaActual - 1;
			$output = "<a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$prevPage."&".$this->parametros."','".$this->div_cargar."'); aparecermodulos('".$this->pagina2."?pagina=".$prevPage."&".$this->parametros."','".$this->div_cargar2."')\" >Ant.</a>\r\n".$output;
			
			if ($prevPage > 1)
			{
				// first page link
				$output = "<a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=1&".$this->parametros."','".$this->div_cargar."'); aparecermodulos('".$this->pagina2."?pagina=1&".$this->parametros."','".$this->div_cargar2."')\" >Inicio</a>\r\n".$output;
			}
			
			
			
		}
		
		$output .= "<span class='thispage'>".$this->PaginaActual."</span>\r\n";
		
		// next pages
		$count = 1;
		for($i = $this->PaginaActual; $i < $this->totalPaginas; $i ++) 
		{
			if ($count > $this->LimitePaginas)
				break;
			
			if ($i == $this->PaginaActual)
				continue;
			
			$output .= "<a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$i."&".$this->parametros."','".$this->div_cargar."'); aparecermodulos('".$this->pagina2."?pagina=".$i."&".$this->parametros."','".$this->div_cargar2."')\" >".$i."</a>\r\n";
			
			$count ++;
		}
		// next and last links
		if ($this->PaginaActual < $this->totalPaginas) 
		{
			// next link
			$next = $this->PaginaActual + 1;
			$output .= "<a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$next."&".$this->parametros."','".$this->div_cargar."'); aparecermodulos('".$this->pagina2."?pagina=".$next."&".$this->parametros."','".$this->div_cargar2."')\" >Sig.</a>\r\n";
			
			if ($this->totalPaginas != $next)
			{
				// last page link
				$output .= "<a href='#' onclick=\"aparecermodulos('".$this->pagina."?pagina=".$this->totalPaginas."&".$this->parametros."','".$this->div_cargar."'); aparecermodulos('".$this->pagina2."?pagina=".$this->totalPaginas."&".$this->parametros."','".$this->div_cargar2."')\" >Ultimo</a>\r\n";
			}
			
		}
		
		return $output;
	}
	
	
	
	public function LinkPagFront_End()
	{
		$output = '';
		// if the current page is not the first
		if ($this->PaginaActual > 1) 
		{
			$count = 1;
			for($i = $this->PaginaActual; $i >= 1; $i --)
			 {
				if ($count > $this->LimitePaginas)
					break;
				
				if ($i == $this->PaginaActual)
					continue;
				
				$output = "<li><a href='".$this->pagina."?pagina=".$i.$this->parametros."' class='flex-c-m how-pagination1 trans-04 m-all-7'>".$i."</a></li>".$output;
				
				$count ++;
			}
			
			//previous page link
			$prevPage = $this->PaginaActual - 1;
			$output = "<li><a href='".$this->pagina."?pagina=".$prevPage.$this->parametros."' class='flex-c-m how-pagination1 trans-04 m-all-7'>Ant.</a></li>".$output;
			
			if ($prevPage > 1)
			{
				// first page link
				//$output = "<li><a href='".$this->pagina."?pagina=1".$this->parametros."'>Inicio</a></li>".$output;
				$output = "<li><a href='".$this->pagina."?pagina=1".$this->parametros."' class='flex-c-m how-pagination1 trans-04 m-all-7'>Inicio</a></li>".$output;
			}
			
			
			
		}
		
		$output .= "<li class='active'><a href='#' onClick='return false;' class='flex-c-m how-pagination1 trans-04 m-all-7'>".$this->PaginaActual."</a></li>\r\n";
		
		// next pages
		$count = 1;
		for($i = $this->PaginaActual; $i < $this->totalPaginas; $i ++) 
		{
			if ($count > $this->LimitePaginas)
				break;
			
			if ($i == $this->PaginaActual)
				continue;
			
			$output .= "<li><a href='".$this->pagina."?pagina=".$i.$this->parametros."' class='flex-c-m how-pagination1 trans-04 m-all-7'>".$i."</a></li>";
			
			$count ++;
		}
		// next and last links
		if ($this->PaginaActual < $this->totalPaginas) 
		{
			// next link
			$next = $this->PaginaActual + 1;
			$output .= "<li><a href='".$this->pagina."?pagina=".$next.$this->parametros."' class='flex-c-m how-pagination1 trans-04 m-all-7'>Sig.</a></li>";
			
			if ($this->totalPaginas != $next)
			{
				// last page link
				$output .= "<li><a href='".$this->pagina."?pagina=".$this->totalPaginas.".$this->parametros.' class='flex-c-m how-pagination1 trans-04 m-all-7'>Ultimo</a></li>";
			}
			
		}
		
		return $output;
	}
}

?>