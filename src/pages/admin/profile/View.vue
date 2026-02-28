<template>
  <UserProfileView :profile="profile" :loading="loading" :error="error" />
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { api } from '@/services/api'
import type { UserProfile } from '@/types/profile'
import UserProfileView from '@/components/UserProfileView.vue'

const profile = ref<UserProfile | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)

onMounted(async () => {
  loading.value = true
  try {
    profile.value = await api.getProfile()
  } catch (e) {
    console.log(e)
    error.value = 'Error cargando perfil'
  } finally {
    loading.value = false
  }
})
</script>
