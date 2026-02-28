<template>
  <UserEdit :loadUser="loadUser" :saveUser="saveUser" @saved="logout" />
</template>

<script setup lang="ts">
import { api } from '@/services/api'
import { clearToken } from '@/auth'
import { useRouter } from 'vue-router'

import { UserForm } from '@/types/user'
import UserEdit from '@/components/UserEdit.vue'

const router = useRouter()

const loadUser = (): Promise<UserForm> => api.getProfile()
const saveUser = (data: UserForm) => api.updateProfile(data)

function logout() {
  clearToken()
  router.push('/login')
}
</script>
