<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('lib/dompdf/dompdf_config.inc.php');

//$reportpage = file_get_contents($url);

$reportpage =  html_entity_decode($_POST["content"]);

$reportName = $_POST['filename'];
$reportName .= ".pdf";
$style =
    "<style type='text/css'>".
        '.wrapper option, .wrapper select, .wrapper label{'.
            'display:none;}'.
        '.group-total{'.
            'margin-left: 0;'.
            'width: 100%;}'.
    '</style>';

$reportpage = $style.$reportpage;
$reportpage = str_replace('﻿', '', $reportpage);
$dompdf = new DOMPDF();
$dompdf->load_html( utf8_decode( $reportpage ) );
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();
$dompdf->stream($reportName);