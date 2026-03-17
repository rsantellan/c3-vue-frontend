export interface AccountSaldo {
  SaldoPesos: number
  SaldoDolares: number
}

export interface AccountMovimiento {
  AcumuladoPesos: number
  Cliente: string
  Documento: string
  FECHA: string
  SaldoPesos: number
  SaldoDolares: number
  TipoCliente: string
  TipoDoc: string
  UnidadNegocios: string
}

export interface AccountCuenta {
  Movimientos: AccountMovimiento[]
  SaldoInicial: AccountSaldo
  SaldoFinal: AccountSaldo
}

export interface AccountCliente {
  Cuentas: Record<string, AccountCuenta>
  SubtotalCliente: AccountSaldo
}

export interface AccountsData {
  Clients: Record<string, AccountCliente>
  totals: AccountSaldo
}

export interface AccountsResponse {
  success: boolean
  error: string
  data: AccountsData
}

export interface AccountsRequest {
  clients: number[]
  month: number
  year: number
}

export interface NormalizedClientAccount {
  name: string
  cuentas: Record<string, AccountCuenta>
  subtotal: AccountSaldo
}

export interface NormalizedAccounts {
  clients: NormalizedClientAccount[]
  totals: AccountSaldo
}

export interface AccountsRangeRequest {
  clients: number[]
  from: string
  to: string
}
