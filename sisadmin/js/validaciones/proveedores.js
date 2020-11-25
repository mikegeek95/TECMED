$(document).ready(function() {


	$('#proveedor').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			nombre: {
				message: 'Nombre de Proveedor Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/,
						 message:'Este campo solo admite letras. '
					}
				}
			},
			direccion: {
				message: 'Direcci&oacute;n de Proveedor Invalido. ',
				validators: {
					notEmpty: {
						message: 'Campo requerido,. '
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .,#]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros. '
					}
				}
			},
			telefono: {
				message: 'Tel&eacute;fono de Proveedor Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					},
					stringLength : {
						min : 10,
						max : 10,
						message : 'Se necesitan de 10 caracteres. '
					}
				}
			},
			email: {

			 validators: {

				 notEmpty: {

					 message: 'El correo es requerido y no puede ser vacio'

				 },

				 emailAddress: {

					 message: 'El correo electronico no es valido'

				 }

			 }

		 },
		 contacto: {
				message: 'Contacto de Proveedor Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras. '
					}
				}
			},
			url: {
				message: 'URL de Proveedor Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ./:!"#$%&()=_¿?'¡|°¬,; -]+$/,
						 message:'Este campoo admite letras, n&uacute;meros y caracteres especiales'
					}
				}
			}
		}
	});
	

	
	
	
	

	
	
});