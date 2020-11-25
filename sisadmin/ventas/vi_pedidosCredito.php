<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Credito.php");

$db = new MySQL();
$credito = new creditos() ;
$credito->db = $db ;


$creditos = $credito->verListaNotaderemisionCreditos();
$estatus = array("DEBE","PAGADO");
		?>
        
        
        
        
        
        
        
        <table  class="tablesorter" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th align="center">ID PEDIDO</th> 
    				<!--<th>FECHA</th>-->
                  <th align="center">TOTAL</th>
                    <th>ESTATUS</th>
                  <th align="center">ACCI&Oacute;N</th>
			  </tr> 
			</thead> 
			<tbody> 
          <?PHP foreach($creditos as $c )
				{
				?>
          <tr>
          
            <td align="center"><?php echo $c->idnota_remision?></td>
            <td align="center">$<?php echo $c->cantidad?></td>
            <td align="center"><?php echo $estatus[ $c->estatus]?></td>
            <td align="center"><input type="button" onClick="colocarIdNotaCaja(<?php echo $c->idnota_remision?>);buscarCredito();" value="COLOCAR"  /></td>
          </tr>
          <?PHP
          	 
				}
		  
		  ?>
        </table>