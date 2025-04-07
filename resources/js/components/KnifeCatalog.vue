<template>
  <div>
    <h2>Каталог ножей</h2>
    <p>Баланс: {{ balance }} $</p>

    <div class="mt-4"></div>

    <div v-if="message" class="alert alert-success mt-3">{{ message }}</div>
    <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>

    <div class="row">
      <div v-for="knife in knives" :key="knife.id" class="col-md-4">
        <div class="card p-2 mb-3">
          <img :src="knife.image" alt="knife" class="card-img-top" />
          <div class="card-body">
            <h5>{{ knife.name }}</h5>
            <p>Цена: {{ knife.price }} $</p>
            <button class="btn btn-success w-100" @click="buy(knife.id)">Купить</button>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>
import axios from 'axios'
import { ref, onMounted } from 'vue'

export default {
  name: 'KnifeCatalog',
  setup() {
    const knives = ref([])
    const balance = ref(0)
    const message = ref(null)
    const error = ref(null)

    const fetchKnives = async () => {
      const res = await axios.get('/knives')
      knives.value = res.data
    }

    const fetchBalance = async () => {
      try {
        const token = localStorage.getItem('token')
        const res = await axios.get('/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        balance.value = res.data.balance
      } catch (e) {
        console.error('Ошибка при получении баланса:', e)
      }
    }

    const buy = async (id) => {
      try {
        const token = localStorage.getItem('token')
        await axios.post(
          '/buy',
          { knife_id: id },
          {
            headers: {
              Authorization: `Bearer ${token}`
            }
          }
        )
        message.value = 'Покупка успешна!'
        error.value = null
        fetchBalance()
      } catch (e) {
        error.value = e.response?.data?.message || 'Ошибка покупки'
        message.value = null
      }
    }

    onMounted(() => {
      fetchKnives()
      fetchBalance()
    })

    return {
      knives,
      buy,
      message,
      error,
      balance
    }
  }
}
</script>
