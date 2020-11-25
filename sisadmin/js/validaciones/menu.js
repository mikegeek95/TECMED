$(document).ready(function() {


	$('#alta_menu').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			nombre: {
				message: 'Nombre de men&uacute; Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			archivo: {
				message: 'Nombre de archivo Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ._]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			ubi: {
				message: 'Ubicaci&oacute;n Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ/]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			nivel: {
				message: 'N&uacute;mero  Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros '
					}
				}
			},
			icono: {
				message: '&Iacute;cono  Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZáéíóúÁÉÍÓÚ -]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			
			
		}
	});
	

	
	
	
	

	
	
});