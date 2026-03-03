<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { api } from '@/services/api'
import UserProfileView from '@/components/UserProfileView.vue'
import { UserProfile } from '@/types/profile'

const route = useRoute()

const profile = ref<UserProfile | null>(null)
const loading = ref(false)
const error = ref(null)

onMounted(async () => {
  loading.value = true
  try {
    profile.value = await api.getUserProfileByIdBoss(Number(route.params.id as string))
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <UserProfileView :profile="profile" :loading="loading" :error="error" />

  <router-link to="/admin/boss/users" class="btn btn-info">Volver</router-link>
</template>
