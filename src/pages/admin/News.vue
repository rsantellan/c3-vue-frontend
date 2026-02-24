<template>
  <article class="main">
    <div v-if="loading">Cargando...</div>
    <div v-else-if="error">{{ error }}</div>
    <template v-else>
      <section v-for="item in news" :key="item.id">
        <div class="title_client_blog">
          <h4>
            <a style="float: left" class="arrow" @click.prevent="toggle(item.id)"></a>
            {{ item.title }}
          </h4>
        </div>
        <div v-show="openItems[item.id]" class="content_blog">
          <p v-html="item.content"></p>
          <span style="font-size: 10px">{{ item.author }} @ {{ item.date }}</span>
          <hr />
        </div>
      </section>
    </template>
  </article>
</template>
<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { api } from '@/services/api'
import { NewsResponse } from '@/types/news'

const openItems = ref<Record<string, boolean>>({})
const news = ref<any[]>([])
const loading = ref(true)
const error = ref<string | null>(null)

function toggle(id: string) {
  openItems.value[id] = !openItems.value[id]
}

onMounted(async () => {
  try {
    const response: NewsResponse = await api.getNews()
    news.value = response.news
  } catch (e) {
    error.value = 'Error cargando noticias'
  } finally {
    loading.value = false
  }
})
</script>
<style>
.content_blog {
  transition: all 0.3s ease;
}
</style>
