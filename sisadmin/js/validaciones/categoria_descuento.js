$(document).ready(function() {


	$('#categoria_descuento').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			categoria: {
				message: 'Nombre de Categor&iacute;a Invalido ',
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