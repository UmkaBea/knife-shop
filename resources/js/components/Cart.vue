<template>
    <div>
      <h2 class="mb-4">Корзина</h2>
  
      <div v-if="loading" class="text-center">Загрузка...</div>
  
      <div v-else-if="cart.length === 0" class="alert alert-info">
        Корзина пуста.
      </div>
  
      <div v-else>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Изображение</th>
              <th>Название</th>
              <th>Цена</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in cart" :key="item.id">
              <td><img :src="item.image || defaultImage" width="80" /></td>
              <td>{{ item.name }}</td>
              <td>{{ item.price }} $</td>
            </tr>
          </tbody>
        </table>
  
        <h5>Итого: {{ totalPrice }} $</h5>
        <button @click="buy" class="btn btn-success mt-3 w-100">Купить</button>
  
        <div v-if="message" class="alert alert-success mt-3">{{ message }}</div>
        <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios'
  import { ref, onMounted, computed } from 'vue'
  
  export default {
    name: 'Cart',
    setup() {
      const cart = ref([])
      const loading = ref(true)
      const message = ref(null)
      const error = ref(null)
      const defaultImage = 'https://via.placeholder.com/100x80.png?text=Knife'
  
      const fetchCart = async () => {
        try {
          const res = await axios.get('/cart')
          cart.value = res.data
        } catch (e) {
          error.value = 'Не удалось загрузить корзину'
        } finally {
          loading.value = false
        }
      }
  
      const buy = async () => {
        try {
          await axios.post('/cart/buy')
          message.value = 'Покупка прошла успешно!'
          cart.value = []
        } catch (e) {
          error.value = e.response?.data?.message || 'Ошибка при покупке'
        }
  
        setTimeout(() => {
          message.value = null
          error.value = null
        }, 3000)
      }
  
      const totalPrice = computed(() =>
        cart.value.reduce((sum, item) => sum + Number(item.price), 0).toFixed(2)
      )
  
      onMounted(() => {
        fetchCart()
      })
  
      return {
        cart,
        loading,
        message,
        error,
        buy,
        totalPrice,
        defaultImage
      }
    }
  }
  </script>
  