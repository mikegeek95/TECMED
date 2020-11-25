<?php

require_once ("../clases/conexcion.php");

require_once ("../clases/class.Credito.php");

try{



$db = new MySQL ();

$credito = new creditos ();



$credito->db = $db ;







$credito->idcretdito= $_GET['id'];

$deuda = $credito->obtenerDeuda();

$pagos = $credito->totalPagos() ;



?>

		<header>

			<h3 class="tabs_involved">DATOS DE ADEUDO</h3>

            

            

             

		</header>

        

          <div class="module_content">

          	<center>

            <table width="413" border="0">

              <tr>

                <td width="142" align="right">Cliente:</td>

                <td width="261"><?php echo utf8_encode ($deuda['cliente']);?></td>

              </tr>

              <tr>

                <td align="right">Id Nota Remision:</td>

                <td><?php echo $deuda['idnota_remision'];?></td>

              </tr>

              <tr>

                <td align="right">Total de Pagos:</td>

                <td><?php echo $pagos['totalp'];?></td>

              </tr>

              <tr>

                <td align="right">Adeudo:</td>

                <td>$<?php echo $deuda['debe'];?></td>

              </tr>

            </table>

            </center>

          </div>





<?php

}//fin del try

catch (Exception $e)

{

	$v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;

	

}









?>