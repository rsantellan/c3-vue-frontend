export interface ClientExpirationResponse {
  isvalid: boolean
  data: ClientExpirationItem[]
  razonsocial: string
}

export interface ClientExpirationItem {
  name: string
  digit: string
  year: number

  january: number
  february: number
  march: number
  april: number
  may: number
  june: number
  july: number
  august: number
  september: number
  october: number
  november: number
  december: number

  hasTaxes: boolean
}

export interface NormalizedExpirationItem {
  name: string
  digit: string
  year: number
  hasTaxes: boolean

  months: Record<string, number>
}

export interface ClientExpiration {
  razonSocial: string
  items: NormalizedExpirationItem[]
}
