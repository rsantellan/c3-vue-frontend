<template>
  <UserPermission
    :userId="userId"
    :getPermissionTypes="api.getPermissionTypes"
    :getClients="api.getAdminClients"
    :getUserPermissions="api.getUserPermissions"
    :assignPermission="api.assignPermission"
    :removePermission="api.removePermission"
  />
</template>

<script setup lang="ts">
import { api } from '@/services/api'
import { useRoute } from 'vue-router'
import { UserForm } from '@/types/user'
import UserPermission from '@/components/UserPermission.vue'

const route = useRoute()

const userId = Number(route.params.id)
</script>
