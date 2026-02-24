<?php

// if(!isset($_GET['id'])) exit("No se permite la ejecución directa de este script");
include_once('conexion.php');
require_once('groupDataGenerator.php');

$time_start = microtime(true);

$client = $_GET['id'];
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

$beforeConection= microtime(true);
$data = conectar($startMonth, $endMonth, $startYear, $endYear, $client);
$afterConectionData = microtime(true);
$acumulation = get_accrued($startMonth, $startYear, $client);

$afterConectionAccrued = microtime(true);
$parser = new groupDataGenerator($data, $acumulation);
$grupo = $parser->generate();


$afterParsing = microtime(true);

$ar_month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$filename = '(' . $startMonth .'-'. $startYear . ') (' . $endMonth . '-' . $endYear . ')'.$client.'_'.$grupo['Grupo'];
ob_start();
session_start();
$content='';
?>


<!DOCTYPE html>

<meta charset= "utf-8">

<html>
<head>
    <title> Cuentas corrientes </title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="js/jquery.collapse.js"></script>
</head>
<body>

<?php $content = ob_get_clean(); ob_start();?>

<table class="group-total">
    <thead>
    <tr>
        <th colspan="3">
            <span class="group-name"><?php echo 'Grupo '. $grupo['Grupo']?></span></th>

        <th class="td-item3">Saldo $</th>
        <th class="td-item3"></th>
        <th class="td-item3">Saldo U$S</th>
    </tr>

    </thead>
    <tbody>

    <tr class="highlight-row-black">
        <td class="td-item1"></td>
        <td class="td-item2"></td>
        <td class="td-item3"></td>
        <td class="td-item3 number"> <?php echo format_amount($grupo['TotalGrupo']['SaldoPesos']);?></td>
        <td class="td-item3">&nbsp;</td>
        <td class="td-item3 number"><?php echo format_amount($grupo['TotalGrupo']['SaldoDolares']);?></td>
    </tr>
    </tbody>
</table>

<div data-collapse>

    <?php foreach ($grupo['Clientes'] as $cliente_key => $cliente): ?>
    <h2 class="client-name"> <table>
        <thead>
        <tr>
            <th class="td-item1"></th>
            <th class="td-item2"><?php echo $cliente_key?></th>
            <th class="td-item3"></th>
            <th class="td-item3">Saldo $</th>
            <th class="td-item3"></th>
            <th class="td-item3">Saldo U$S</th>
        </tr>
        </thead>
        <tbody>
        <tr class="highlight-row-black">
            <td class="td-item1"></td>
            <td class="td-item2"></td>
            <td class="td-item3"></td>
            <td class="td-item3 number"> <?php echo format_amount($cliente['SubtotalCliente']['SaldoPesos']);?></td>
            <td class="td-item3">&nbsp;</td>
            <td class="td-item3 number"><?php echo format_amount($cliente['SubtotalCliente']['SaldoDolares']);?></td>
        </tr>
        </tbody>
    </table></h2>
    <div class='client-box'>

        <?php foreach ($cliente['Cuentas'] as $cuenta_key =>$cuenta):?>
        <h4 class='account-name'><?php echo $cuenta_key ?> </h4>

        <table class='center'>
            <thead>
            <tr>
                <th class="td-item1">Fecha</th>
                <th class="td-item2">Concepto</th>
                <th class="td-item3">Importe $</th>
                <th class="td-item3">Saldo $</th>
                <th class="td-item3">Importe U$S</th>
                <th class="td-item3">Saldo U$S</th>
            </tr>
            </thead>
            <tbody>
            <tr class="highlight-row">
                <td class="td-item1"></td>
                <td class="td-item2">Saldo Inicial</td>
                <td class="td-item3"></td>
                <td class='number td-item3'><?php echo  format_amount( $cuenta['SaldoInicial']['SaldoPesos']); ?></td>
                <td class="td-item3"></td>
                <td class='number td-item3'><?php echo  format_amount($cuenta['SaldoInicial']['SaldoDolares']); ?></td>
            </tr>
                <?php foreach($cuenta['Movimientos'] as  $movimiento_key => $movimiento):?>
            <tr>
                <td class="td-item1"><?php echo date('j M Y',strtotime($movimiento['FECHA']))?></td>
                <td class="td-item2"><?php echo $movimiento['Documento']?></td>
                <td class='number td-item3'><?php echo format_amount($movimiento['SaldoPesos']);?></td>
                <td class='number td-item3'><?php echo format_amount($movimiento['AcumuladoPesos']); ?></td>
                <td class='number td-item3'><?php echo format_amount($movimiento['SaldoDolares']);?></td>
                <td class='number td-item3'><?php echo format_amount($movimiento['AcumuladoDolares']); ?></td>
            </tr>
                <?php endforeach;?>
            <tr class="highlight-row">
                <td class="td-item1"></td>
                <td class="td-item2">Saldo Final</td>
                <td class="td-item3"></td>
                <td class='number td-item3'> <?php echo format_amount($cuenta['SaldoFinal']['SaldoPesos']);?></td>
                <td class='number td-item3'></td>
                <td class='number td-item3'> <?php echo format_amount($cuenta['SaldoFinal']['SaldoDolares']);?> </td>
            </tr>
            </tbody>
        </table>
        <?php endforeach; ?>

    </div>
    <?php endforeach;?>
</div>

</body>
</html>

<?php $content2 = ob_get_clean();
$content3 = htmlentities($content.$content2);?>
<?php echo $content?>

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<div class="wrapper">

    <form method="get" action="">

        <input type="hidden" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''?>" id="id" name="id"/>

        <div>
            <label>Fecha Inicial</label>
            <select id="startMonth" name="startMonth">
                <?php for($i=0;$i<count($ar_month); $i++): ?>
                <?php if($ar_month[$i+1] == $ar_month[$startMonth]): ?>
                    <option value="<?php echo ($i+1)?>" selected><?php echo $ar_month[$i] ?></option>
                    <?php else: ?>
                    <option value="<?php echo ($i+1)?>"><?php echo $ar_month[$i] ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>
            <select id="startYear" name="startYear">
                <?php for($i=$current_year;$i >= ($current_year-25);$i--): ?>
                <option value="<?php echo $i?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div>
            <label>Fecha Final</label>

            <select id="endMonth" name="endMonth">
                <?php for($i=0;$i<count($ar_month); $i++): ?>
                <?php if($ar_month[$i+1] == $ar_month[$endMonth]): ?>
                    <option value="<?php echo ($i+1)?>" selected><?php echo $ar_month[$i] ?></option>
                    <?php else: ?>
                    <option value="<?php echo ($i+1)?>"><?php echo $ar_month[$i] ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>

            <select id="endYear" name="endYear">
                <?php for($i=$current_year;$i >= ($current_year-25);$i--): ?>
                <option value="<?php echo $i?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </div>


        <div>
            <input type="submit" value="Filtrar"/>
        </div>

    </form>

    <form method="post" action="convertToPDF.php">

        <input type="hidden" name="content" value="<?php echo $content3?>"/>
        <input type="hidden" name="filename" value="<?php echo $filename?>"/>
        <input type="submit" value="Exportar PDF" />
    </form>

    <form method="post" action="convertToXLS.php">
        <input type="hidden" name="grupo" value='<?php echo serialize($grupo)?>'/>
        <input type="hidden" name="filename" value="<?php echo $filename?>"/>
        <input type="submit" value="Exportar XLS" />
    </form>

</div>
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php echo $content2;


   if(isset($_GET['debug'])){
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    $afterParsingTime = $afterParsing-$time_start;
    $afterConectionTimeData= $afterConectionData-$time_start;
    $afterConectionTimeAccrued= $afterConectionAccrued-$time_start;
    $beforeConectionTime = $beforeConection-$time_start;
    
    echo ("Before conection time: ". $beforeConectionTime. " seconds<br>");
    echo ("Retrieving data time: ". $afterConectionTimeData. " seconds<br>");
    echo ("Retrieving accrued time: ". $afterConectionTimeAccrued. " seconds<br>");
    echo ("After parsing time: ". $afterParsingTime. " seconds<br>");
    echo ("Request time: ". $time. "seconds<br>");
}


?>

<?php
function format_amount($amount){
    $amount = number_format($amount, 0,',','.');
    if ($amount == 0) {
        return 0;
    }
    else{
        return $amount;
    }
}
?>