<template>
  <UserPermission
    :userId="userId"
    :getPermissionTypes="api.getPermissionTypes"
    :getClients="api.getAdminClientsBoss"
    :getUserPermissions="api.getUserPermissionsBoss"
    :assignPermission="api.assignPermissionBoss"
    :removePermission="api.removePermissionBoss"
  />
</template>

<script setup lang="ts">
import { api } from '@/services/api'
import { useRoute } from 'vue-router'
import UserPermission from '@/components/UserPermission.vue'

const route = useRoute()

const userId = Number(route.params.id)
</script>
