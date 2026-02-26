export interface CreateTaskRequest {
  folder: string
  createdBy: string
  taskId: number
}

export interface CreateTaskResponse {
  id: number
  folder: string
  createdBy: string
  clientId: number
  clientTaskId: number
}

export interface PublicTask {
  id: number
  name: string
}

export interface UserTask {
  id: number
  name: string
  status: string
  startAt: string
  updatedAt: string
  publicComment: string | null
}

export interface RetrieveUserTasksRequest {
  user: string
  all: boolean
}
