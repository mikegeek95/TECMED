$(document).ready(function() {


	$('#form_subcategoria').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			nombre: {
				message: 'nombre de Subcategor&iacute;a Invalido ',
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
			comentario: {
				message: 'Descripci&oacute;n de Subcategor&iacute;a Invalido ',
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