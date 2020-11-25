$(document).ready(function() {


	$('#f_gasto').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			v_descripcion: {
				message: 'Descripcion de Compra Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ,.0-9]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			v_monto: {
				message: 'Monto de Gasto Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[,.0-9]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			v_fechaingreso: {
				message: 'Fecha Invalida ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 
				}
			},
			
			
		}
	});
	

	
	
	
	

	
	
});