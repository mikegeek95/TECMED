// JavaScript Document

function b_productos(donde,idmenu)
{

	var cod = $('#v_codigo').val();
	var cod_proveedor = $('#v_cod_proveedor').val();
	var nombre = $('#v_nombre').val();
	var descripcion = $('#v_descripcion').val();
	var precio = $('#v_precio').val();
	var estatus = $('#estatus').val();
	var categoria = $('#v_existencia').val();
	var depende = $('#v_depende').val();

	var timeSlide = 100;
	

	$("#"+donde).html('<div style="padding: 5px; text-align:center;"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');	
	
	$.ajax({
			  type: 'POST',
			  url: 'productos/productos/li_producto.php?idmenumodulo='+idmenu,
			  data: 'cod='+cod+"&cod_proveedor="+cod_proveedor+"&descripcion="+descripcion+"&precio="+precio+"&estatus="+estatus+"&nombre="+nombre+"&categoria="+categoria+"&depende="+depende,
			  success:function(msj)
			  {
				 
				 $('#'+donde).html(msj);		 
				 
				 
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


function G_producto(form,file_guardar,file_ver,donde)
{ 

	var bootstrapValidator = $("#"+form).data('bootstrapValidator');
		bootstrapValidator.validate();
		var valid=bootstrapValidator.isValid();
		if(valid){

	swal({
  title: "Confirmacion",
  text: "¿Deseas guardar?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

	$("#modal-forms").modal('hide');

	 //iniciamos a formar el form para envio.
	 
	var data = obtenerformulario();
	
	console.log(data.get('tipo'));
	 
	 $('#'+donde).html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>')


setTimeout(function(){
  $.ajax({
    url:file_guardar, //Url a donde la enviaremos
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
						  aparecermodulos(file_ver,donde_mostrar);
					  },
         }).done(function(msg)
           {
           	console.log(msg);
			   if ( msg == 1 ){
						console.log("si");	  
				aparecermodulos(file_ver,donde);
						  }
				 else{
				 	console.log("no");
				aparecermodulos(file_ver,donde);
						  }					
	  
  }
  );
  
  },3000 );
	 
	 
	 
	 //console.log("Producto ID:"+jquery.data('idproducto'))
	 
	 } else {

  }
});
	//alert(archivo_envio);
}else{
	    swal({
  title: "ERROR",
  text: "Uno mas elementos son requeridos",
  icon: "warning",
});
}
}




function obtenerformulario()
{
	 var data = new FormData();
	  
	  data.append('tipo',$('#id').val());
	  data.append('idproducto',$('#idproducto').val());	  
	  data.append('cod_proveedor',$('#cod_proveedor').val());
	  data.append('subcategoria',$('#subcategoria').val());
	  data.append('nombre',$('#nombre').val());
	  console.log('la categoria es: '+$('#subcategoria').val());
	  data.append('p_costo',$('#p_costo').val());
	  data.append('p_venta',$('#p_venta').val());
	  data.append('v_descuento',$('#v_descuento').val());
	  data.append('v_stock',$('#v_stock').val());
	  data.append('v_estatus',$('#v_estatus').val());
	  data.append('v_unidad',$('#v_unidad').val());
	  data.append('descripcion',$('#descripcion').val());
	  data.append('v_idcategoria_precio',$('#v_idcategoria_precio').val());
	  
	  var archivos = document.getElementById("v_imagen");//Damos el valor del input tipo file
	  var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
	 //alert(data);
	 
	 //Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
  //objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
  //que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
	  for(i=0; i<archivo.length; i++){
		data.append('archivo'+i,archivo[i]);
	  }
	 
	 return data;
}




function g_productos_imagenes()
{
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{	
		//recibimos todos los datos...
		var archivos = document.getElementById("v_imagen");//Damos el valor del input tipo file
  		var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
   		var v_idproducto = $('#v_idproducto').val();
		var estatus = $('#est_tus').val();
		var idproductos_imagenes = $('#v_idproductos_imagenes').val();
     
	  	//El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
	  	var data = new FormData();

   		data.append('v_idproducto',v_idproducto);

  		//Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
  		//objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
  		//que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
	  	for(i=0; i<archivo.length; i++){
			data.append('archivo'+i,archivo[i]);
	  	}
  
  
		data.append('estatus',estatus);
		data.append('idproductos_imagenes',idproductos_imagenes);
				
		$('#contenido_modal').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Subiendo Archivos...</div>');


		setTimeout(function(){
  			$.ajax({
    			url:'productos/ga_productos_imagenes.php', //Url a donde la enviaremos
				type:'POST', //Metodo que usaremos
				contentType:false, //Debe estar en false para que pase el objeto sin procesar
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
						  //aparecermodulos(archivo_vizualizar+"?ac=0&msj=Error. "+error,donde_mostrar);
						  console.log(error);
					  },
         		}).done(function(msg)
           		{
			   
			   		console.log(msg);
	            	if(msg == 1)
	                   {
							AbrirModalGeneral2('ModalPrincipal','900','560','productos/vi_productos_imagenes.php?id='+v_idproducto);
					   }else
					   {
						   $('#contenido_modal').html(msg);
							 // $('#myModal').modal('hide');
						 }
  				}
  			);
  
  		},3000 );
	}
}


//funcion para borrar datos de la base de datos
function BorrarDatosImg2(id,campo,tabla,tipo,archivo_vizualizar,donde_mostrar,carpeta)
{
	var cadena="id="+id+"&campo="+campo+"&tabla="+tabla+"&tipo="+tipo+"&carpeta="+carpeta;
	console.log(cadena);
	if(confirm("\u00BFEstas seguro de querer realizar esta operaci\u00f3n?"))
	{
		$('#abc').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
		overlayopen('abc');
		setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'clases/borrarImg.php',
					  data: cadena,
					  success:function(msj){
						  if ( msj == 1 ){
							  overlayclose('abc');
							  aparecermodulos(archivo_vizualizar,donde_mostrar);
							  AbrirModalGeneral2('ModalPrincipal','900','560',archivo_vizualizar);
						  }
						  else{
							  overlayclose('abc');
							  console.log(msj);
							  aparecermodulos(archivo_vizualizar,donde_mostrar);
						  }							  
					  },
					  error:function(){
						  console.log(error);
						  $('#'+donde_mostrar).html('<div class="alert_succes"></div>');
						  $('.alert_error').hide(0).html('Ha ocurrido un error durante la ejecución');
						  $('.alert_error').slideDown(timeSlide);
						  
					  }
				  });				  					  
		},1000);
	}
}// fin de function GuardarEspecial

		function  combosubcategorias(subcategoria)
	{
		var categoria = $("#categoria").val();
		
		//obtenemos los valores de la liena del producto
	    console.log("bucar buscategorias de la categoria "+categoria);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/productos/vi_combo_subcategorias.php',					  
					  data:'categoria='+categoria+'&subcategoria='+subcategoria,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#content_combo_subcategorias').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#content_combo_subcategorias").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		
		
	}