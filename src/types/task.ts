export interface CreateTaskRequest {
  folder: string
  createdBy: string
  taskId: number
  comment: string
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
  publicComment: TaskComment[]
  publicResponseComment: TaskComment[]
  files: TaskAlbum[]
  timeline?: TaskTimeLine[]
}

export interface RetrieveUserTasksRequest {
  user: string
  all: boolean
}

export interface TaskComment {
  date: string
  owner: string
  comment: string
  id: string
}

export interface TaskAlbum {
  name: string
  files: TaskFile[]
}

export interface TaskFile {
  id: number
  name: string
  owner: string
  date: string
}

export interface TaskTimeLine {
  id: number | string
  fileName: string
  owner: string
  date: string
  type: string
  comment: string
}
