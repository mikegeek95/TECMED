<?php
session_start();
require_once '../../clases/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../../clases/conexcion.php';

require_once '../../clases/class.Funciones.php';
$db=new MySQL();

$f = new Funciones();

//die($_SESSION['prod_ven_productos']);
//$numrest =$db->consulta($_SESSION['prod_ven_productos']);
if($_SESSION['prod_ven_productos']=="" || $_SESSION['prod_ven_entradas']=="" || $_SESSION['prod_ven_salidas']==""){
	echo "null";
}
else{
	
	if($_SESSION['se_sas_SO']=="Mac OS"){
	$valid=1;
}
else if($_SESSION['se_sas_SO']=="Windows"){
	$valid=0;
}
else{
	$valid=0;
}
	
$num_reporte = mysql_num_rows($numrest);

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('productos');

$estatus = array("NO ASIGNADO","ASIGNADO");
	
function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

cellColor('A1', 'D7D7D7');
cellColor('B1', 'D7D7D7');
cellColor('C1', 'D7D7D7');
cellColor('D1', 'D7D7D7');
cellColor('E1', 'D7D7D7');
cellColor('F1', 'D7D7D7');
cellColor('G1', 'D7D7D7');


$estilo = array( 
  'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
    )
  )
);

 

// ENCABEZADOS
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'NO. VENTA');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CODIGO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'CLIENTE');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ESTATUS');

 
	$est = array('PENDIENTE','PAGADO','CANCELADO','CREDITO','CREDITO PAGADO');	

$result =$db->consulta($_SESSION['prod_ven_productos']);

$row = 2; // 1-based index
while($row_data = mysql_fetch_assoc($result)) {
    $col = 0;
    foreach($row_data as $key=>$value) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $f->imprimir_cadena_utf8($row_data['idnota']));
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $f->imprimir_cadena_utf8($row_data['idproducto']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $f->imprimir_cadena_utf8_2($row_data['nombre'],$valid));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $f->imprimir_cadena_utf8($row_data['cantidad']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $f->imprimir_cadena_utf8($row_data['fecha']));
		$idcliente = $result_producto_row['idcliente'];

						if($idcliente != 0){
							$sql_cliente = "SELECT * FROM clientes WHERE idcliente = '$idcliente'";
							$result_cliente = $db->consulta($sql_cliente);
							$result_cliente_row = $db->fetch_assoc($result_cliente);

							$nombre = utf8_encode($result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno']);
						}else{
							$nombre = "PUBLICO GENERAL";
						}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $f->imprimir_cadena_utf8($nombre));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $f->imprimir_cadena_utf8($est[$row_data['estatus']]));
	
		
    }
	$col++;
    $row++;
}
	
$objPHPExcel->getActiveSheet()->getStyle(
		'A1:' . 
		$objPHPExcel->getActiveSheet()->getHighestColumn() . 
		$objPHPExcel->getActiveSheet()->getHighestRow() 
		)->applyFromArray($estilo); 
	
 foreach(range('A','G') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID) ->setAutoSize(true); }

$objPHPExcel->getSheetCount();//cuenta las pestañas

$positionInExcel=1;//esto es para que ponga la nueva pestaña al principio

$objPHPExcel->createSheet($positionInExcel);//creamos la pestaña
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setTitle('entradas');


cellColor('B1', 'D7D7D7');
cellColor('C1', 'D7D7D7');
cellColor('D1', 'D7D7D7');
cellColor('E1', 'D7D7D7');



$estilo = array( 
  'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
    )
  )
);

 

// ENCABEZADOS

$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CODIGO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA');


 
	$est = array('PENDIENTE','PAGADO','CANCELADO','CREDITO','CREDITO PAGADO');	

$result =$db->consulta($_SESSION['prod_ven_entradas']);

$row = 2; // 1-based index
while($row_data = mysql_fetch_assoc($result)) {
    $col = 0;
    foreach($row_data as $key=>$value) {
		
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $f->imprimir_cadena_utf8($row_data['idproducto']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $f->imprimir_cadena_utf8_2($row_data['nombre'],$valid));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $f->imprimir_cadena_utf8($row_data['cantidad']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $f->imprimir_cadena_utf8($row_data['fecha_entrada']));
		
	
		
    }
	$col++;
    $row++;
}
	
$objPHPExcel->getActiveSheet()->getStyle(
		'A1:' . 
		$objPHPExcel->getActiveSheet()->getHighestColumn() . 
		$objPHPExcel->getActiveSheet()->getHighestRow() 
		)->applyFromArray($estilo); 
	
 foreach(range('A','G') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID) ->setAutoSize(true); }

$objPHPExcel->getSheetCount();//cuenta las pestañas

$positionInExcel=2;//esto es para que ponga la nueva pestaña al principio

$objPHPExcel->createSheet($positionInExcel);//creamos la pestaña
$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->setTitle('salidas');


cellColor('B1', 'D7D7D7');
cellColor('C1', 'D7D7D7');
cellColor('D1', 'D7D7D7');
cellColor('E1', 'D7D7D7');
cellColor('F1', 'D7D7D7');



$estilo = array( 
  'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
    )
  )
);

 

// ENCABEZADOS

$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CODIGO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CANTIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'TIPO');


 
	 $tipo = array('VENTAS','DEVOLUCION','FALLA','CADUCADO');	

$result =$db->consulta($_SESSION['prod_ven_salidas']);

$row = 2; // 1-based index
while($row_data = mysql_fetch_assoc($result)) {
    $col = 0;
    foreach($row_data as $key=>$value) {
		
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $f->imprimir_cadena_utf8($row_data['idproducto']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $f->imprimir_cadena_utf8_2($row_data['nombre'],$valid));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $f->imprimir_cadena_utf8($row_data['cantidad']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $f->imprimir_cadena_utf8($row_data['fecha']));
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $f->imprimir_cadena_utf8($tipo[$row_data['tipo']]));
		
	
		
    }
	$col++;
    $row++;
}
	
$objPHPExcel->getActiveSheet()->getStyle(
		'A1:' . 
		$objPHPExcel->getActiveSheet()->getHighestColumn() . 
		$objPHPExcel->getActiveSheet()->getHighestRow() 
		)->applyFromArray($estilo); 
	
 foreach(range('A','G') as $columnID) { $objPHPExcel->getActiveSheet()->getColumnDimension($columnID) ->setAutoSize(true); }
$objPHPExcel->setActiveSheetIndex(0);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_productos_vendidos.xlsx"');
header('Cache-Control: max-age=0');


 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
}
?>