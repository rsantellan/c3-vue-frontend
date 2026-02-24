<template>
  <section>
    <article class="main">
      <div class="hgroup">
        <h1>Contacto</h1>
      </div>
      <section>
        <p>
          Para entrar en contacto directo con el estudio puede utilizar cualquiera de las opciones que se presentan en
          esta página:
        </p>
        <div class="row-fluid">
          <div class="span5">
            <div class="contact-box">
              <h4>Envíenos un mensaje</h4>

              <form class="form-vertical" id="contact-form" @submit.prevent="submit" method="post">
                <fieldset>
                  <input
                    class="mtxt"
                    placeholder="Su nombre completo"
                    name="ContactForm[name]"
                    id="ContactForm_name"
                    type="text"
                    v-model="form.name"
                  />
                  <span class="text-error" id="ContactForm_name_em_" style="display: none"></span>
                  <input
                    class="mtxt"
                    placeholder="Teléfono"
                    name="ContactForm[phone]"
                    id="ContactForm_phone"
                    type="text"
                    v-model="form.phone"
                  />
                  <span class="text-error" id="ContactForm_phone_em_" style="display: none"></span>
                  <input
                    class="mtxt"
                    placeholder="E-Mail"
                    name="ContactForm[email]"
                    id="ContactForm_email"
                    type="text"
                    v-model="form.email"
                  />
                  <span class="text-error" id="ContactForm_email_em_" style="display: none"></span>
                  <textarea
                    maxlength="300"
                    rows="5"
                    class="ltxt"
                    placeholder="Su mensaje..."
                    name="ContactForm[body]"
                    id="ContactForm_body"
                    v-model="form.message"
                  ></textarea>
                  <span class="text-error" id="ContactForm_body_em_" style="display: none"></span>
                  <input
                    id="newsletter_input"
                    type="checkbox"
                    value="1"
                    name="ContactForm[newsletter]"
                    tabindex="-1"
                    autocomplete="off"
                    style="display: none"
                    v-model="form.newsletter"
                  />
                  <div class="btns">
                    <button class="btn btn-contact btn" type="submit" name="yt0">Enviar</button>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
          <div class="span7"></div>
        </div>
      </section>
    </article>
  </section>
</template>

<script setup lang="ts">
import { reactive } from 'vue'

const form = reactive({
  name: '',
  email: '',
  message: '',
  newsletter: '',
  phone: '',
})

function submit() {
  alert('Formulario enviado (simulado)')
}
</script>
