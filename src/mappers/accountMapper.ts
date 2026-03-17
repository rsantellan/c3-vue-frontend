import type { AccountsData, AccountCuenta, AccountSaldo, NormalizedAccounts } from '@/types/accounts'

export function mapAccounts(data: AccountsData): NormalizedAccounts {
  console.log(data)
  return {
    clients: Object.entries(data.Clients).map(([name, value]) => ({
      name,
      cuentas: value.Cuentas,
      subtotal: value.SubtotalCliente,
    })),
    totals: data.totals,
  }
}
