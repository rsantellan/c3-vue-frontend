export interface News {
  id: string
  title: string
  content: string
  author?: string
  date?: string
}

export interface NewsResponse {
  success: boolean
  news: News[]
}
