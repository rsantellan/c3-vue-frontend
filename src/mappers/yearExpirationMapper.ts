import { ClientExpirationItem, NormalizedExpirationItem } from '@/types/yearExpiration'

export function mapExpiration(data: ClientExpirationItem[]): NormalizedExpirationItem[] {
  return data.map((item) => ({
    name: item.name,
    digit: item.digit,
    year: item.year,
    hasTaxes: item.hasTaxes,
    months: {
      january: item.january,
      february: item.february,
      march: item.march,
      april: item.april,
      may: item.may,
      june: item.june,
      july: item.july,
      august: item.august,
      september: item.september,
      october: item.october,
      november: item.november,
      december: item.december,
    },
  }))
}
