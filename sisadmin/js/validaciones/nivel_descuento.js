$(document).ready(function() {


	$('#nivel_descuento').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			nivel: {
				message: 'Nombre de Nivel Invalido ',
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
			
			
		}
	});
	

	
	
	
	

	
	
});