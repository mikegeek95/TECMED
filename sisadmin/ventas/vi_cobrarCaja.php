<?php
/*==============================*
 *	Proyecto: CALZADO DAYANARA	*
 *	Compañia: CAPSE				*
 *	Ult. Mod: 19/02/2019		*
 *	Developer: ISC JOSE CARLOS	*
 *	SANTILLAN MONTESINOS.		* 
 *==============================*/

//Validamos la sesión activa
//=========================================================//
	//Importamos clase de manejo de sesiones
	require_once("../clases/class.Sesion.php");
	//Declaramos el objeto de la clase de sesión
   	$se = new Sesion();
//=========================================================//

	//Importamos las clases a utilizar
   	require_once("../clases/conexcion.php");
   	require_once("../clases/class.Caja.php");
	require_once("../clases/class.Clientes.php");

	//Declaramos objetos de clases
	$db = new MySQL();
	$caja = new Caja();
	$cl = new Clientes();

	//Enviamos objeto de conexión a las clases que lo requieren
	$caja->db = $db;
	$cl->db = $db;


   	//Recibimos los parametros y los almacenamos en variables
	$idorden = $_POST['idNotaremision'];
   	$validacion = $_POST['validacion'];

	//Enviamos el id del pedido a la clase de cajas para obtener los datos del pedido
   	$caja->idnota_remision = $idorden;   
   	$datos = $caja->obtenerDatosPedido();   
   	$total = $datos['total'];
   	$idcliente = $datos['idcliente'];
   	$desc_producto = $datos['desc_producto']; 
   
   	//Obtenemos el maximo a pagar con dinero electronico
   	$max_pago = round(($total/2),2);
   
   	//Validamos que sea un cliente
   	if($idcliente != 0){
   		//Obtenemos datos del cliente
	   	$cl->idCliente = $idcliente;
	   	$result_cliente = $cl->ObtenerInformacionCliente();
	   
	   	$Nombre = utf8_encode($result_cliente['nombre'])." ".utf8_encode($result_cliente['paterno'])." ".utf8_encode($result_cliente['materno']).".";
	   	$idniveles = $result_cliente['idniveles'];
	   	$saldo_monedero = $result_cliente['saldo_monedero'];
	   
		//Obtenemos el nombre del nivel que tiene el cliente
		$sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
		$result = $db->consulta($sql);
	   	$result_row = $db->fetch_assoc($result);
	   
	   	$nivel = "Nivel: ".utf8_encode($result_row['nombre']).".";
	   
	   	//Obtenemos la matriz de precios de las categorias del nivel del cliente.
		$sql2 = "SELECT cp.nombre as nombre, cpn.descuento as descuento, cpn.idniveles FROM categoria_precios_niveles cpn, categoria_precio cp WHERE cpn.idniveles = '$idniveles' AND cp.idcategoria_precio = cpn.idcategoria_precio";
	   	$result_desc = $db->consulta($sql2);
	   	$result_desc_row = $db->fetch_assoc($result_desc);
	   	$result_desc_num = $db->num_rows($result_desc);
	   
	   	$categoria = "";
	   	$descuento = "";
	   	//Llenamos las variables categoria y descuento
	   	do
	   	{
		   	if($categoria == ""){
			   	$categoria = utf8_encode($result_desc_row['nombre']);
			   	$descuento = utf8_encode($result_desc_row['descuento']);
		   	}else{
			   	$categoria = $categoria.",".utf8_encode($result_desc_row['nombre']);
			   	$descuento = $descuento.",".utf8_encode($result_desc_row['descuento']);
		   	}
	   	}while($result_desc_row = $db->fetch_assoc($result_desc));
	   
	   	$cat = explode(",",$categoria);
	   	$des = explode(",",$descuento);
	   
		$tamano = sizeof($cat);	   
   	}else{
	   	$Nombre = "Publico General.";
   	}
       
	if($validacion == 0){
		$disabled = "disabled";
	}else{
		$disabled = "";
	}	
	
	if($validacion != 0){

?>
		<script type="text/javascript">
			$('#d_directo').focus();
		</script>
<?php
	}
?>


<script type="text/javascript">
	/*$('#inputs_tarjeta').hide();
	$('#inputs_transferencia').hide();
	$('#inputs_deposito').hide();
	$('#inputs_cheque').hide();
	//$('#show').addClass('show');
	
	/*$('#show').click(function(){
		if($(this).hasClass('show')){
			$('#inputs_tarjeta').fadeIn();
			$('#inputs_transferencia').fadeIn();
			$('#inputs_deposito').fadeIn();
			$('#inputs_cheque').fadeIn();
			
			//$('#show').removeClass('show');
			//$('#show').addClass('remove');
			
			$('#show').css("background-image","url('images/arrow-up.png')");
			
		}else{
			$('#inputs_tarjeta').fadeOut();
			$('#inputs_transferencia').fadeOut();
			$('#inputs_deposito').fadeOut();
			$('#inputs_cheque').fadeOut();
			
			//$('#show').removeClass('remove');
			//$('#show').addClass('show');
			
			//$('#show').css("background-image","url('images/arrow.png')");
		}
	});*/
</script>

<!-- ============================================== INICIA CONTENEDOR DE MODAL SECUNDARIA ===================================================== -->

<div id="ModalSecundaria" class="ventana">
	<div id="Close" style="text-align: right">
      <img src="images/004.png" width="16" height="16" onClick="$('#ModalSecundaria').css('display','none'); $('#contenido_modal_dos').html('');" style="cursor:pointer">
	</div>
	
    <div id="contenido_modal_dos" ></div>
</div>

<!-- ============================================== TERMINA CONTENEDOR DE MODAL SECUNDARIA ===================================================== -->


<!-- ============================================== INICIA SECCION DE CAJA ===================================================== -->
<div class="row">
	<!-- Inician datos generales de pedido -->
	<div class="col-md-12" style="border-bottom: 1px solid #eaeaea; margin-bottom: 10px; padding-bottom: 10px;">
		<!-- inicia alert # pedido -->
		<div style="width:250px;float:left; padding: 8px;" class="alert-success" id="mens">
			<i class="mdi mdi-check" style="margin-right: 10px;"></i> 
			No. de Pedido <?php echo $idorden; ?>
		</div>
		<!-- termina alert # pedido -->
		
		
		<!-- inicia tabla de descuentos -->
		<div style=" float:left;  text-align:left; display: none;">
  		<?php
		if($result_desc_num != 0){ 
		?>
  			<span style="color:#F00;">DESCUENTOS POR CATEGOR&Iacute;A</span>
			<table style="text-align:center; border-collapse: collapse;">
				<tbody>
					<tr>
						<!--<td>CATEGORIA</td>-->
						<?php
						for($x=0;$x<$tamano;$x++){ 
						?>
							<td style="border:solid 1px #000; padding:3px;"><?php echo $cat[$x]; ?></td>
						<?php
						}
						?>
					</tr>

					<tr>
						<!--<td>DESCUENTO</td>-->
						<?php
						for($x=0;$x<$tamano;$x++){ 
						?>
							<td style="border:solid 1px #000;"><?php echo $des[$x]."%"; ?></td>
						<?php
						}
						?>
					</tr>
				</tbody>
			</table>
		<?php
		}
		?>
		</div>
		<!-- termina tabla de descuentos -->
		
		
		<!-- inician totales de pedido -->
		<div  style="font-size:14px; color:# 666; text-align:right; display:block; font-weight: bold;">
			<input name="v_monto" type="hidden" id="v_monto" value="<?php echo $total; ?>" />
		 	<input name="v_monto2" type="hidden" id="v_monto2" value="<?php echo $total; ?>" />
			Monto: $ <span id="e_monto" style="width:70px;float:right; font-size:13px"><?php echo number_format(($total+$desc_producto),2,'.',','); ?></span>
	  	</div>
		<div  style="font-size:14px; color:# 666; margin-top:9px; text-align:right; display:block; font-weight: bold;">
			Descuento: $ <span id="e_monto" style="width:70px;float:right; font-size:13px"><?php echo number_format($desc_producto,2,'.',','); ?></span>
		</div>
		<div style="clear:both;"></div>
		<div style=" float:left; margin-top:10px; margin-left:20px; text-align:left; font-size:14px; font-weight: bold;">
  			<span>Cliente: <?php echo $Nombre; ?></span><br>
    		<?php
			if($idniveles != 0){ 
			?>
    			<span><?php echo $nivel; ?></span><br>
    		<?php
			}
			?>  
			<?php
			if($idcliente != 0){
			?>
				<span>Saldo Electr&oacute;nico: $ <?php echo $saldo_monedero; ?></span>
				<input type="hidden" id="val_mon" value="<?php echo $saldo_monedero; ?>" />
			<?php
			}
			?>
  		</div>
		<div  style="font-size:15px; color:#F00; text-align:right; float:right; display:none;">
			PORC. DIRECTO:  &nbsp;
			<span style="float: right">
				<select name="v_porcentaje_dd" id="v_porcentaje_dd" style="width:90px;" onchange="DescuentoPorcentaje();" class="">
					   <option value="0">NINGUNO</option>
					   <option value=".1">10%</option>
					   <option value=".15">15%</option>
					   <option value=".20">20%</option>
					   <option value=".30">30%</option>
					   <option value=".38">38%</option>
					   <option value=".50">50%</option>
					   <option value=".55">55%</option>
				</select>
			</span>   	
		</div>
		
		<div  style="font-size:14px; color:#F00; margin-top:5px; text-align:right; float:right; width:auto; font-weight: bold;">
    		DESC. DIRECTO: $ &nbsp;
    		<span>
    			<a onDblClick="irClaveDesc('<?php echo $idorden; ?>')">
    				<input <?php echo $disabled; ?> style="width:70px;float:right; text-align:right; font-weight:bold" value="0.00" id="d_directo" onBlur="document.getElementById('d_directo').disabled = true;" onChange="document.getElementById('d_directo').disabled = true;" onkeyup="validaFloat(); calcular_caja();"/>
        		</a>
     		</span>   
    	</div>
		
		<div  style=" clear:both;font-size:14px; color:#F00; text-align:right; font-weight: bold;">
     		TOTAL: $ <span id="e_total" style="width:70px;float:right;"><?php echo number_format($total,2,'.',','); ?></span>
    	</div>
		
	</div>
	<!-- terminan datos generales de pedido -->
	
	<!-- inicia formulario de caja para cobro de pedido -->
	
	<div class="col-md-12" id="d_formulario">
		<table width="100%" id="metodos_pago" border="0" cellspacing="0" cellpadding="2" class="tablesorter">	
        <?php
		if($saldo_monedero != 0){ 
		?>
       		<tr style="border-bottom: dashed 1px #eaeaea; padding: 7px;">
                <td width="28" align="center" ><input type="checkbox" name="v_electronico" id="chk6" value="" style="float:left" onClick="validar_Cobro(6);"></td>
                <td width="188" align="left" >M. ELECTR&Oacute;NICO $</td>
                <td width="203" align="center" >
                	<input name="v_monto_elec"  type="text" disabled="disabled" class="inputdesactivado" id="v_monto_elec"  placeholder="0.00" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar en dinero electr&oacute;nico" onkeyup="calcular_maximo('<?php echo $max_pago; ?>','<?php echo $saldo_monedero; ?>');calcular_caja();" onkeypress="ValidaSoloNumeros()" value="0">
                    
                    <input type="checkbox" name="v_validacion_elect" disabled id="v_validacion_elect" value="" style="float:left" onClick="$('#v_monto_elec').val('');if($('#v_validacion_elect').prop('checked')){irClaveMon('<?php echo $idorden; ?>');}else{$('#v_monto_elec').focus();}">
                </td>
                <td width="168" align="center" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="264" align="center" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="137" align="center" >&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        <?php
		}
		?>
            <!--<tr><td colspan="6">EFECTIVO $</td></tr>-->
			<tr style="border-bottom: dashed 1px #eaeaea;">
                <td width="28" align="center" >
					<input type="checkbox" name="v_efectivo" id="chk1" value="" style="float:left" onClick="validar_Cobro(1);">
				</td>
                <td width="188" align="left" >EFECTIVO $</td>
                <td width="203" align="center" >
                	<input name="v_monto_efect"  type="text" disabled="disabled" class="inputdesactivado" id="v_monto_efect"  placeholder="0.00" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" onkeyup="calcular_caja();" onkeypress="ValidaSoloNumeros()" value="0">
					<div style="width:20px; display: none; background-image:url('images/arrow.png'); background-repeat:no-repeat; background-size:20px 20px; float:left; height:20px; cursor:pointer; margin-left: 4px; margin-top: 4px;" id="show"></div>
				</td>
                <td width="168" align="left" >&nbsp;</td>
                <td width="264" align="center" >&nbsp;</td>
                <td width="137" align="center" >&nbsp;</td>
            </tr>
        
            <tr id="inputs_tarjeta">
                <td width="3%" align="center" ><input type="checkbox" name="v_tipo_tar" id="chk2" value="" style="float:left" onClick="validar_Cobro(2)"></td>
                <td width="23%" align="left" >TARJETA C/D $</td>
                <td width="24%" align="left" >
                    <select name="v_t_tarjeta" disabled class="inputdesactivado" id="v_t_tarjeta" style="width:90px">
                        <option value = "0">CREDITO</option>
                        <option value = "1">DEBITO</option>
                    </select>
                </td>
                <td width="19%" align="left"><input name="v_monto_tarjeta"  type="text"  disabled class="inputdesactivado" id="v_monto_tarjeta" placeholder="0.00" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar con tarjeta" onkeyup="calcular_caja();" value="0"></td>
                <td width="19%" align="center" >REFERENCIA DE PAGO Y  ULTIMOS DIGITOS</td>
                <td width="50%" align="center" >
                	<input name="v_num_tarjeta" type="text" disabled="disabled" id="v_num_tarjeta" placeholder="0" style="width: 96px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" class="inputdesactivado">
                    <input name="v_ultDigitos" type="text" disabled="disabled" id="v_ultDigitos" placeholder="0" style="width: 40px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" class="inputdesactivado">
                </td>
            </tr>
            
            
            <tr id="inputs_transferencia">
                <td width="3%" align="center" ><input type="checkbox" name="v_efectivo" id="chk3" value="" style="float:left" onClick="validar_Cobro(3)"></td>
                <td width="23%" align="left" >TRANSFERENCIA $</td>
				<td width="24%" align="left" > 
					<select name="banco_transfer" disabled class="inputdesactivado" id="banco_transfer" style="width:90px">
                       	<option value="">Seleccionar banco</option>
						<option value="Banorte">Banorte</option>
						<option value="Bancomer">Bancomer</option>
						<option value="HSBC">HSBC</option>
						<option value="Banamex">Banamex</option>
                        <option value="Coppel">Coppel</option>
                        <option value="Coppel">Santander</option>
                    </select>                   
                </td>
                <td width="24%" align="center" ><input name="v_monto_transfer" type="text" disabled="disabled" class="inputdesactivado" id="v_monto_transfer" placeholder="0.00" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" onkeyup="calcular_caja();" value="0"></td>
                <td width="19%" align="left" >REFERENCIA Y NO. TRANSF.</td>
                <td width="31%" align="center" >
					<input name="v_ref_trasnfer" type="text" disabled="disabled" id="v_ref_trasnfer" placeholder="0" style="width: 90px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" class="inputdesactivado">
					<input name="v_no_transfer" type="text" disabled="disabled" id="v_no_transfer" placeholder="0" style="width: 90px; float:left; text-align:right;" title="No. Transferencia" class="inputdesactivado">
                </td>
                <td width="31%" align="center" >&nbsp;</td>
            </tr>
            <tr id="inputs_deposito">
                <td width="3%" align="center"  ><input type="checkbox" name="v_efectivo" id="chk4" value="" style="float:left" onClick="validar_Cobro(4)"></td>
                <td width="23%" align="left" >DEPOSITO $</td>
				<td width="24%" align="left" > 
					<select name="banco_deposito" disabled class="inputdesactivado" id="banco_deposito" style="width:90px">
                       	<option value="">Seleccionar banco</option>
						<option value="Banorte">Banorte</option>
						<option value="Bancomer">Bancomer</option>
						<option value="HSBC">HSBC</option>
						<option value="Banamex">Banamex</option>
                        <option value="Coppel">Coppel</option>
                        <option value="Coppel">Santander</option>
                    </select>                   
                </td>
                <td width="24%" align="center" ><input name="v_monto_depo" type="text" disabled="disabled" class="inputdesactivado" id="v_monto_depo" placeholder="0.00" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" onkeyup="calcular_caja();" value="0"></td>
                <td width="19%" align="left" >REFERENCIA Y NO. DEPOSITO</td>
                <td width="31%" align="center" >
					<input name="v_ref_depo" type="text" disabled="disabled" id="v_ref_depo" placeholder="0" style="width: 90px; float:left; text-align:right;" title="Cantidad a pagar en efectivo"  class="inputdesactivado">
					<input name="v_no_depo" type="text" disabled="disabled" id="v_no_depo" placeholder="0" style="width: 90px; float:left; text-align:right;" title="Cantidad a pagar en efectivo"  class="inputdesactivado">
				</td>
                
            </tr>
            
            <tr id="inputs_cheque">
                <td width="3%" align="center" ><input type="checkbox" name="v_efectivo" id="chk5" value="" style="float:left" onClick="validar_Cobro(5)"></td>
                <td width="23%" align="left" >CHEQUE $</td>
                <td width="24%" align="center" ><input name="v_monto_cheque" type="text" disabled="disabled" class="inputdesactivado" id="v_monto_cheque" placeholder="0.00" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" onkeyup="calcular_caja();" value="0"></td>
                <td width="19%" align="left" >REFERENCIA CHEQUE</td>
                <td width="31%" align="center" ><input name="v_trans_cheque" type="text" disabled="disabled" id="v_trans_cheque" placeholder="0" style="width: 80px; float:left; text-align:right;" title="Cantidad a pagar en efectivo" class="inputdesactivado"></td>
             	<td width="31%" align="center" >&nbsp;</td>
            </tr>
            
            
            <!--<tr>
                <td width="3%" height="39" align="center" >&nbsp;</td>
                <td width="19%" align="center" >&nbsp;</td>
                <td width="23%" align="left" >RECIB&Iacute; EL TOTAL DE:</td>
                <td width="24%" align="center" style=" font-size: 24px; color:#F00">$ <span id="v_sumatotal" >0.00 </span></td>
                <td width="19%" align="right" >&nbsp;</td>
                <td width="31%" align="center" > <div  style="font-size:18px; color:#090; text-align:right">
       CAMBIO: $ <span style="width:70px;float:right;" id="d_cambio">0.00</span>
    
    </div></td>
            </tr>-->
           <!-- <tr>
              <td align="center" >&nbsp;</td>
              <td align="center" >&nbsp;</td>
              <td align="left" >&nbsp;</td>
              <td align="right" >&nbsp;</td>
              <td align="right" >
            </tr>-->
            
        </table>
		
		<div style="width: 100%; padding: 8px;">
			<span style="float: left; margin-top: 11px; margin-right: 11px;">Comentarios:</span>
			<textarea style="width: 80%; " name="v_comentario" id="v_comentario"></textarea>
			
			<div style="clear: both;"></div>
		</div>
	</div>
	<!-- Termina formulario de caja para cobro de pedido -->
	
	<div class="col-md-12">
		<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tablesorter">
                
               		<tr>
                        <td width="3%" align="center" style="border:none;">&nbsp;</td>
                        <td width="23%" align="left" style="border:none;">&nbsp;</td>
                        <td width="24%" align="center" style="border:none;">&nbsp;</td>
                        <td width="19%" align="left" style="border:none;">&nbsp;</td>
                        <td width="31%" align="center" style="border:none;">&nbsp;</td>
                        <td width="31%" rowspan="2" align="center" style="padding: 10px;">     
                               <input name="v_idorden" id="v_idorden"  type="hidden" value="<?php echo $idorden; ?>" />
                         
                        <div id="btn_pagar" style="height:70px; width:200px; line-height:70px;" class="btn_gris" >
                            &nbsp;
                           Pagar
                        </div>
                        </td>
            		</tr>
                    
                    
                    <tr>
                        <td width="3%" align="center" >&nbsp;</td>
                        <td width="23%" align="left" >&nbsp;</td>
                        <td width="24%" align="center" >&nbsp;</td>
                        <td width="19%" align="left" >&nbsp;</td>
                        <td width="31%" align="center" >&nbsp;</td>
                        <td width="31%" align="center" >&nbsp;</td>
                    </tr>
                    
                	<tr>
                        <td width="27px" height="39" align="center" style="border:none;" >&nbsp;</td>
                        <td width="169px" align="center" style="border:none;" >RECIB&Iacute; EL TOTAL DE:</td>
                        <td width="190px" align="left"  style="border:none; font-size: 24px; color:#F00">$ <span id="v_sumatotal" >0.00 </span></td>
                        <td width="171px" align="center" style="  border:none; ">FALTA POR RECIBIR: </td>
                        <td width="192px" align="left" style="border:none; font-size: 24px; color:#F00">$ <span id="v_falta" >0.00 </span></td>
                        <td width="208px" align="center" style="border:none;"> <div  style="font-size:18px; color:#090; text-align:right">
               CAMBIO: $ <span style="width:70px;float:right;" id="d_cambio">0.00</span>
                        <input name="v_cambio" type="hidden" value="0.00" id="v_cambio" />
    
   		 				</div></td>
            		</tr>
                </table>
	</div>
	
	
</div>