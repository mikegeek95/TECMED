$(document).ready(function() {


	$('#form_paciente').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			v_f_nacimiento: {
				message: 'Nombre de Paciente Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 
				}
			},
			v_nombre: {
				message: 'Nombre de Paciente Invalido ',
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
			v_paterno: {
				message: 'Apellido Paterno de Paciente Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras. '
					}
				}
			},
			v_materno: {
				message: 'Apellido Materno de Paciente Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras. '
					}
				}
			},
			v_direccion: {
				message: 'Direcci&oacute;n de Paciente Invalido. ',
				validators: {
					notEmpty: {
						message: 'Campo requerido,. '
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .,#]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros. '
					}
				}
			},
			v_telefono: {
				message: 'Tel&eacute;fono de Paciente Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido. '
					},
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					},
					stringLength : {
						min : 10,
						max : 10,
						message : 'Se necesitan de 10 caracteres. '
					}
				}
			},
			v_email: {

			 validators: {

				 notEmpty: {

					 message: 'El correo es requerido y no puede ser vacio'

				 },

				 emailAddress: {

					 message: 'El correo electronico no es valido'

				 }

			 }

		 },
		 v_fis_razonsocial: {
				message: 'Raz&oacute;n Social de Paciente Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras. '
					}
				}
			},
			v_fis_rfc: {
				message: 'RFC de Paciente Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros. '
					}
				}
			},
			v_fis_direccion: {
				message: 'Direcci&oacute;n Fiscal de Paciente Invalido. ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .,#]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros. '
					}
				}
			},
			v_fis_no_int: {
				message: 'N&uacute;mero Interior Invalido. ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
				}
			},
			v_fis_no_ext: {
				message: 'N&uacute;mero Exterior Invalido. ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					}
				}
			},
			v_fis_ciudad: {
				message: 'Ciudad Fiscal de Paciente Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
				v_fis_estado: {
				message: 'Estado Fiscal de Paciente Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
				},
				v_fis_col: {
				message: 'Colonia Fiscal de Paciente Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			v_fis_cp: {
				message: 'C&oacute;digo Postal Fiscal de Paciente Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					},stringLength : {
						min : 5,
						max : 5,
						message : 'Se necesitan de 5 caracteres'
					}
				}
			},
		}
	});
	

	
	
	
	

	
	
});