// JavaScript Document

function BorrarDatosCategoriaPreciosNiveles(id1,id2,campo,tabla,tipo,archivo_vizualizar,donde_mostrar)
{
	var cadena="id1="+id1+"&id2="+id2+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo;
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'catalogos/b_cat_pre_niveles.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=1&msj=Registro borrado con exito",donde_mostrar);
							  //$('#ModalPrincipal').css('display','none'); $('#contenido_modal').html('');
							  $('#modal-forms').modal('hide');
						  }
						  else{
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+msj,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial

// JavaScript Document

function guardar_subcategoria()
{
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{			
		
		var nombre = $('#nombre').val();
		var comentario = $('#comentario').val();
		var estatus = $('#estatus').val();
		var subcat = $('#subcategoria').val();
		var categoria = $('#categoria').val();
		
		var datos = 'nombre='+nombre+'&comentario='+comentario+'&estatus='+estatus+'&subcat='+subcat+'&categoria='+categoria;
		var pagina = 'productos/ga_subcategorias.php';
		
		$('#contenedor-visor-modal').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: pagina,
					  data: datos,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  alert('Error:'+error);
					  },
					  success:function(msj){
						  if (msj == 1){
							  aparecermodulos("productos/li_subcategorias.php?ac=1&msj=Operacion realizada con exito&id="+categoria,"contenedor-visor-modal");
						  }
						  else{
							 aparecermodulos("productos/li_subcategorias.php?ac=0&msj=Error. "+msj+"&id="+categoria,"contenedor-visor-modal");
						  }	
					  }
				  });				  					  
		},1000);
	}
}