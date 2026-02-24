import { MonthAmountResponse, NormalizedMonthAmount } from '@/types/monthAmount'

export function mapMonthAmount(response: MonthAmountResponse): NormalizedMonthAmount {
  return {
    clients: Object.values(response.data || {}),
  }
}
