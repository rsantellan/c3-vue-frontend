export interface MonthAmountResponse {
  isvalid: boolean
  data: Record<string, ClientMonthData>
}

// --- Client ---
export interface ClientMonthData {
  calendar: CalendarItem[]
  client: ClientInfo
}

export interface ClientInfo {
  id: number
  carpeta: string
  razonsocial: string
}

// --- Calendar ---
export interface CalendarItem {
  id: number
  name: string
  review: boolean
  month: string
  taxes: boolean
  payments: Payment[]
  day: number
}

// --- Payments ---
export interface Payment {
  whopays: number
  amountWithTaxes: number
  notes: string | null
  createdat: string
  updatedat: string
  paid: boolean
  notconfirmed: boolean
  notpayment: boolean
  notified: boolean
  reviewed: boolean
  taxes: PaymentTax[]
  status: number
}

export interface PaymentTax {
  name: string
  amount: string
}

export interface NormalizedMonthAmount {
  clients: ClientMonthData[]
}
