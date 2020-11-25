$(document).ready(function() {


	$('#form_cat_gastos').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{

			v_gasto: {
				message: 'Nombre de Cat. de Gasto Invalido ',
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
			v_descripcion: {
				message: 'Descripci&oacuten de Cat. de Gasto Invalido ',
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

		}
	});
	

	
	
	
	

	
	
});