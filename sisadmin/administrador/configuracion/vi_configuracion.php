<?php
  
   require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

   
   require_once("../../clases/conexcion.php");
   require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Funciones.php");

	
   $db = new MySQL();
   $conf = new Configuracion();
$f=new Funciones();
    
   $conf->db = $db;
   
   
 try{  
   
   $row_configuracion = $conf->ObtenerInformacionConfiguracion();


   if($row_configuracion['cuantos'] == 0)
      {
		  $id = 0;
		  $iva = 50;
	  }else
	  {
		  $id =  $row_configuracion['idconfiguracion'];
		  $iva = $row_configuracion['iva'];
	   }
   
   


?>
<meta name="viewport" content="width=device-width, initial-scale=1">



  
<form name="f_configuracion" id="f_configuracion">
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;">CONFIGURACI&Oacute;N DE TU EMPRESA</h5>
		</div>
		
		<div class="card-body" style="padding-left: 0; padding-right: 0;">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Datos Generales</span></a> </li>
				<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Datos Fiscales</span></a> </li>
				<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Configuraci&oacute;n Tienda</span></a> </li>
				
				
				
			</ul>
			<!-- Tab panes -->
			
			
			<div class="tab-content tabcontent-border" style="padding-left: 15px; padding-right: 15px;">
			<br>
				<div class="tab-pane active" id="home" role="tabpanel">
					<div class="form-group m-t-20">
						<div class="row">
						<div class="col-6">
						<label>Nombre Empresa</label>
						<input name="v_nombre_empresa" type="text" id="v_nombre_empresa" class="form-control" title="Nombre de Empresa" value="<?php echo  $f->imprimir_cadena_utf8 ($row_configuracion['nombre_empresa']); ?>">
						</div>
						<div class="col-6">
							<div class="form-group ">
											<label>Horario:</label>
											<input type="text" class="form-control" id="v_horario" name="v_horario" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['horario']); ?>" title="HORARIO">
								</div>
										</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Direccion</label>
								<input name="v_direccion" type="text" id="v_direccion" title="Direccion" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['direccion']);?>">
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Telefono</label>
								<input name="v_telefono" type="text" id="v_telefono" class="form-control" title="Telefono" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['telefonos']);?>">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>P&aacute;gina Web</label>
								<input name="v_url" type="text" id="v_url" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['url']);?>">
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Email</label>
								<input name="v_email" type="text" id="v_email" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['email']);?>">
							</div>
						</div>
					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Contrase&ntilde;a Caja</label>
								<input name="v_pass_caja" type="password" id="v_pass_caja" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['clave_caja']);?>">
							</div>	
						</div>

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Email (Envio de Pedidos)</label>
								<input name="v_email_pedido" type="text" id="v_email_pedido" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['email_pedido']);?>">
							</div>
						</div>
						
						
						
						<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
							<div class="form-group m-t-20">
											<label>FACEBOOK:</label>
								<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class="fab fa-facebook-square"></i></span>
												  </div>
											<input type="text" class="form-control" id="v_facebook" name="v_facebook" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['facebook']); ?>" title="FACEBOOK">
								</div></div>
										</div>
											
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
											<div class="form-group m-t-20">
											<label>INSTAGRAM:</label>
												<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class="fab fa-instagram"></i></span>
												  </div>
											<input type="text" class="form-control" id="v_instagram" name="v_instagram" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['instagram']); ?>" title="INSTAGRAM">
											</div>	</div>
										</div>
												
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
											<div class=" form-group m-t-20">
											<label>TWITTER:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class="fab fa-twitter"></i></span>
												  </div>
											<input type="text" class="form-control" id="v_twiter" name="v_twiter" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['twitter']) ?>" title="TWITER">
											</div>	</div>
										</div>
										
										
										<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
											<div class="form-group m-t-20">
											<label>YOUTUBE:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class="fab fa-youtube"></i></span>
												  </div>
											<input type="text" class="form-control" id="v_youtube" name="v_youtube" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['youtube']); ?>" title="YOUTUBE">
												</div></div>
										</div>

					</div>

				</div>


				<div class="tab-pane  p-20" id="profile" role="tabpanel">
					<br>
					<div class="form-group m-t-20">
						<label style="width:92%;">IVA</label>
						 <!--<div class="clear"></div>-->
						 <input name="v_iva" type="text" id="v_iva" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['iva']);?>" >
						 <!--<div id="slider-range-max" style="width:72%; float:left"></div>-->
					</div>

					<div class="form-group m-t-20">
						<label>Raz&oacute;n Social</label>
						<input name="v_razonsocial" type="text" id="v_razonsocial" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['razon_social']);?>">
					</div>

					<div class="form-group m-t-20">
						<label>RFC</label>
						<input name="v_rfc" type="text" id="v_rfc" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['rfc']);?>">
					</div>

					<div class="form-group m-t-20">
						<label>Direcci&oacute;n Fiscal</label>
						<textarea name="v_dfiscal" rows="2" class="form-control" id="v_dfiscal"><?php echo $f->imprimir_cadena_utf8($row_configuracion['direccion_fiscal']);?></textarea>
					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>No. Interior.</label>
								<input name="v_nint" type="text" id="v_nint" class="form-control"  value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['no_int_fiscal']);?>">
							</div>	
						</div>

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>No. Exterior</label>
								<input name="v_next" type="text" id="v_next" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['no_ext_fiscal']);?>">
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Ciudad</label>
								<input name="v_ciudad" type="text" id="v_ciudad" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['ciudad_fiscal']);?>">
							</div>	
						</div>

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Estado</label>
								<input name="v_estado" type="text" id="v_estado" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['estado_fiscal']);?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>Colonia</label>
								<input name="v_colonia" type="text" id="v_colonia" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['colonia_fiscal']);?>">
							</div>	
						</div>

						<div class="col-md-6">
							<div class="form-group m-t-20">
								<label>CP</label>
								<input name="v_cp" type="text" id="v_cp" class="form-control" value="<?php echo $f->imprimir_cadena_utf8($row_configuracion['cp_fiscal']);?>">
							</div>
						</div>

					</div>

				</div>

				<div class="tab-pane p-20" id="messages" role="tabpanel" align="center">
				<br>
					<div class="form-group m-t-20">
						<label style="width:92%;">LOGO DE LA EMPRESA</label>
						<div id="d_logo" style="text-align:center">
	<?php
						if($row_configuracion['logo'] != "")
						{
							$imagen = "images/configuracion/".$row_configuracion['logo'];
						}else{
							$imagen = "images/logoempresa.png";
						}
	?>
							<img src="<?php echo $imagen; ?>" width="150" height="150" alt="" style="border: 1px #707070 solid"/> 
						</div>

						<p style="text-align:center;">&nbsp;&nbsp;Dimensiones de la imagen Ancho: 150px Alto: 150px</p>   
						<div class="spacer"></div>
						<input type="file" id="v_logo" name="v_logo[]" accept="image/png">
					</div>

					<!--<div class="form-group m-t-20">
						<label>TIPO DESCUENTO</label>
						<select disabled name="v_tipo_descuento" id="v_tipo_descuento" class="form-control" >
							<option selected value="0" <?PHP if($row_configuracion['t_descuento'] == 0){ echo "selected" ;}?> >Por Producto</option>
							<option value="1" <?PHP if($row_configuracion['t_descuento'] == 1){ echo "selected" ;}?>>Por Paquete de Compra</option>
							<option value="2" <?PHP if($row_configuracion['t_descuento'] == 2){ echo "selected" ;}?>>Ambos</option>
						</select>
					</div>-->

					<div class="form-group m-t-20">
						<label>Cuentas Bancarias</label>
						<textarea name="v_cuentas" rows="6" class="form-control" id="v_cuentas"><?php echo $f->imprimir_cadena_utf8($row_configuracion['cuentasbancarias']);?></textarea>
					</div>

					<div class="form-group m-t-20">
						<label>Moneda</label>
						 <select name="v_moneda" id="v_moneda" class="form-control">
						   <option value="MNX" <?PHP if($f->imprimir_cadena_utf8($row_configuracion['moneda']) == 'MNX'){ echo "selected" ;}?>>PESOS</option>
						   <option value="DLL" <?PHP if($f->imprimir_cadena_utf8($row_configuracion['moneda']) == 'DLL'){ echo "selected" ;}?>>USD</option>
						 </select>
					</div>

				</div>



				
				
			</div>
			
		</div>
		
		<div class="card-footer text-muted">
			<input name="v_id" type="hidden" value="<?php echo $id; ?>" id="v_id">
			<button type="button" onClick="g_Configuracion('f_configuracion');" class="btn btn-outline-success alt_btn" style="float: right;" ><i class="far fa-save"></i> GUARDAR</button>
	  	</div>
	</div>
</form>
    
<?php
 }//fin del try
 catch(Exception $e)
 {
	 $v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
	 
	 
 }

?>

<script type="text/javascript"	src="js/validaciones/configuracion.js"></script>