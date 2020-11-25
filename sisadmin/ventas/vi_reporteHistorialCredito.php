<?php



$id = $_GET['id'];



?>



<script type="text/javascript">

	$(document).ready(function(e) {

        reciboCreditoH (<?php echo $id ?>);

    });



</script>





<article id="ventanaR" style="margin-top:50px; margin-top:20px; display:none;" class="module width_full">

		<header>

			<h3 id="tituloC" class="tabs_involved">COMPROBANTE DE PAGO</h3>

            

            <ul class="tabs">

                <li><a href="#" onClick="aparecermodulos('ventas/vi_credito.php','main');">Ver Creditos</a></li>

                

			</ul>

             

		</header>

        <div class="module_content">

         <center>

        	

        	<iframe src="ventas/pdf/recibo_pago.php" height="600" width="600" id="recibo"></iframe>

        	

         </center>

        </div> 

</article>