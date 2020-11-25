// JavaScript Document


// JavaScript Document
function g_Configuracion(formulario)
{
	var bootstrapValidator = $("#"+formulario).data('bootstrapValidator');
		bootstrapValidator.validate();
		var valid=bootstrapValidator.isValid();
		if(valid){
	//recibimos todos los datos...
	swal({
  title: "Confirmacion",
  text: "¿Deseas guardar?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
  var archivos = document.getElementById("v_logo");//Damos el valor del input tipo file
  var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo

 

   var v_id = $('#v_id').val();
  
    var v_nombre_empresa = $('#v_nombre_empresa').val();
   
	var v_url = $('#v_url').val();
	var v_email = $('#v_email').val();
	var v_telefono = $('#v_telefono').val();
	var v_direccion = $('#v_direccion').val();
	var v_email_pedido = $('#v_email_pedido').val();
	var clave_caja = $('#v_pass_caja').val();
	var formato_impresion = $('#tipo_impresion').val();
	var comision = $('#comision').val();
    	
		
	var v_razonsocial = $('#v_razonsocial').val();
    var v_rfc = $('#v_rfc').val();
	var v_dfiscal = $('#v_dfiscal').val();
	var v_nint = $('#v_nint').val();
	var v_next = $('#v_next').val();
	var v_ciudad = $('#v_ciudad').val();
    var v_estado = $('#v_estado').val();
	var v_cp = $('#v_cp').val();
	var v_colonia = $('#v_colonia').val();
	
	
	var v_iva = $('#v_iva').val();
	var v_tipo_descuento = $('#v_tipo_descuento').val();
	var v_cuentas = $('#v_cuentas').val();
	var v_moneda = $('#v_moneda').val();
	
	
	var v_e_cuenta = $('#v_e_cuenta').val();
	var v_e_clave = $('#v_e_clave').val();
	var v_e_pop = $('#v_e_pop').val();
	var v_e_pentrante = $('#v_e_pentrante').val();
	var v_e_smtp = $('#v_e_smtp').val();
	var v_e_psaliente = $('#v_e_psaliente').val();
	var v_e_autenticacion = $('#v_e_autenticacion').val();
	var v_e_ss = $('#v_e_ss').val();
	


	var v_horario = $('#v_horario').val();
	var v_facebook = $('#v_facebook').val();
	var v_instagram = $('#v_instagram').val();
	var v_twiter = $('#v_twiter').val();
	var v_youtube = $('#v_youtube').val();
	
		
   
  
  
  //El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
  var data = new FormData();

   data.append('v_id',v_id);

  //Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
  //objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
  //que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
  for(i=0; i<archivo.length; i++){
	data.append('archivo'+i,archivo[i]);

  }
	
 
  
  data.append('v_nombre_empresa',v_nombre_empresa);
  //data.append('v_direccion',v_direccion);
  //data.append('v_telefonos',v_telefonos);
  data.append('v_email_pedido',v_email_pedido);
  data.append('v_url',v_url);
	data.append('v_telefono',v_telefono);
	data.append('v_direccion',v_direccion);
  data.append('v_email',v_email);
  data.append('clave_caja',clave_caja);
  data.append('formato_impresion',formato_impresion);
  data.append('comision',comision);
  
  
  data.append('v_razonsocial',v_razonsocial);
  data.append('v_rfc',v_rfc);
  data.append('v_dfiscal',v_dfiscal);
  data.append('v_nint',v_nint);
  data.append('v_next',v_next);
  data.append('v_ciudad',v_ciudad);
  data.append('v_estado',v_estado);
  data.append('v_cp',v_cp);
  data.append('v_colonia',v_colonia);
  
  
  data.append('v_iva',v_iva);
  data.append('v_tipo_descuento',v_tipo_descuento);
  data.append('v_cuentas',v_cuentas);
  data.append('v_moneda',v_moneda);
  
  
  data.append('v_e_cuenta',v_e_cuenta);
  data.append('v_e_clave',v_e_clave);
  data.append('v_e_pop',v_e_pop);
  data.append('v_e_pentrante',v_e_pentrante);
  data.append('v_e_smtp',v_e_smtp);
  data.append('v_e_psaliente',v_e_psaliente);
  data.append('v_e_autenticacion',v_e_autenticacion);
  data.append('v_e_ss',v_e_ss);


	data.append('v_horario',v_horario);
	data.append('v_facebook',v_facebook);
	data.append('v_instagram',v_instagram);
	data.append('v_twiter',v_twiter);
	data.append('v_youtube',v_youtube);


 

$('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')


setTimeout(function(){
  $.ajax({
    url:'administrador/configuracion/ga_configuracion.php', //Url a donde la enviaremos
    type:'POST', //Metodo que usaremos
    contentType:false, //Debe estar en false para que pase el objeto sin procesar
    data:data, //Le pasamos el objeto que creamos con los archivos
    processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
    cache:false, //Para que el formulario no guarde cache,
	error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  overlayclose('abc');
						  aparecermodulos("administrador/configuracion/vi_configuracion.php?ac=0&msj=Error. "+error,'main');
					  },
         }).done(function(msg)
           {
			   console.log(msg);
	            if(msg == 1)
	                   {
		                    aparecermodulos('administrador/configuracion/vi_configuracion.php?ac=1&msj=Operacion realizada con exito','main');
					   }else
					   {
						      aparecermodulos('administrador/configuracion/vi_configuracion.php?ac=1&msj=Operacion no fue realizada','main');
						 }
	  
  }
  );
  
  },3000 );
	  } else {
    
  }
});	
}else{
	    swal({
  title: "ERROR",
  text: "Uno mas elementos son requeridos",
  icon: "warning",
});
}	
}





function VerificarEmail(donde)
{

    //verificaremos el sistema haciendo un tester de la configuración.
	$("#"+donde).html("Realizando Prueba");
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'administrador/testerEmail.php',					  
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  
					  $("#"+donde).html(msj);
					  
					  	/*if(msj == 1)
						   {
						      $("#"+donde).html(msj);  
						   }else
						   {
                            $("#"+donde).html(msj); 
							}
						*/
						
						
					  }
				  });				  					  
		},800);	
		
		


}