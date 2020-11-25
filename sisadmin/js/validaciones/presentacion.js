$(document).ready(function() {


	$('#form_presentacion').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			talla: {
				message: 'nombre de Categor&iacute;a Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite letras N&uacute;meros'
					}
				}
			},
			descripcion: {
				message: 'Descripci&oacute;n de Categor&iacute;a Presentaci&oacute; ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras y N&uacute;meros'
					}
				}
			},
			
			
		}
	});
	

	
	
	
	

	
	
});