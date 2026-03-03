<template>
  <UsersList
    :fetchUsers="api.getUsersBoss"
    :deleteUser="api.removeUserBoss"
    :routes="{
      show: 'boss-user-show',
      edit: 'boss-user-edit',
      permissions: 'boss-permission-edit',
    }"
  />
</template>

<script setup lang="ts">
import { api } from '@/services/api'
import UsersList from '@/components/UsersList.vue'
</script>
