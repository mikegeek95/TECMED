$(document).ready(function() {


	$('#form_paqueteria').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{

			v_nombre: {
				message: 'Nombre de Paqueter&iacute; Invalido ',
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
				message: 'Direcci&oacute;n de Paqueter&iacute; Invalido. ',
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
				message: 'Tel&eacute;fono de Paciente Invalido ',
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

			 },
			 

		 },
		 urlrastreo: {
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