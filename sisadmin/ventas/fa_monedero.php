 <?php
header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	//exit;
}

   require_once("../clases/conexcion.php");
   
   $db = new MySQL();
   
   $sql_cliente = "SELECT * FROM clientes WHERE estatus = '1' ORDER BY nombre, paterno, materno ASC";
   $result_cliente = $db->consulta($sql_cliente);
   $result_cliente_row = $db->fetch_assoc($result_cliente);
 


?>



<div id="ModalSecundaria" class="ventana">
<div id="Close" style="text-align: right">
      <img src="images/004.png" width="16" height="16" onClick="$('#ModalSecundaria').css('display','none'); $('#contenido_modal_dos').html('');" style="cursor:pointer">
</div>

    <div id="contenido_modal_dos" >
   
    </div>

</div>

<script type="text/javascript">
	$('#titulo-modal-forms').html("AGREGAR SALDO");
</script>

<form id="alta_categoria" method="post" action="">
	<div class="card">
		<div class="card-body" style="padding: 0;">
			<!--<h5 class="card-title m-b-0"></h5>-->

			<div class="form-group m-t-20">
				<label>Tipo:</label>
				<select id="tipo" name="tipo" class="form-control">
					<option value="0">ABONO</option>
					<option value="1">CARGO</option>
			   </select>
			</div>
			
			<div class="form-group m-t-20">
				<label>Cantidad:</label>
				<input type="text" name="cantidad" id="cantidad" class="form-control" title="Campo Cantidad" placeholder="100.00" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Concepto:</label>
				<textarea id="concepto" name="concepto" title="Campo Concepto" class="form-control"></textarea>
			</div>
			
			<div class="form-group">
				<label>Cliente:</label>
				<div class="input-group">
					<input type="text" name="n_cliente" id="n_cliente" disabled title="Campo Cliente" class="form-control" />

					<div class="input-group-append" onclick="L_Clientes_Monedero();">
						<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
					</div>
					<input type="hidden" name="cliente" id="cliente" />
					<!--<input type="hidden" name="v_idcliente" id="v_idcliente">-->
				</div>
			</div>			
		</div>
	</div>
		
	<div class="card">
		<div class="card-body" style="padding: 0;">			
			<button type="button" onClick="var resp=MM_validateForm('cantidad','','R isNum','concepto','','R'); if(resp==1){ G_monedero('alta_categoria','ventas/ga_monedero.php','ventas/vi_monedero.php','main');}" class="btn btn-success" style="float: right;">Guardar</button>
		</div>
	</div>
</form>