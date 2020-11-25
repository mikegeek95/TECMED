$(function(){
//ing. Romeo---manejo de eventos, click o enter	del formulario login

		$("#pass,#usuario").keypress(function(e) {
		key = e.keyCode || e.which;
		if (key == 13) {
			InicioSesion();
		}
	});

	$("#btnIniSes").click(function() {
		InicioSesion();
	});
	
	
	
function InicioSesion() {		
    
		var bootstrapValidator = $("#logeo").data('bootstrapValidator');
		bootstrapValidator.validate();
		var valid=bootstrapValidator.isValid();
		if(valid){
		
		var user = $("#usuario").val();
		var pass =$("#pass").val();		
		var timeSlide = 500;		

					$.ajax({
						  type: 'POST',
						  url: 'validar.php',
						  data: 'usuario='+user+'&contrasena='+pass,
						  success:function(msj){
							  
							  console.log(msj);
							  
							  if ( msj == 1 ){
								  //alert(msj);
								  //$('#mensajes').html('<div class="alert_success"></div>');
								  swal({
								      icon: "success",
									  title: "Datos Correctos",
									  text: "Iniciando Sesión",
									  type: "success",
									  
									});
								  setTimeout(function(){
										window.location.href = ".";
									},(timeSlide + 500));
							  }
							  else if(msj==2)
							  {
								  //$('#mensajes').html('<div class="alert_warning"></div>');
								  swal({
								      icon: "error",
									  title: "Error",
									  text: "Usuario Desactivado",
									  type: "error",
									  
									});
								  //OcultarDiv('mensajes');
								 $("#usuario").val("");
								 $("#pass").val("");
								  
							  }
							  else{
								  //$('#mensajes').html('<div class="alert_error"></div>');
								  swal({
								      icon: "error",
									  title: "Error",
									  text: "Datos incorrectos",
									  type: "error",
									  
									});
								  //OcultarDiv('mensajes');
								  $("#usuario").val("");
								 $("#pass").val("");
								  
							  }
							  
							  
						  },
						  error:function(XMLHttpRequest, textStatus, errorThrown){
							  console.log("El error es :" +arguments);
							  var error;
							  if (XMLHttpRequest.status === 404) error="Pagina no existe "+XMLHttpRequest.status;// display some page not found error 
							  if (XMLHttpRequest.status === 500) error="Error del Servidor "+XMLHttpRequest.status; // display some server error 
							  $('#mensajes').html('<div class="alert_error"></div>');
							  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución '+error);
							  $('.alert_error').slideDown(timeSlide);
							  OcultarDiv('mensajes');
							  $("#validar").html(boton);
						  }
					  });
		}
	};	
});