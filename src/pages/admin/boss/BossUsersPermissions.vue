<template>
  <UserPermissionList
    title="Usuarios y Permisos"
    :fetchFunction="api.getUsersWithPermissionsBoss"
    :getUserLink="(id) => ({ name: 'admin-user-edit', params: { id } })"
  />
</template>

<script setup lang="ts">
import { api } from '@/services/api'
import UserPermissionList from '@/components/UserPermissionList.vue'
</script>
