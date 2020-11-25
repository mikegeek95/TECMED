$(document).ready(function() {


	$('#f_configuracion').bootstrapValidator({
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			v_nombre_empresa: {
				message: 'Nombre de Empresa Invalido ',
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
			v_direccion: {
				message: 'Direcci&oacute;n de Empresa Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .,]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros '
					}
				}
			},
			v_horario: {
				message: 'Horario de Empresa Invalido ',
				validators: {
					notEmpty: {
						message: 'Campo requerido '
					},
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .:]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros '
					}
				}
			},
			v_telefono: {
				message: 'N&uacute;mero de Empresa Invalido ',
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
			v_email: {

			 validators: {

				 notEmpty: {

					 message: 'El correo es requerido y no puede ser vacio '

				 },

				 emailAddress: {

					 message: 'El correo electronico no es valido '

				 }

			 }

		 },
			v_email_pedido: {

			 validators: {

				 notEmpty: {

					 message: 'El correo es requerido y no puede ser vacio '

				 },

				 emailAddress: {

					 message: 'El correo electronico no es valido '

				 }

			 }

		 },
		 v_url: {
				message: 'URL de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ./:!"#$%&()=_¿?'¡|°¬,; -]+$/,
						 message:'Este campoo admite letras, n&uacute;meros y caracteres especiales'
					}
				}
			},
			 v_pass_caja: {
				message: 'URL de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campoo admite letras, n&uacute;meros '
					}
				}
			},
			v_facebook: {
				message: 'URL de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ./:!"#$%&()=_¿?'¡|°¬,; -]+$/,
						 message:'Este campoo admite letras, n&uacute;meros y caracteres especiales '
					}
				}
			},
			v_instagram: {
				message: 'URL de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ./:!"#$%&()=_¿?'¡|°¬,; -]+$/,
						 message:'Este campoo admite letras, n&uacute;meros y caracteres especiales '
					}
				}
			},
			v_twiter: {
				message: 'URL de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ./:!"#$%&()=_¿?'¡|°¬,; -]+$/,
						 message:'Este campoo admite letras, n&uacute;meros y caracteres especiales '
					}
				}
			},
			v_youtube: {
				message: 'URL de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ./:!"#$%&()=_¿?'¡|°¬,; -]+$/,
						 message:'Este campoo admite letras, n&uacute;meros y caracteres especiales '
					}
				}
			},
		 v_iva: {
				message: 'IVA de Empresa Invalido ',
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
			v_razonsocial: {
				message: 'Raz&oacute;n Social de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			v_rfc: {
				message: 'RFC de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros '
					}
				}
			},
			v_dfiscal: {
				message: 'Direcci&oacute;n Fiscal de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .,]+$/,
						 message:'Este campo solo admite letras y n&uacute;meros '
					}
				}
			},
			v_nint: {
				message: 'N&uacute:mero Interior Fiscal de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros '
					}
				}
			},
			v_next: {
				message: 'N&uacute:mero Exterior Fiscal de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9]+$/,
						 message:'Este campo solo admite n&uacute;meros '
					}
				}
			},
			v_ciudad: {
				message: 'Ciudad Fiscal de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
				v_estado: {
				message: 'Estado Fiscal de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
				},
				v_colonia: {
				message: 'Colonia Fiscal de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/,
						 message:'Este campo solo admite letras '
					}
				}
			},
			v_cp: {
				message: 'C&oacute;digo Postal Fiscal de Empresa Invalido ',
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
			v_cuentas: {
				message: 'Cuentas de Empresa Invalido ',
				validators: {
					
					 regexp: {
						 regexp:  /^[0-9 ]+$/,
						 message:'Este campo solo admite n&uacute;meros. '
					},
				}
			},
			
		}
	});
	

	
	
	
	

	
	
});