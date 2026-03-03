<template>
  <CreateUserForm
    :loadStatus="api.getUserStatusOptions"
    :loadGroups="emptyGroupsLoader"
    :loadClients="api.getAdminClientsBoss"
    :submitUser="api.createUserBoss"
    :forceClients="true"
  />
</template>

<script setup lang="ts">
import { api } from '@/services/api'
import CreateUserForm from '@/components/CreateUserForm.vue'
const emptyGroupsLoader = () => Promise.resolve([])
</script>
