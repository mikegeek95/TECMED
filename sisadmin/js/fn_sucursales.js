// JavaScript Document


function g_sucursal(regresar,donde)
{
	
	//alert(archivo_envio);
	swal({
  title: "Confirmacion",
  text: "¿Deseas guardar?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {			
			
		//recibimos todos los datos..
		
		var id = $('#v_id').val();
		var nombre = $('#nombre').val();
		var direccion = $('#direccion').val();
		var tel = $('#tel').val();
		var email = $('#email').val();
		//var tipo = $('#tipo').val();
		var notas_print = $('#notas_print').val();
		
		var datos = "nombre="+nombre+"&direccion="+direccion+"&tel="+tel+"&email="+email+"&id="+id+"&notas_print="+notas_print;
		
		console.log(datos);
	
		 $('#main').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')
				
		setTimeout(function(){
				  $.ajax({
					url:'administrador/sucursales/ga_sucursales.php', //Url a donde la enviaremos
					type:'POST', //Metodo que usaremos
					data: datos, //Le pasamos el objeto que creamos con los archivos
					error:function(XMLHttpRequest, textStatus, errorThrown){
						  var error;
						  console.log(XMLHttpRequest);
						  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#abc').html('<div class="alert_error">'+error+'</div>');	
						  //aparecermodulos("catalogos/vi_ligas.php?ac=0&msj=Error. "+error,'main');
					  },
					success:function(msj){
						   console.log("El resultado de msj es: "+msj);
						  
						   if ( msj == 1 ){
							  wal("Datos Guardados", {
									      icon: "success",
									    });
								aparecermodulos(regresar,donde);
						 	 }else{
				 				swal("Error al guardar", {
									      icon: "error",
									    });
								aparecermodulos(regresar+msj,donde);
						  	}			
					  	}
				  });				  					  
		},1000);

			  } else {
    
  }
});	
	 
}



