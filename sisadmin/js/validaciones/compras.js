$(document).ready(function() {


	$('#modificar_compras').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			descripcion: {
				message: 'Descripcion de Compra Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ,.0-9]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			fecha_c: {
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