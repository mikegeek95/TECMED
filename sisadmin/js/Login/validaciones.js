$(document).ready(function() {
	$('#logeo').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			usuario: {
				message: 'nombre de usuario Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras y números'
					},
					stringLength : {
						min : 5,
						max : 25,
						message : 'Se necesitan entre 5 y 25 caracteres'
					}
				}
			},
			pass: {
				message: 'password  Invalido',
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					stringLength : {
						min : 5,
						max : 25,
						message : 'Se necesitan entre 5 y 25 caracteres'
					},
				}
			}
		}
	});
	
	//formulario insercion CVacantes (modal nueva petición)
	$('#new').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		excluded: [':disabled'],
		fields:{
			m_nombre: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					 regexp: {
						 regexp:  /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\t\s]+$/,
						 message:'Este campo solo admite letras'
					},
					stringLength : {
						min : 3,
						max : 50,
						message : 'Se necesitan entre 3 y 50 caracteres'
					}
				}
			},
			m_email: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					regexp: {
						regexp: /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{3,6})$/,
						 message:'nombre@example.extencion'
					}
				}
			},
			m_select: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					}
				}
			},
			m_cant: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					}
				}
			},
			m_des: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					stringLength : {
						min : 3,
						max : 255,
						message : 'Se necesitan entre 3 y 50 caracteres'
					}
				}
			}
			
		}
	});
	
	
	
	
	//formulario modificaciones status (modal status)
	$('#mstatus').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		excluded: [':disabled'],
		fields:{
			s_nombre: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\t\s]+$/,
						 message:'Este campo solo acepta letras y espacios'
					},
					stringLength : {
						min : 3,
						max : 50,
						message : 'Se necesitan entre 3 y 50 caracteres'
					}
				}
			},
			s_select: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					}
				}
			},
			s_des: {
				validators: {
					notEmpty: {
						message: 'Campo requerido'
					},
					stringLength : {
						max : 255,
						message : 'Solo se permiten 255 caracteres'
					}
				}
			}
		}
	});
	
	
});