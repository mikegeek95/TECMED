// JavaScript Document

function b_cortemes()
{
	var mes = $('#mes_corte').val();
	var anho = $('#anho_corte').val();
	
	//alert(mes);
	//alert(anho);
	
	var timeSlide = 500;
	
	if(confirm("Deseas realizar la busqueda de los cortes?"))
	{
	
	$.ajax({
			  type: 'POST',
			  url: 'empresas/gastos/li_buscortes.php',
			  data: 'mes='+mes+"&anho="+anho,
			  success:function(msj){
				 
				 $('#li_modulos').html(msj);			 
				 
				 
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
				  console.log(arguments);
				  var error;
				  if (XMLHttpRequest.status === 404) error="P&aacute;gina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $('#mensajes').html('<div class="alert_error"></div>');
				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecuci&oacute;n '+error);
				  $('.alert_error').slideDown(timeSlide);
				  OcultarDiv('mensajes');							  
			  }
		  });
	}
	
	
}


function b_cortemespromotores()
{
	var mes = $('#mes_corte').val();
	var anho = $('#anho_corte').val();
	
	//alert(mes);
	//alert(anho);
	
	var timeSlide = 500;
	
	if(confirm("Deseas realizar la busqueda de los cortes?"))
	{
	
	$.ajax({
			  type: 'POST',
			  url: 'empresas/gastos/li_buscortes_promotores.php',
			  data: 'mes='+mes+"&anho="+anho,
			  success:function(msj){
				 
				 $('#li_modulos').html(msj);			 
				 
				 
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
				  console.log(arguments);
				  var error;
				  if (XMLHttpRequest.status === 404) error="P&aacute;gina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $('#mensajes').html('<div class="alert_error"></div>');
				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecuci&oacute;n '+error);
				  $('.alert_error').slideDown(timeSlide);
				  OcultarDiv('mensajes');							  
			  }
		  });
	}
	
	
}



function guardarpago()
 {
 
       //levantamos los datos de la variable
	   
	   var id_nota = document.getElementById('idcorte').value;
	   var estatus = document.getElementById('estatus').value;
	   var f_pago = document.getElementById('formadepago').value;
	   var descripcion = document.getElementById('descripcion').value;
	   var no_operacion = document.getElementById('operacion').value;
	   var banco = document.getElementById('banco').value;
	   
	   
	   if(no_operacion != "")
	   {
				
			if(confirm('Desea guardar'))	
				{
					
					
				   //	alert('idcorte: '+id_nota+' estatus= '+estatus+ ' f_pago= '+f_pago + ' descripcion= '+ descripcion+' no_operacion= '+no_operacion+ " banco ="+banco);
					
					$.ajax({
			  type: 'POST',
			  url: 'empresas/gastos/ga_cortepago.php',
			  data: 'idcorte='+id_nota+"&estatus="+estatus+"&f_pago="+f_pago+"&descripcion="+descripcion+"&no_operacion="+no_operacion+"&banco="+banco,
			  success:function(msj){
				 
				  aparecermodulos('empresas/vi_cortes.php','main'); 
				 
				 
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
				  console.log(arguments);
				  var error;
				  if (XMLHttpRequest.status === 404) error="P&aacute;gina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $('#mensajes').html('<div class="alert_error"></div>');
				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecuci&oacute;n '+error);
				  $('.alert_error').slideDown(timeSlide);
				  OcultarDiv('mensajes');							  
			  }
		  });
	 
	   }
	   }
	   else
	   {
	      alert("NO DEBE DE QUEDAR NINGUN CAMPO VACIO");
	   }
	   
	   
 
 }



function b_gastos(idmenu)
{

	var mes = $('#mes_gastos').val();
	var anho = $('#anho_gastos').val();
	var tipo = $('#v_tipo').val();
	
	//alert(mes);
	//alert(anho);
	
	var timeSlide = 500;
	
	
	$.ajax({
			  type: 'POST',
			  url: 'compras/gastos/li_busgastos.php?idmenumodulo='+idmenu,
			  data: 'mes='+mes+"&anho="+anho+"&tipo="+tipo,
			  
			  success:function(msj)
			  {
				 
				 $('#li_modulos').html(msj);		 
				 
				 
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
				  console.log(arguments);
				  var error;
				  if (XMLHttpRequest.status === 404) error="P&aacute;gina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $('#mensajes').html('<div class="alert_error"></div>');
				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecuci&oacute;n '+error);
				  $('.alert_error').slideDown(timeSlide);
				  OcultarDiv('mensajes');							  
			  }
		  });	
}


function b_gastosventas()
{

	var mes = $('#mes_gastos').val();
	var anho = $('#anho_gastos').val();
	var tipo = $('#v_tipo').val();
	
	//alert(mes);
	//alert(anho);
	
	var timeSlide = 500;
	
	if(confirm("Deseas realizar la busqueda de los Gastos?"))
	{
	
	$.ajax({
			  type: 'POST',
			  url: 'reportes/gastos/li_bgastosventas.php',
			  data: 'mes='+mes+"&anho="+anho+"&tipo="+tipo,
			  success:function(msj)
			  {
				 
				 $('#li_gastos').html(msj);		 
				 
				 
			  },
			  error:function(XMLHttpRequest, textStatus, errorThrown){
				  console.log(arguments);
				  var error;
				  if (XMLHttpRequest.status === 404) error="P&aacute;gina no existe"+XMLHttpRequest.status;// display some page not found error 
				  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
				  $('#mensajes').html('<div class="alert_error"></div>');
				  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecuci&oacute;n '+error);
				  $('.alert_error').slideDown(timeSlide);
				  OcultarDiv('mensajes');							  
			  }
		  });
		  
		  
		  
		  
	}
	
	
}


