<template>
    <div>
      <h2 class="mb-4">Каталог ножей</h2>
  
      <div v-if="loading" class="text-center">Загрузка...</div>
      <div v-else class="row">
        <div v-for="knife in knives" :key="knife.id" class="col-md-4 mb-4">
          <div class="card h-100 knife-card text-white border-0">
            <img :src="knife.image_url || defaultImage" class="card-img-top" alt="Knife image" />
            <div class="card-body">
              <h5 class="card-title">{{ knife.name }}</h5>
              <p class="card-text">Цена: {{ knife.price }} $</p>
              <button @click="addToCart(knife.id)" class="btn btn-primary w-100">
                Добавить в корзину
              </button>
            </div>
          </div>
        </div>
      </div>
  
      <div v-if="message" class="alert alert-success mt-3">{{ message }}</div>
    </div>
  </template>

<style scoped>
.knife-card {
  background-color: #1b2838;
  color: #fff;
  border-radius: 6px;
  border: 1px solid #2a3b4f;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}
</style>

  
  <script>
  import axios from 'axios'
  import { ref, onMounted } from 'vue'
  
  export default {
    name: 'KnifeCatalog',
    setup() {
      const knives = ref([])
      const loading = ref(true)
      const message = ref(null)
      const defaultImage = 'https://via.placeholder.com/300x200.png?text=Knife'
  
      const fetchKnives = async () => {
        try {
          const res = await axios.get('/knives')
          knives.value = res.data
        } catch (e) {
          console.error('Ошибка при загрузке ножей:', e)
        } finally {
          loading.value = false
        }
      }
  
      const addToCart = async (knifeId) => {
        try {
          await axios.post('/cart', { knife_id: knifeId })
          message.value = 'Нож добавлен в корзину!'
          setTimeout(() => (message.value = null), 3000)
        } catch (e) {
          message.value = 'Ошибка: возможно, вы не авторизованы'
          setTimeout(() => (message.value = null), 3000)
        }
      }
  
      onMounted(() => {
        fetchKnives()
      })
  
      return { knives, loading, message, addToCart, defaultImage }
    }
  }
  </script>
  