
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');// if(!isset($_GET['id'])) exit("No se permite la ejecución directa de este script");
include_once('conexion.php');
require_once('groupDataGenerator.php');

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


//$data = conectar($startMonth, $endMonth, $startYear, $endYear, $client);
//$acumulation = get_accrued($startMonth, $startYear, $client);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data = array(
    0 => array('FECHA' => 'Nov 16 2011 12:00AM', 'Documento' => 'Recibos de Cobranza 000000501128 - Canje rec fact 3733 - ',        'SaldoPesos' => 1,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '00 cuenta sin acumulado ',),
    1 => array('FECHA' => 'Nov 16 2011 12:00AM', 'Documento' => 'Recibos de Cobranza 000000501128 - Canje rec fact 3733 - ',        'SaldoPesos' => 2,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01 - Honorarios',),
    2 => array('FECHA' => 'Nov 17 2011 12:00AM', 'Documento' => 'Cambio de Saldos 000000000225 - - TRASLADO recibo',                'SaldoPesos' => 3,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01 - Honorarios',),
    3 => array('FECHA' => 'Nov 10 2011 12:00AM', 'Documento' => 'Pago de Terceros 000000017600 - Pago a Terceros : ENCOMIENDAS - ', 'SaldoPesos' => 4,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
    4 => array('FECHA' => 'Nov 18 2011 12:00AM', 'Documento' => 'Pago de Terceros 000000017717 - Pago a Terceros : DGI - - ',       'SaldoPesos' => 5,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
    5 => array('FECHA' => 'Nov 21 2011 12:00AM', 'Documento' => 'Pago de Terceros 000000017765 - Pago a Terceros : BPS - - ',       'SaldoPesos' => 6,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
    6 => array('FECHA' => 'Nov 21 2011 12:00AM', 'Documento' => 'Pago de Terceros 000000017766 - Pago a Terceros : BPS - - ',       'SaldoPesos' => 7,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
    7 => array('FECHA' => 'Nov 23 2011 12:00AM', 'Documento' => 'Recibos de Cobranza 000000501219 - DGI/BPS DEP. 21/11/11 - ',      'SaldoPesos' => 8,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
    11 => array('FECHA' => 'Nov 24 2011 12:00AM', 'Documento' => 'Pago de Terceros 000000017856 - Pago a Terceros : ENCOMIENDAS - -','SaldoPesos' => 9,    'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
    12 => array('FECHA' => 'Nov 17 2011 12:00AM', 'Documento' => 'Cambio de Saldos 000000000226 - - TRASLADO recibo',                'SaldoPesos' => 10,   'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '03 - Canje',),
    10 => array('FECHA' => 'Nov 30 2011 12:00AM', 'Documento' => 'Factura de Honorarios 000000501383 - - ',                         'SaldoPesos' => 11,   'SaldoDolares' => 0, 'TipoCliente' => 'Riar', 'Cliente' => '0101488 - LIKAMEL S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '03 - Canje',),
);

$acumulation = array(
    0 => array('Cliente' => '0101488 - LIKAMEL S.A.',   'TipoDoc' => '01 - Honorarios',                  'SaldoPesos' => 0,  'SaldoDolares' => 0,),
    1 => array('Cliente' => '0101488 - LIKAMEL S.A.',   'TipoDoc' => '02 - Impuestos y Gastos',         'SaldoPesos' => 1,  'SaldoDolares' => 0,),
    2 => array('Cliente' => '0101488 - LIKAMEL S.A.',   'TipoDoc' => '03 - Canje',                      'SaldoPesos' => 2,  'SaldoDolares' => 0,),
    3 => array('Cliente' => '0101521 - RIAR S.A.',      'TipoDoc' => '01 - Antes de honorarios',        'SaldoPesos' => 3,  'SaldoDolares' => 0,),
    4 => array('Cliente' => '0101521 - RIAR S.A.',      'TipoDoc' => '01 - Honorarios',                 'SaldoPesos' => 4,  'SaldoDolares' => 0,),
    5 => array('Cliente' => '0101521 - RIAR S.A.',      'TipoDoc' => '02 - Honorarios Factura',         'SaldoPesos' => 5,  'SaldoDolares' => 0,),
    6 => array('Cliente' => '0101521 - RIAR S.A.',      'TipoDoc' => '02 - Impuestos y Gastos',         'SaldoPesos' => 6,  'SaldoDolares' => 0,),
    7 => array('Cliente' => '0101521 - RIAR S.A.',      'TipoDoc' => '03 - Canje',                      'SaldoPesos' => 7,  'SaldoDolares' => 0,),
    8 => array('Cliente' => '0101521 - RIAR S.A.',      'TipoDoc' => '03 - despues de canje',           'SaldoPesos' => 8,  'SaldoDolares' => 0,),);


        $data =
            array(
                0 => array('FECHA' => 'Feb 26 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506075 - - telefonica dic y ene', 'SaldoPesos' => 7137, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                1 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506205 - - ', 'SaldoPesos' => 7641, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                2 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506092 - HONORARIOS - ', 'SaldoPesos' => -14778, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                3 => array('FECHA' => 'Mar 18 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506288 - - telefonica', 'SaldoPesos' => 3584.36, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                4 => array('FECHA' => 'Mar 22 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506376 - honorarios - ', 'SaldoPesos' => -11225.36, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                5 => array('FECHA' => 'Feb 13 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025124 - Pago a Terceros : AGUA LUZ', 'SaldoPesos' => 491, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                6 => array('FECHA' => 'Feb 14 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025128 - Pago a Terceros : VARIOS p', 'SaldoPesos' => 1290, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                7 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025209 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 690, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                8 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025210 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 72, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                9 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025211 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 369, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                10 => array('FECHA' => 'Feb 21 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025279 - Pago a Terceros : VARIOS p', 'SaldoPesos' => 4875, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                11 => array('FECHA' => 'Feb 22 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025339 - Pago a Terceros : BSE - bs', 'SaldoPesos' => 1208, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                12 => array('FECHA' => 'Feb 25 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025343 - Pago a Terceros : DGI - - ', 'SaldoPesos' => 6317, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                13 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025485 - Pago a Terceros : BSE - SA', 'SaldoPesos' => 10619.3, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                14 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506093 - SALDO EN CTA CTE - ', 'SaldoPesos' => -64845.26, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                15 => array('FECHA' => 'Mar 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025526 - Pago a Terceros : NOTARIAL', 'SaldoPesos' => 1423, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                16 => array('FECHA' => 'Mar 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025530 - Pago a Terceros : NOTARIAL', 'SaldoPesos' => 536, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                17 => array('FECHA' => 'Mar 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025531 - Pago a Terceros : NOTARIALE', 'SaldoPesos' => 1423, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                18 => array('FECHA' => 'Mar 11 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025580 - Pago a Terceros : AGUA LUZ ', 'SaldoPesos' => 458, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                19 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025622 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 111, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                20 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025623 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 443, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                21 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025624 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 590, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                22 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025625 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 48, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                23 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025626 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 4859, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                24 => array('FECHA' => 'Mar 21 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025928 - Pago a Terceros : DGI - - ', 'SaldoPesos' => 6317, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                25 => array('FECHA' => 'Mar 22 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506377 - saldo en cta cte - ', 'SaldoPesos' => -16522.3, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101271 - DIVALCOREN S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                26 => array('FECHA' => 'Feb 25 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025403 - Pago a Terceros : DGI - - ', 'SaldoPesos' => 604, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                27 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025606 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 10509, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                28 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025607 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 6747, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                29 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025653 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 24516, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                30 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025654 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 6576, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                31 => array('FECHA' => 'Mar 21 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025868 - Pago a Terceros : DGI - - ', 'SaldoPesos' => 604, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                32 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506219 - - ', 'SaldoPesos' => 9400, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                33 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506090 - HONORARIOS - ', 'SaldoPesos' => -9400, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                34 => array('FECHA' => 'Mar 03 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506225 - - 186 hs L.Marquez', 'SaldoPesos' => 25415.04, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                35 => array('FECHA' => 'Mar 21 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506366 - honorarios - ', 'SaldoPesos' => -34815.04, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '01- Honorarios',),
                36 => array('FECHA' => 'Feb 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025333 - Pago a Terceros : VARIOS', 'SaldoPesos' => 15730, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                37 => array('FECHA' => 'Feb 07 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025103 - Pago a Terceros : ENCOMIENDA', 'SaldoPesos' => 98, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                38 => array('FECHA' => 'Feb 13 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025123 - Pago a Terceros : AGUA LUZ ', 'SaldoPesos' => 419, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                39 => array('FECHA' => 'Feb 18 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025148 - Pago a Terceros : VARIOS ', 'SaldoPesos' => 902, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                40 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025201 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 20190, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                41 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025202 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 2134, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                42 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025203 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 2387, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                43 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025204 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 2451, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                44 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025205 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 3195, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                45 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025206 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 3098, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                46 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025207 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 2306, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                47 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025208 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 208512, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                48 => array('FECHA' => 'Feb 19 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000505951 - bps - ', 'SaldoPesos' => -244273, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                49 => array('FECHA' => 'Feb 21 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025277 - Pago a Terceros : VARIOS po', 'SaldoPesos' => 23956, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                50 => array('FECHA' => 'Feb 22 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025338 - Pago a Terceros : AGUA LUZ ', 'SaldoPesos' => 2877, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                51 => array('FECHA' => 'Feb 26 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025468 - Pago a Terceros : VARIOS po', 'SaldoPesos' => 4734, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                52 => array('FECHA' => 'Feb 27 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025473 - Pago a Terceros : NOTARIALE', 'SaldoPesos' => 1108, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                53 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025478 - Pago a Terceros : BSE - - ', 'SaldoPesos' => 2808, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                54 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025479 - Pago a Terceros : BSE - - ', 'SaldoPesos' => 33479, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                55 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025486 - Pago a Terceros : BSE - u$s', 'SaldoPesos' => 742, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                56 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506089 - - 100 Hs L.Marquez', 'SaldoPesos' => 13664, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                57 => array('FECHA' => 'Feb 28 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506091 - SALDO EN CTA CTE - ', 'SaldoPesos' => -112681, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                58 => array('FECHA' => 'Mar 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025533 - Pago a Terceros : NOTAR', 'SaldoPesos' => 1423, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                59 => array('FECHA' => 'Mar 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025534 - Pago a Terceros : NOTARIALE', 'SaldoPesos' => 1423, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                60 => array('FECHA' => 'Mar 04 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025524 - Pago a Terceros : NOTARIAL', 'SaldoPesos' => 14000, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                61 => array('FECHA' => 'Mar 05 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025537 - Pago a Terceros : ENCOMIEN', 'SaldoPesos' => 86, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                62 => array('FECHA' => 'Mar 08 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025561 - Pago a Terceros : VARIOS ', 'SaldoPesos' => 442, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                63 => array('FECHA' => 'Mar 08 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025564 - Pago a Terceros : VARIOS ', 'SaldoPesos' => 10125, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                64 => array('FECHA' => 'Mar 08 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025565 - Pago a Terceros : VARIOS ', 'SaldoPesos' => 10125, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                65 => array('FECHA' => 'Mar 08 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025566 - Pago a Terceros : VARIOS ', 'SaldoPesos' => 8018, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                66 => array('FECHA' => 'Mar 11 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025579 - Pago a Terceros : AGUA L ', 'SaldoPesos' => 422, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                67 => array('FECHA' => 'Mar 11 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025582 - Pago a Terceros : ENCOMIE', 'SaldoPesos' => 71, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                68 => array('FECHA' => 'Mar 12 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025584 - Pago a Terceros : BSE - - ', 'SaldoPesos' => 2443, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                69 => array('FECHA' => 'Mar 13 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025593 - Pago a Terceros : VARIOS p', 'SaldoPesos' => 3977.2, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                70 => array('FECHA' => 'Mar 13 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025597 - Pago a Terceros : VARIOS ', 'SaldoPesos' => 4273, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                71 => array('FECHA' => 'Mar 13 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025598 - Pago a Terceros : ENCOMIEN', 'SaldoPesos' => 95, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                72 => array('FECHA' => 'Mar 13 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025599 - Pago a Terceros : ENCOMIEN', 'SaldoPesos' => 75, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                73 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025600 - Pago a Terceros : ENCOMIEN', 'SaldoPesos' => 71, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                74 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025649 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 131065, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                75 => array('FECHA' => 'Mar 15 2013 12:00AM', 'Documento' => 'Pago de Terceros 000000025650 - Pago a Terceros : BPS - - ', 'SaldoPesos' => 8069, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                76 => array('FECHA' => 'Mar 21 2013 12:00AM', 'Documento' => 'Recibos de Cobranza 000000506367 - Cobranza - ', 'SaldoPesos' => -213519.96, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),
                77 => array('FECHA' => 'Mar 22 2013 12:00AM', 'Documento' => 'Factura de Honorarios 000000506371 - - L marquez 121.3 horas', 'SaldoPesos' => 16574.432, 'SaldoDolares' => 0, 'TipoCliente' => 'De Leon Ricardo', 'Cliente' => '0101370 - TILSIT S.A.', 'UnidadNegocios' => 'Maldonado', 'TipoDoc' => '02 - Impuestos y Gastos',),);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $acumulation = array(
        0 => array('Cliente' => '0101745 - DE LEON SAGASTUME Patricia', 'TipoDoc' => '02 - Impuestos y Gastos', 'SaldoPesos' => 22281, 'SaldoDolares' => 0,),
        1 => array('Cliente' => '0103003 - DE LEON SAGASTUME RICARDO', 'TipoDoc' => '02 - Impuestos y Gastos', 'SaldoPesos' => 0, 'SaldoDolares' => 0,),
        2 => array('Cliente' => '0101271 - DIVALCOREN S.A.', 'TipoDoc' => '01- Honorarios', 'SaldoPesos' => 7640.996154, 'SaldoDolares' => -0.0010000000000332,),
        3 => array('Cliente' => '0101271 - DIVALCOREN S.A.', 'TipoDoc' => '02 - Impuestos y Gastos', 'SaldoPesos' => 39228.259198, 'SaldoDolares' => 0,),
        4 => array('Cliente' => '0100434 - SAGASTUME CAVELLI Sonia Rene', 'TipoDoc' => '02 - Impuestos y Gastos', 'SaldoPesos' => 138175, 'SaldoDolares' => 0,),
        5 => array('Cliente' => '0101370 - TILSIT S.A.', 'TipoDoc' => '01- Honorarios', 'SaldoPesos' => 9399.995, 'SaldoDolares' => 0,),
        6 => array('Cliente' => '0101370 - TILSIT S.A.', 'TipoDoc' => '02 - Impuestos y Gastos', 'SaldoPesos' => 12906.91, 'SaldoDolares' => -1.1368683772162E-13,));

//$parser = new Merge_Data($data, $acumulation);
//$grupo = $parser->format_group();

$parser = new groupDataGenerator($data, $acumulation);
$grupo = $parser->generate();

$serialized = serialize($grupo);

ob_start();
session_start();
$content='';

//var_dump($grupo);
//exit();
$ar_month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$filename = '(' . $startMonth .'-'. $startYear . ') (' . $endMonth . '-' . $endYear . ')'.$client.'_'.$grupo['Grupo'];
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
    <h1> En construccion</h1>
    <form method="get" action="">

        <input type="hidden" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''?>" id="id" name="id"/>

        <div>
            <label>Fecha Inicial</label>

            <select id="startMonth" name="startMonth">
                <?php for($i=0;$i<count($ar_month); $i++): ?>
                <?php if($ar_month[$i] == $ar_month[$startMonth]): ?>
                    <option value="<?php echo ($i)?>" selected><?php echo $ar_month[$i] ?></option>
                    <?php else: ?>
                    <option value="<?php echo ($i)?>"><?php echo $ar_month[$i] ?></option>
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
                <?php if($ar_month[$i] == $ar_month[$endMonth]): ?>
                    <option value="<?php echo ($i)?>" selected><?php echo $ar_month[$i] ?></option>
                    <?php else: ?>
                    <option value="<?php echo ($i)?>"><?php echo $ar_month[$i] ?></option>
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
<?php echo $content2;?>


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