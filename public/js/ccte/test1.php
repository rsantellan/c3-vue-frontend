<?php 
phpinfo();
error_reporting(E_ALL);
ini_set('display_errors', '1');
echo "test ftp server1";

//include_once('Merge_Data.php');

echo "test ftp server2";
include_once('conexion.php');


echo "test ftp server3";

//$client = $_GET['id'];
$current_year = (integer)date("Y");
$current_month = (integer)date("m");

if(isset($_GET['startMonth']) && isset($_GET['startYear']) && isset($_GET['endMonth']) && isset($_GET['endYear'])) {
    $startMonth = $_GET['startMonth'];
    $startYear = $_GET['startYear'];
    $endMonth = $_GET['endMonth'];
    $endYear = $_GET['endYear'];
}else{
    $startMonth = $current_month-1;
    $startYear = $current_year;
    $endMonth = $current_month;
    $endYear = $current_year;
}

$client =1271;





$data = conectar($startMonth, $endMonth, $startYear, $endYear, $client);
$acumulation = get_accrued($startMonth, $startYear, $client);

//$parser = new Merge_Data($data, $acumulation);
//$grupo = $parser->format_group();

var_export($acumulation);
exit();


$ar_month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");



?>