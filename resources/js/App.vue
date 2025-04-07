<template>
  <div class="app-wrapper text-white min-vh-100">
    <nav class="p-3">
      <router-link class="btn btn-outline-light me-2" to="/">Каталог</router-link>
      <router-link class="btn btn-outline-light me-2" to="/inventory">Инвентарь</router-link>
      <router-link class="btn btn-outline-light me-2" to="/login">Вход</router-link>
      <router-link class="btn btn-outline-light me-2" to="/register">Регистрация</router-link>
      <button class="btn btn-outline-danger me-2" @click="logout">Выйти</button>
    </nav>

    <div class="container py-4">
      <router-view />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()

    const logout = async () => {
      try {
        await axios.post('/logout', {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        localStorage.removeItem('token')
        router.push('/login')
      } catch (e) {
        console.error('Ошибка при выходе', e)
      }
    }

    return {
      logout
    }
  }
}
</script>

<style>
.app-wrapper {
  background-color: #171a21;
  min-height: 100vh;
}
</style>
