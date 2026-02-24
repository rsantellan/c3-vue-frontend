<?php
/**
 * @author: fabricio@forcedevelop.com
 **/

class groupDataGenerator
{
    private $movements;
    private $amounts;
    private $group;
    private $currentAmount;

    public function __construct($movements, $amounts)
    {
        $this->movements = $movements;
        $this->amounts = $amounts;
    }

    public function generate()
    {
        foreach ($this->amounts as $amount) {
            $this->addAmount($amount);
        }
        foreach ($this->movements as $movement) {
            $this->addMovement($movement);
        }
        //agrego el nombre de grupo
         if((!is_null($this->movements))&&(count($this->movements)>0)){
            $this->group['Grupo'] = $this->movements[0]['TipoCliente'];
        }
        elseif((!is_null($this->amounts))&&(count($this->amounts)>0)){
            $this->group['Grupo'] = $this->amounts[0]['TipoCliente'];
        }
        else{
                $this->group['Grupo'] = '';
            }
        return $this->group;
    }

    private function addAmount($amount)
    {
        $saldo_inicial = array('SaldoPesos' => $amount['SaldoPesos'], 'SaldoDolares' => $amount['SaldoDolares']);

        if (!isset($this->group['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['Movimientos'])) {
            $this->group['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['Movimientos']= array();
        }

        $this->group['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['SaldoInicial'] = $saldo_inicial;
        $this->updateCounters($amount);
    }

    private function addMovement($move)
    {
        $this->updateCounters($move);

        //verifico que tenga saldo inicial -> caso en que existe movimiento pero no valor acumulado

        if(!isset($this->group['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['SaldoInicial'])){
            $this->group['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['SaldoInicial'] = 0;
        }

        $pesos_acum = $this->group ['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['SaldoFinal'] ['SaldoPesos'];
        $dolares_acum = $this->group ['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['SaldoFinal'] ['SaldoDolares'];

        //agrego el acumulado a la linea del movimiento
        $move['AcumuladoPesos'] = $pesos_acum;
        $move['AcumuladoDolares'] = $dolares_acum;

        //agrego la linea
        if (isset($this->group['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['Movimientos'])) {
            array_push($this->group['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['Movimientos'], $move);
        } else {
            $this->group['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['Movimientos'] = array();
            array_push($this->group['Clientes'] [$move['Cliente']] ['Cuentas'] [$move['TipoDoc']] ['Movimientos'], $move);
        }

        //$acumulados = array('AcumuladoPesos' => $pesos_acum, 'AcumuladoDolares' => $dolares_acum);
    }

    private function updateCounters($amount)
    {
        //actualizar total grupo
        if (isset($this->group['TotalGrupo'])) {
            $this->group['TotalGrupo']['SaldoPesos'] += $amount['SaldoPesos'];
            $this->group['TotalGrupo']['SaldoDolares'] += $amount['SaldoDolares'];
        } else {
            $this->group['TotalGrupo']['SaldoPesos'] = $amount['SaldoPesos'];
            $this->group['TotalGrupo']['SaldoDolares'] = $amount['SaldoDolares'];
        }

        //actualizar subtotal cliente
        if (isset($this->group['Clientes'][$amount['Cliente']] ['SubtotalCliente'])) {
            $this->group['Clientes'] [$amount['Cliente']] ['SubtotalCliente'] ['SaldoPesos'] += $amount['SaldoPesos'];
            $this->group['Clientes'] [$amount['Cliente']] ['SubtotalCliente'] ['SaldoDolares'] += $amount['SaldoDolares'];

        } else {
            $this->group['Clientes'] [$amount['Cliente']] ['SubtotalCliente'] ['SaldoPesos'] = $amount['SaldoPesos'];
            $this->group['Clientes'] [$amount['Cliente']] ['SubtotalCliente'] ['SaldoDolares'] = $amount['SaldoDolares'];

        }
        //actualizar subtotal cuenta
        if (isset($this->group['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['SaldoFinal'])) {
            $this->group ['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['SaldoFinal'] ['SaldoPesos'] += $amount['SaldoPesos'];
            $this->group ['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['SaldoFinal'] ['SaldoDolares'] += $amount['SaldoDolares'];
        } else {
            $this->group ['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['SaldoFinal'] ['SaldoPesos'] = $amount['SaldoPesos'];
            $this->group ['Clientes'] [$amount['Cliente']] ['Cuentas'] [$amount['TipoDoc']] ['SaldoFinal'] ['SaldoDolares'] = $amount['SaldoDolares'];

        }
    }
}

?>