// JavaScript Document

function AgregarCestaEntrada()
{
	
		
	
	console.log("Entro al metodo");
	var clave_produ = $("#v_codigo").val();
	var costo_produ = $("#v_costo").val();
	var talla = $('#talla').val();
	var cantidad_produ = $("#v_cantidad").val(); //1 se cambio a campo para que hacer mas facil la agregada de productos 
	var cadena = 'v_idproducto='+clave_produ+"&v_costo="+costo_produ+"&v_cantidad="+cantidad_produ+"&talla="+talla;
	
	console.log(cadena);
	//obtenemos los valores de la liena del producto
	console.log("Entro al metodo");
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/entradas/ga_cesta.php',					  
					  data:cadena,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						  console.log("el msj de agregarcestaEntrada es = "+msj);	
					  
					    $('#v_codigo').val('');	
						$('#v_costo').val('');
						$('#v_cantidad').val('');
						$('#v_codigo').focus();
						$("#descripcion_carrito").html(msj);  
						
					  }
				  });				  					  
		},800);	

	
	
}


function  eliminarCarrito(idproducto,donde)
	{
				swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas quitar este producto?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+idproducto);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/b_cesta.php',					  
					  data:'v_idproducto='+idproducto,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
					  } 
});
		
	}
	
	
	function  eliminarTodoCarrito(nombre,donde)
	{
		swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas limpiar la lista de entradas?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/entradas/bt_cesta.php',					  
					  data:'v_nombresesion='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  swal("Error al Borrar", {
							   	icon: "error",
							    });
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	swal("Carrito Limpio", {
							   	icon: "success",
							    });
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
			  } 
});
		
	}
	
	

function validarSelectEstados ()
{
	var pais = document.getElementById('idpais').value;
	var r ;
	console.log("entro a validar select estados con el pais = "+pais);
	
	if (pais == 0)
	{
		r = 0;
		alert ("debe seleccionar un pais");
	}
	else 
	{
		r = 1 ;
	}
	return r ;
}	
	
	
	function IngresarProductoInventario()
	{
		 
		 console.log('Entro a el proceso de dar de alta a inventario.');
			 
		/* var idproveedor = $("#v_idproveedor").val();		 
		 if(idproveedor != 0)
		  {*/
		 
			swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas guardar el registro de entrada de producto?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	   
		
		$("#descripcion_carrito").html('<div style=" margin-top:-14px" align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Guardando...</div>');
		//obtenemos valores de las variables
		
		               var cadena = "" ;		
						//var v_no_factura = $('#v_no_factura').val();
						//var v_monto = $('#v_monto').val();
						//var v_idproveedor = $('#v_idproveedor').val();
						
						var v_f_ingreso = $('#v_f_ingreso').val();
					    var tipo = $('#tipo_com').val();
						var tipo_entrada_compra = $('#tipo_entrada_compra').val();  //valores que se reciben desde los campos dependiendeo el list box
						var tipo_entrada_dev = $('#tipo_entrada_dev').val();										
						var descripcion = $('#v_descripcion').val();
						var sucursal = $('#sucursal').val();
						
						//alert ('tipo entrada dev:'+tipo_entrada_dev+' tipo entrada compra: '+tipo_entrada_compra);
						
						
						
						
						
						
						if(!tipo_entrada_compra)
						   {
							  tipo_entrada_compra = ""; 
							}
							
					    if(!tipo_entrada_dev)
						   {
							  tipo_entrada_dev = ""; 
							}
						
						
						
					
						
						cadena = "v_f_ingreso="+v_f_ingreso+'&tipo_entrada_compra='+tipo_entrada_compra + '&tipo_entrada_dev='+tipo_entrada_dev+"&descripcion="+descripcion+'&tipo_com='+tipo+"&sucursal="+sucursal;
						
						
						// "&v_no_factura="+v_no_factura+"&v_idproveedor="+v_idproveedor+"&v_monto="+v_monto+
	                   // var cadena = "v_tipo="+v_tipo+"&v_f_ingreso="+v_f_ingreso+'&tipo_entrada_dev='+tipo_entrada_dev+'&tipo_entrada_compra='+tipo_entrada_compra;
						//alert (cadena);
						
						
						console.log(cadena);
						
			 console.log("Entro al metodo de Agregar producto a inventario");
		
					
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/entradas/ga_entradas.php',					  
					  data:cadena,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#mensaje').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#descripcion_carrito").html(msj);  
						console.log("estamos en el succes de guardarentrada inventario");
					  }
				  });				  					  
		},2000);	
		
					  } 
});
		 
	  	
	}
	
	
	//CARRITO DE COMPRAS||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||->
	//CARRITO DE COMPRAS||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||->
	//CARRITO DE COMPRAS||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||->
	
	function AgregarCestaCompras()
{
	
	var clave_produ = $("#v_codigo").val();
	//var costo_produ = $("#v_costo").val();
	var cantidad_produ = $("#v_cantidad").val(); //sCantidad del producto a ingresar 
	
	
	/*if(confirm("Deseas Agregar el Producto a la Cesta de Comrpas?"))
	    {*/
		
		
	//obtenemos los valores de la liena del producto
	console.log("Entro al metodo");
	
	
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'compras/compras/ga_cesta.php',					  
					  data:'v_idproducto='+clave_produ+"&v_cantidad="+cantidad_produ,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  
					    $('#v_codigo').val('');	
						$('#v_costo').val('');
						$('#v_cantidad').val('');
						$("#descripcion_carrito").html(msj);  
						
					  }
				  });				  					  
		},800);	
		// } fin de el confirm
	
	
}



function  eliminarCarritoCompras(idproducto,donde)
	{
								swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas quitar este producto?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+idproducto);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'compras/b_cesta.php',					  
					  data:'v_idproducto='+idproducto,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		
		})
	}
	
	
	function  eliminarTodoCarritoCompras(nombre,donde)
	{
			swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas limpiar la lista de salidas?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'compras/bt_cesta.php',					  
					  data:'v_nombresesion='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	swal("Carrito Limpio", {
							   	icon: "success",
							    });
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
					  } 
});
		
	}
	
	
	
	function IngresarProductoCompras()
	{
		 
		 console.log('Entro a el proceso de dar de alta a Compras.');
			 
		/* var idproveedor = $("#v_idproveedor").val();		 
		 if(idproveedor != 0)
		  {*/
		 
	if(confirm("Deseas Agregar a Compras?"))
	    {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de Agregar producto a inventario");
		
		
		//obtenemos valores de las variables
		
		               var cadena = "" ;		
						//var v_no_factura = $('#v_no_factura').val();
						//var v_monto = $('#v_monto').val();
						//var v_idproveedor = $('#v_idproveedor').val();
						
						//var v_f_ingreso = $('#v_f_ingreso').val();
												
						var tipo_entrada_compra = $('#tipo_entrada_compra').val();  //valores que se reciben desde los campos dependiendeo el list box
						var tipo_entrada_dev = $('#tipo_entrada_dev').val();										
						var descripcion = $('#v_descripcion').val();
						
						//alert ('tipo entrada dev:'+tipo_entrada_dev+' tipo entrada compra: '+tipo_entrada_compra);
						
						
						
						
						
						
						if(!tipo_entrada_compra)
						   {
							  tipo_entrada_compra = ""; 
							}
							
					    if(!tipo_entrada_dev)
						   {
							  tipo_entrada_dev = ""; 
							}
						
						
						
					
						
						cadena = 'tipo_entrada_compra='+tipo_entrada_compra + '&tipo_entrada_dev='+tipo_entrada_dev+"&descripcion="+descripcion;
						
						
						// "&v_no_factura="+v_no_factura+"&v_idproveedor="+v_idproveedor+"&v_monto="+v_monto+
	                   // var cadena = "v_tipo="+v_tipo+"&v_f_ingreso="+v_f_ingreso+'&tipo_entrada_dev='+tipo_entrada_dev+'&tipo_entrada_compra='+tipo_entrada_compra;
						//alert (cadena);
						
						
						console.log(cadena);
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/ga_inventario.php',					  
					  data:cadena,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#mensaje').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#descripcion_carrito").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		
		  // }//termina validacion diferente a 0
		 else
		 {
			 //alert("Debes de agregar un proveedor en el ara de catalogos!");
			 /*var html ='<div id="mens" class="alert_error">Debes de Agregar un Proveedor en el area de Catalogos</div>';
			 var html = html + '<script type="text/javascript">OcultarDiv("mens")</script>';
			 
			 $("#mensaje").html(html);*/
			 
			 
			 
		  }
		 
	  	
	}
	
	
	function IngresarCompras (archivo_vizualizar,donde_mostrar)
	{
						swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas guardar el registro de compra?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		//var fecha = document.getElementById('v_f_ingreso').value;
		var prioridad = document.getElementById('prioridad').value ;
		var descripcion = document.getElementById('v_descripcion').value ;
		var sucursal = document.getElementById('sucursal').value ;
		var cadena = 'prioridad='+prioridad+'&descripcion='+descripcion+'&sucursal='+sucursal ;
		
		console.log ("la cadena es"+cadena);
		$.ajax({
					  type: 'POST',
					  url: 'compras/compras/ga_compras.php',					  
					  data:cadena,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#descripcion_carrito').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  //alert ("el mensaje es ="+msj);					   
						//$("#descripcion_carrito").html(msj);  
						console.log(msj);
						swal("Compra Guardada", {
							   	icon: "success",
							    });
						$('#fondo').slideDown("fast");
						$('#modal').html(msj);
						$('#modal').slideDown("slow");
						$('#v_descripcion').html('');
						$('#descripcion_carrito').html('<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter"><tr><td align="center">Tu carrito de compras esta vac&iacute;o<br /></td></tr></table>');
						 aparecermodulos(archivo_vizualizar,donde_mostrar);
					  }
				  });
		
					  } 
});
		
	}
	
	
	//TERMINA CARRITO DE COMPRAS
	
	
	
	
	
	
	
	//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	//CARRITO PARA LAS ETIQUETAS
	//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	
	
	function AgregarCestaEtiquetas()
{
	
	var clave_produ = $("#v_codigo").val();
	
	var cantidad_produ = $("#v_cantidad").val(); //sCantidad del producto a ingresar 
	
	var unidad = $("#talla").val();
	
	console.log("Entro al metodo");

	var data='v_idproducto='+clave_produ+'&v_cantidad='+cantidad_produ+'&unidad='+unidad;
	
	console.log(data);
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/ga_cesta_etiquetas.php',					  
					  data:data,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  
					    $('#v_codigo').val('');	
						$('#v_talla').val('');	
						$('#v_cantidad').val('');
						$("#descripcion_carrito").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
	
	
}



function  eliminarCarritoEtiquetas(idproducto,donde)
	{
			if(confirm("Deseas Eliminar el Producto de la Cesta?"))
	    {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+idproducto);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/b_cestaetiquetas.php',					  
					  data:'v_idproducto='+idproducto,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		
	}
	
	
	function  eliminarTodoCarritoEtiquetas(nombre,donde)
	{
			if(confirm("Deseas Borrar la Cesta?"))
	    {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/bt_cestaetiquetas.php',					  
					  data:'v_nombresesion='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		
	}
	
	
function reporteprod_vend()
{
	
	console.log("llego al metodo");
			  
	$.ajax({
		url:'ventas/excel/preporte_prod_vend.php', //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		error:function(XMLHttpRequest, textStatus, errorThrown){
			  var error;
			  console.log(XMLHttpRequest);
			  if (XMLHttpRequest.status === 404)  error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
			  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
			  console.log(error);
			console.log("llego al error");
		  },
		success:function(msj){
			console.log(msj);
					if(msj=="null"){
						alert("no existen registos segun los parametros de busqueda");
					}
					else{
					var contenedor = "contenedor-productos-vendidos";
				
					var url = "ventas/excel/preporte_prod_vend.php";
					
					$("#"+contenedor).attr("src",url);
						
					
					}
				
			}
	  });				  					  
}
	
	
	
	function IngresarEtiquetas (id)
	{
		//var fecha = document.getElementById('v_f_ingreso').value;
		
		
		console.log ("el id es"+id);
		$('#fondo').slideDown("fast");
		
		$('#modal').slideDown("slow");
		$('#modal').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Generando Lista...</div>');
		$.ajax({
					  type: 'POST',
					  url: 'productos/ga_etiqueta_detalle.php',
					  data:'id='+id,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  //alert ("el mensaje es ="+msj);					   
						//$("#descripcion_carrito").html(msj);  
						
						$('#modal').html(msj);
						$('#descripcion_carrito').html('<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter"><tr><td align="center"><img src="images/shoppingcart_empty.png"/><br />Tu carrito de compras esta vac&iacute;o<br /></td></tr></table>');
						
					  }
				  });
		
		
		
	}
	
	
	
	
	
	
	//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	//TERMINA CARRITO PARA LAS ETIQUETAS
	//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	
	//*********************************************************************************************************
	//******************************* CARRITO DE SALIDAS ******************************************************
	//*********************************************************************************************************
	
	function AgregarCestaSalida()
{
	
		
	
	console.log("Entro al metodo");
	var clave_produ = $("#v_codigo").val();
	//var costo_produ = $("#v_costo").val();
	var cantidad_produ = $("#v_cantidad").val();
	var sucursal = $('#sucursal').val(); 
	var talla = $('#talla').val();
	
	console.log("INGRESARA A IF");
	
	//obtenemos los valores de la liena del producto
	console.log("Entro al metodo AgregarCestaSalida");
	
	
	$('#descripcion_carrito').html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/salidas/ga_cestaSalida.php',					  
					  data:'v_idproducto='+clave_produ+"&v_cantidad="+cantidad_produ+"&sucursal="+sucursal+"&talla="+talla,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  
					    console.log(msj);
					    $('#v_codigo').val('');							
						$('#v_cantidad').val('');
						$("#descripcion_carrito").html(msj);  
						
					  }
				  });				  					  
		},300);	

	
	
}


function  eliminarCarritoSalida(idproducto,donde)
	{
						swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas quitar este producto?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+idproducto);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/b_cestaS.php',					  
					  data:'v_idproducto='+idproducto,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		});
	}
	
	
	function  eliminarTodoCarritoSalida(nombre,donde)
	{
				swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas limpiar la lista de salidas?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrartodocarrito salida"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/salidas/bt_cestaS.php',					  
					  data:'v_nombresesion='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	swal("Carrito Limpio", {
							   	icon: "success",
							    });
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
			  } 
});
		
	}
	

	
	function IngresarProductoSalida()
	{
		 
		 console.log('Entro a el proceso de dar de alta a inventario.');
			 
		/* var idproveedor = $("#v_idproveedor").val();		 
		 if(idproveedor != 0)
		  {*/
		 
				swal({
  title: "¿Estas Seguro?",
  text: "¿Deseas guardar el registro de salida de producto?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de Agregar producto a inventario");
		
		
		//obtenemos valores de las variables
		
						
						var v_f_salida = $('#v_f_salida').val();
						var tipo = $('#tipo_sal').val();
						var nota = $('#id_nota_remision').val();	
						var sucursal = $('#sucursal').val();
						
						cadena = "v_f_salida="+v_f_salida+"&tipo="+tipo+"&id="+nota+"&sucursal="+sucursal;
						
					
						console.log(cadena);
						$("#descripcion_carrito").html('<div align="center" class="mostrar"><img src="images/loader.gif" alt="" /><br />Cargando...</div>');
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'productos/salidas/ga_salidas.php',					  
					  data:cadena,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#mensaje').html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					
					  	swal("Registro de Slida Guardado", {
							   	icon: "success",
							    });
						$("#descripcion_carrito").html(msj);  
						
					  }
				  });				  					  
		},800);	
		
					  } 
}); 
	  	
	}
	
	
	
	
	
	
	
	
	//*********************************************************************************************************
    //******************************** FIN DE CARRITO SALIDAS *************************************************
	//*********************************************************************************************************
	
	
	
	
	
	
	
	
	
		//*********************************************************************************************************
	//******************************* CARRITO DE ENTREGA ******************************************************
	//*********************************************************************************************************
	
	function AgregarCestaEntrega(e)
{
	
		
	
	console.log("Entro al metodo");
	var clave_produ = $("#v_codigo").val();
	var id_nota_remision = $('#id_nota_remision').val();
	//var costo_produ = $("#v_costo").val();
	var cantidad_produ = 1;//$("#v_cantidad").val(); 
	var e = event.keyCode;
	
	//console.log("INGRESARA A IF");
	
	//obtenemos los valores de la liena del producto
	console.log("Entro al metodo AgregarCestaEntrada");
	var cadena = 'v_idproducto='+clave_produ+"&v_cantidad="+cantidad_produ+'&idnota_remision='+id_nota_remision;
	console.log("cadena es = "+cadena);
	
	 if ( e == 13 )
	 {
		
		console.log("paso el e= 13");
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'Ventas/ga_cestaEntrega.php',					  
					  data:cadena,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  
					    $('#v_codigo').val('');	
						
						$('#v_cantidad').val('');
						$("#descripcion_carrito").html(msj);  
						$("#v_codigo").focus()
						
					  }
				  });//fin del ajax				  					  
		},800);	//fin del setTimeout
		
	 }//fin del if

	
	
}


function  eliminarCarritoEntrega(idproducto,donde)
	{
			if(confirm("Deseas Eliminar el Producto de la Cesta?"))
	    {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrar"+idproducto);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'ventas/b_cestaE.php',					  
					  data:'v_idproducto='+idproducto,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		
	}
	
	
	function  eliminarTodoCarritoEntrega(nombre,donde)
	{
			if(confirm("Deseas Borrar la Cesta?"))
	    {
		
		//obtenemos los valores de la liena del producto
	    console.log("Entro al metodo de borrartodocarrito salida"+nombre);
	
	
	setTimeout(function(){
				  $.ajax({
					  type: 'POST',
					  url: 'ventas/bt_cestaE.php',					  
					  data:'v_nombresesion='+nombre,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){	
					  	
						$("#"+donde).html(msj);  
						
					  }
				  });				  					  
		},800);	
		
		}
		
	}
	
	
	
	function g_entrega ()
{
	console.log("entro a g_entrega");
	id = document.getElementById('id_nota_remision').value;
	console.log ('el id nota de remision es = '+id);
	
	if(id!=""){
	if(confirm("Esta seguro que desea guardar la entrega ?"))
	{
	
	$.ajax({
					  type: 'POST',
					  url: 'ventas/g_entrega.php',					  
					  data:"idnota_remision="+id,
					  cache:false,
					  error:function(XMLHttpRequest, textStatus, errorThrown){
						  console.log(arguments);
						  var error;
						  if (XMLHttpRequest.status === 404) error="Pagina no existe"+XMLHttpRequest.status;// display some page not found error 
						  if (XMLHttpRequest.status === 500) error="Error del Servidor"+XMLHttpRequest.status; // display some server error 
						  $('#'+donde).html('<div class="alert_error">'+error+'</div>');						  
					  },
					  success:function(msj){
						  
						 console.log("el msj g_entrega es = "+msj);
						 $('#descripcion_carrito').html(msj);
						 //reporteEntrega();
						  
						  
						  
					  }//fin success
			});//fin del ajax
	
		}//fin del if(confirm)
	}//fin del if (id!="")
	
	else 
	{
		alert("porfavor ponga un id nota de remision");
	}
}
	
	
	
	
	
	
	
	
	//*********************************************************************************************************
    //******************************** FIN DE CARRITO ENTREGA *************************************************
	//*********************************************************************************************************