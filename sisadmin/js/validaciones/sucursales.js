$(document).ready(function() {


	$('#alta_sucursales').bootstrapValidator({
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
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			direccion: {
				message: 'nombre de usuario Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ , .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			tel: {
				message: 'nombre de usuario Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros '
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

		 }
		}
	});
	

	
	
	
	

	
	
});