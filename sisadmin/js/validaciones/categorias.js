$(document).ready(function() {


	$('#form_categoria').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			nombre: {
				message: 'nombre de Categor&iacute;a Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			descripcion: {
				message: 'Descripci&oacute;n de Categor&iacute;a Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			
			
		}
	});
	

	
	
	
	

	
	
});