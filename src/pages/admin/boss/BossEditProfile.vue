<script setup lang="ts">
import { api } from '@/services/api'
import { useRoute } from 'vue-router'
import { UserForm } from '@/types/user'
import UserEdit from '@/components/UserEdit.vue'

const route = useRoute()

const userId = Number(route.params.id)

const loadUser = (): Promise<UserForm> => api.getUserProfileByIdBoss(userId)
const saveUser = (data: UserForm) => api.updateUserBoss(userId, data)
</script>

<template>
  <UserEdit :loadUser="loadUser" :saveUser="saveUser" />

  <router-link to="/admin/boss/users" class="btn btn-info">Volver</router-link>
</template>
