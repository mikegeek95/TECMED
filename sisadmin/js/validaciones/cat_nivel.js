$(document).ready(function() {


	$('#cat_nivel').bootstrapValidator({
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
					}
				}
			},
			nivel: {
				message: 'Nombre de Categor&iacute;a Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					}
				}
			},
			descuento: {
				message: 'Nombre de Categor&iacute;a Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					}
				}
			},
			
		}
	});
	

	
	
	
	

	
	
});