import type { AccountsData, AccountCuenta, AccountSaldo, NormalizedAccounts } from '@/types/accounts'

export function mapAccounts(data: AccountsData): NormalizedAccounts {
  return {
    clients: Object.entries(data.Clients).map(([name, value]) => ({
      name,
      cuentas: value.Cuentas,
      subtotal: value.SubtotalCliente,
    })),
    totals: data.totals,
  }
}
