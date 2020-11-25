$(document).ready(function() {


	$('#usuarios').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			nombre: {
				message: 'nombre de usuario Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			paterno: {
				message: 'nombre de usuario Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			materno: {
				message: 'nombre de usuario Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras '
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
			usuario: {
				message: 'nombre de usuario Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros'
					},stringLength : {
						min : 6,
						message : 'Se necesitan un minimo de 6 caracteres'
					}
				}
			},
			clave: {
				message: 'password  Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					}
					,stringLength : {
						min : 6,
						message : 'Se necesitan un minimo de 6 caracteres'
					}
				}
			},
			celular: {
				message: 'nombre de usuario Invalido',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
					,stringLength : {
						min : 10,
						max : 10,
						message : 'Se necesitan de 10 caracteres'
					}
				}
			},
			telefono: {
				message: 'nombre de usuario Invalido',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
					,stringLength : {
						min : 10,
						max : 10,
						message : 'Se necesitan de 10 caracteres'
					}
				}
			},
		}
	});
	

	
	
	
	

	
	
});