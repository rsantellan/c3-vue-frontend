<?php

function conectar($startMonth, $endMonth, $startYear, $endYear, $client)
{

    $conn = mssql_connect('201.217.129.42', 'sa', '4dm1nW4n$2012');

    if (!$conn) {
        return ;
    } else {

        /*$d1 = explode('/',$startDate);
        $monthStart = $d1[1];
        $yearStart = $d1[2];

        $d2 = explode('/',$endDate);
        $monthEnd = $d2[1];
        $yearEnd = $d2[2];*/

        $_fechaInicio = date("M 1 Y 00:00", strtotime((integer)$startYear . '/' . (integer)$startMonth . '/01')) . ' AM';
        $_fechaFin = date("M t Y 11:59", strtotime((integer)$endYear . '/' . (integer)$endMonth . '/02')) . ' PM';

        $var_cliente = generate_id($client);
        mssql_select_db('ESTUDIO', $conn);
        $sql = "SELECT q.fecha  AS FECHA,
                          t.nombre + ' ' + (q.comp) + ' - ' + isnull(cj.detalle,'') + ' - ' + isnull(q.nota,'') AS Documento,
                          Case When c.monedaid = 001 Then q.neto*t.coef Else  0 End  AS SaldoPesos,
                          Case When c.monedaid <> 001 Then (q.neto/c.cotizacion)*t.coef Else  0 End  AS SaldoDolares,
                          gc.detalle AS TipoCliente,
                          q.zona+ q.cliente + ' - ' + cli.nombre AS Cliente,
                          tc.nombre AS UnidadNegocios, o.nombre AS TipoDoc
                        FROM movi q (readpast) LEFT JOIN 
                        Clientes cli (readpast)  On (q.CLIENTEID) = (cli.CLIENTEID) LEFT JOIN 
                        qtranparamventas t (readpast)  On (left(q.codigo,1)) = (t.codigo) LEFT JOIN 
                        cotizaciones c (readpast)  On (q.cotizacionid) = (c.id) LEFT JOIN 
                        monedas m (readpast)  On (c.monedaid) = (q.codigo) LEFT JOIN 
                        tipocli tc (readpast)  On (cli.tipo) = (tc.codigo) LEFT JOIN 
                        grupcli gc (readpast)  On (cli.grupo) = (gc.grupo) LEFT JOIN 
                        o_tiporecibo o (readpast)  On (q.a_tiporecibo) = (o.codigo) LEFT JOIN 
                        cajamov cj (readpast)  On (left(q.Codigo,1)+q.comp+q.CLIENTEID) = (cj.documento+cj.comp+cj.cliente)
                        WHERE ( 
                            (left(q.comp,3) <> '900' and 
                                left(q.codigo,1) <> 'Y' and 
                                left(q.codigo,1) <> 'Z') 
                            and q.CLIENTEID in (select case when grupo = '0001' then '{$var_cliente}' else CLIENTEID end 
                                    from clientes 
                                    where grupo 
                                    in (select grupo from clientes where clienteid = '{$var_cliente}'))  and
                            q.fecha between '{$_fechaInicio}' and '{$_fechaFin}' )
                        ORDER BY cli.nombre, tc.nombre, o.nombre, q.fecha";
    }
    $result = mssql_query($sql, $conn);

    $a = array();
    while ($r = mssql_fetch_array($result, MSSQL_ASSOC)) {
        array_push($a, $r);
    }
    return $a;
}

function get_accrued($month,$year,$client) {

    $conn = mssql_connect('201.217.129.42','sa','4dm1nW4n$2012');

    if (!$conn) {
        return ;
    } else {

        $_fechaInicio = date("M 1 Y 00:00", strtotime((integer) $year. '/' . (integer)$month . '/01')) . ' AM';

        $var_cliente = generate_id($client);
        mssql_select_db('ESTUDIO',$conn);
        $sql = "SELECT
                        q.zona+ q.cliente + ' - ' + cli.nombre AS Cliente,
                        o.nombre AS TipoDoc,
                        gc.detalle AS TipoCliente,

                        sum(Case When c.monedaid = 001 Then q.neto*t.coef Else  0 End) AS SaldoPesos,
                        sum(Case When c.monedaid <> 001 Then (q.neto/c.cotizacion)*t.coef Else  0 End ) AS SaldoDolares

                        FROM movi q (readpast)
                        LEFT JOIN Clientes cli (readpast)  On (q.CLIENTEID) = (cli.CLIENTEID)
                        LEFT JOIN qtranparamventas t (readpast)  On (left(q.codigo,1)) = (t.codigo)
                        LEFT JOIN cotizaciones c (readpast)  On (q.cotizacionid) = (c.id)
                        LEFT JOIN monedas m (readpast)  On (c.monedaid) = (q.codigo)
                        LEFT JOIN tipocli tc (readpast)  On (cli.tipo) = (tc.codigo)
                        LEFT JOIN grupcli gc (readpast)  On (cli.grupo) = (gc.grupo)
                        LEFT JOIN o_tiporecibo o (readpast)  On (q.a_tiporecibo) = (o.codigo)
                        LEFT JOIN cajamov cj (readpast)  On (left(q.Codigo,1)+q.comp+q.CLIENTEID) = (cj.documento+cj.comp+cj.cliente)

                        WHERE (
                            (left(q.comp,3) <> '900' and
                            left(q.codigo,1) <> 'Y' and
                            left(q.codigo,1) <> 'Z')
                            and q.CLIENTEID in ((select case when grupo = '0001' then '{$var_cliente}' else CLIENTEID end 
                                    from clientes 
                                    where grupo 
                                    in (select grupo from clientes where clienteid = '{$var_cliente}')) ) and q.fecha < '{$_fechaInicio}')
                       group by gc.detalle,cli.nombre, o.nombre, q.zona,q.cliente
                       order by cli.nombre, o.nombre, q.zona,q.cliente";

    }
    $result = mssql_query($sql,$conn);

    $a = array();
    while ($r = mssql_fetch_array($result, MSSQL_ASSOC)) {
        array_push($a,$r);
    }
    return $a;

}

function generate_id($id)
{

    $cust_number = trim($id);

    $ci = '01';
    if ($cust_number == '1557' || $cust_number == '1655' || $cust_number == '1657') {
        $ci = '02';
    }
    if (strlen($cust_number) < 5) {
        if (strlen($cust_number) == 1) {
            $cust_number = '0000' . $cust_number;
        }
        if (strlen($cust_number) == 2) {
            $cust_number = '000' . $cust_number;
        }
        if (strlen($cust_number) == 3) {
            $cust_number = '00' . $cust_number;
        }
        if (strlen($cust_number) == 4) {
            $cust_number = '0' . $cust_number;
        }
    }
    $ret = $ci . $cust_number;
    return $ret;
}