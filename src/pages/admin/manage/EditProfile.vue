<script setup lang="ts">
import { api } from '@/services/api'
import { useRoute } from 'vue-router'
import { UserForm } from '@/types/user'
import UserEdit from '@/components/UserEdit.vue'

const route = useRoute()

const userId = Number(route.params.id)

const loadUser = (): Promise<UserForm> => api.getUserProfileById(userId)
const saveUser = (data: UserForm) => api.updateUser(userId, data)
</script>

<template>
  <UserEdit :loadUser="loadUser" :saveUser="saveUser" />

  <router-link to="/admin/users" class="btn btn-info">Volver</router-link>
</template>
