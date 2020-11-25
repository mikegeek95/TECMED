$(document).ready(function() {


	$('#form_producto').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			
			idproducto: {
				message: 'C&oacute;digo de Producto Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite N&uacute;meros. '
					}
				}
			},
			cod_proveedor: {
				message: 'C&oacute;digo de Proveedor Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo admite letras y N&uacute;meros. '
					}
				}
			},
			nombre: {
				message: 'Nombre de Producto Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras. '
					}
				}
			},
			p_costo: {
				message: 'Costo de Producto Invalido. ',
				validators: {
					notEmpty: {
						message: 'Campo requerido,. '
					},
					 regexp: {
						 regexp:  /^[0-9.]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
				}
			},
			p_venta: {
				message: 'Venta de Producto Invalido. ',
				validators: {
					notEmpty: {
						message: 'Campo requerido,. '
					},
					 regexp: {
						 regexp:  /^[0-9.]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
				}
			},
			v_descuento: {
				message: 'Descuento de Producto Invalido. ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
				}
			},
			v_stock: {
				message: 'Minimo de Producto Invalido. ',
				validators: {
					notEmpty: {
						message: 'Campo requerido,. '
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
				}
			},
			descripcion: {
				message: 'Ciudad Fiscal de Producto Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .,]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
				
				
			
		}
	});
	

	
	
	
	

	
	
});