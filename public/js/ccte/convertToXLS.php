<?php
    
error_reporting(E_ALL);
ini_set('display_errors', '1');

    require_once('lib/dompdf/dompdf_config.inc.php');
    require_once('lib/PHPExcel.php');

    $grupo = unserialize(stripslashes($_POST['grupo']));
    $reportName = $_POST['filename'];
    $reportName .= ".xls";

    $phpExcel = new PHPExcel();
    $phpExcel->getActiveSheet()->setTitle($grupo['Grupo']);
    $phpExcel->setActiveSheetIndex(0);
    $sheet = $phpExcel->getActiveSheet();
    $phpExcel->getProperties()->setSubject("Reporte");


//format cells
$style_group =array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '6495ED')
    )
);
$style_headers =array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '000000')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF')
    )
);
$style_clients = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000')
    )
);
$style_amounts =array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'B0C4DE')
    ),

);
$style_table_header =array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFFFF')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000')
    )
);
$style_accounts =array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000')

    )
);

//total del grupo
    $sheet->setCellValue("A1", $grupo['Grupo']);
    $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->mergeCells("A1:C1");
    $sheet->setCellValue("D1", 'Saldo $');
    $sheet->setCellValue("F1", "Saldo U\$S");

    $sheet->getStyle('D2')->getNumberFormat()->setFormatCode('#,##0');
    $sheet->setCellValue("D2", $grupo['TotalGrupo']['SaldoPesos']);

    //$sheet->getStyle("F2")-> getNumberFormat()-> setFormatCode( $numberFormat);

    $sheet->getStyle('F2')->getNumberFormat()->setFormatCode('#,##0');
    $sheet->setCellValue("F2", $grupo['TotalGrupo']['SaldoDolares']);
    $sheet->getStyle("A1:F1")->applyFromArray($style_group);
    $sheet->getStyle("A2:F2")->applyFromArray($style_headers);


$fila = 4;
//para cada cliente
foreach ($grupo['Clientes'] as $cliente_key => $cliente){
    $sheet->setCellValue("B" . $fila, $cliente_key);
    $sheet->getStyle("B".$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle("A".$fila.":F".$fila)->applyFromArray($style_clients);

    $sheet->setCellValue("D" . $fila, 'Saldo $'); $sheet->setCellValue("F" . $fila, 'Saldo U$S');
    $sheet->getStyle("D".$fila.":F".$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $fila++;

    $sheet->getStyle("A".$fila.":F".$fila)->applyFromArray($style_headers);
    $sheet->getStyle('C'.$fila.":F".$fila)->getNumberFormat()->setFormatCode('#,##0');
    $sheet->setCellValue("D" . $fila, $cliente["SubtotalCliente"]['SaldoPesos']);
    $sheet->setCellValue("F" . $fila, $cliente['SubtotalCliente']['SaldoDolares']);
    $fila++;

    //cuentas
    foreach ($cliente['Cuentas'] as $cuenta_key =>$cuenta){
        $sheet->setCellValue("A" . $fila, $cuenta_key);
        $sheet->getStyle("A".$fila.":F".$fila)->applyFromArray($style_accounts);

        $fila++;

        $sheet->getStyle("A".$fila.":F".$fila)->applyFromArray($style_table_header);
        $sheet->getStyle("A".$fila.":F".$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue("A" . $fila, "Fecha"); $sheet->setCellValue("B".$fila, "Concepto"); $sheet->setCellValue("C".$fila, "Importe $"); $sheet->setCellValue("D" . $fila, 'Saldo $'); $sheet->setCellValue("E".$fila,'Importe U$S'); $sheet->setCellValue("F" . $fila, 'Saldo U$S');
        $fila++;

        $sheet->getStyle('C'.$fila.":F".$fila)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue("B".$fila, "Saldo Inicial"); $sheet->setCellValue("D".$fila, $cuenta['SaldoInicial']['SaldoPesos']); $sheet->setCellValue("F".$fila, $cuenta['SaldoInicial']['SaldoDolares']);
        $sheet->getStyle("A".$fila.":F".$fila)->applyFromArray($style_amounts);
        $fila++;

        //movimientos
        foreach($cuenta['Movimientos'] as  $movimiento_key => $movimiento){
            $sheet->getStyle('C'.$fila.":F".$fila)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue("A".$fila, date('j M Y',strtotime($movimiento['FECHA'])));
            $sheet->setCellValue("B".$fila, $movimiento['Documento']);
            $sheet->setCellValue("C".$fila, $movimiento['SaldoPesos']);
            $sheet->setCellValue("D".$fila, $movimiento['AcumuladoPesos']);
            $sheet->setCellValue("E".$fila, $movimiento['SaldoDolares']);
            $sheet->setCellValue("F".$fila, $movimiento['AcumuladoDolares']);
            $fila++;
        }
        $sheet->getStyle('C'.$fila.":F".$fila)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue("B".$fila, "Saldo Final"); $sheet->setCellValue("D".$fila,$cuenta['SaldoFinal']['SaldoPesos']); $sheet->setCellValue("F".$fila, $cuenta['SaldoFinal']['SaldoDolares']);
        $sheet->getStyle("A".$fila.":F".$fila)->applyFromArray($style_amounts);
        $fila+=2;
    }
}
    $sheet->getColumnDimension("A")->setWidth(15);
    $sheet->getColumnDimension("B")->setWidth(60);
    $sheet->getColumnDimension("C")->setWidth(15);
    $sheet->getColumnDimension("D")->setWidth(15);
    $sheet->getColumnDimension("E")->setWidth(15);
    $sheet->getColumnDimension("F")->setWidth(15);
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=".$reportName);
    header("Cache-Control: max-age=0");
    $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
    $objWriter->save("php://output");
