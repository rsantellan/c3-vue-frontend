<template>
  <form class="login-box form-vertical" id="UserLogin" @submit.prevent="login" method="post">
    <fieldset>
      <div class="row-fluid">
        <div class="field input-prepend">
          <span class="add-on"><i class="user_ico"></i></span>
          <input
            class="login_user"
            placeholder="Usuario"
            name="UserLogin[username]"
            id="UserLogin_username"
            type="text"
            v-model="form.username"
          />
        </div>
        <div class="field input-append input-prepend">
          <span class="add-on"><i class="pass_ico"></i></span>
          <input
            class="login_pass"
            placeholder="Contraseña"
            name="UserLogin[password]"
            id="UserLogin_password"
            type="password"
            v-model="form.password"
          />
          <button class="btn btn" type="submit" name="yt0"><i class="icon-go_ico"></i></button>
        </div>
        <a
          href="http://estudiocontable.com.uy/sitio/registro.php"
          class="pass-register"
          style="
            float: left;
            text-align: left;
            font-size: 13px;
            padding-left: 14px;
            color: rgb(236, 236, 236);
            display: block;
            margin-bottom: 5px;
            line-height: 12px;
            --darkreader-inline-color: var(--darkreader-text-ececec, #dcd9d4);
          "
          data-darkreader-inline-color=""
        >
          Registrarse
        </a>
        <a class="pass-link" href="#">¿Olvidó su contraseña?</a>
      </div>
    </fieldset>
  </form>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { setAuth, setClients } from '@/auth'
import { api } from '@/services/api'

const router = useRouter()

const form = reactive({
  username: '',
  password: '',
})

const error = ref<string | null>(null)
const loading = ref(false)

async function login() {
  error.value = null
  loading.value = true

  try {
    const data = await api.login(form.username, form.password)

    // 👇 IMPORTANT: use full user object
    setAuth(data.token, data.user)
    const clientList = await api.getClients()
    setClients(clientList)
    router.push('/admin/news')
  } catch (e: any) {
    if (e.message === 'INVALID_CREDENTIALS') {
      error.value = 'Credenciales incorrectas'
    } else if (e.message === 'UNAUTHORIZED') {
      error.value = 'No autorizado'
    } else {
      error.value = 'Error del servidor'
    }
  } finally {
    loading.value = false
  }
}
</script>
