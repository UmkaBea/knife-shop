<template>
    <div>
        <h2 class="mb-4">Мой инвентарь</h2>

        <div v-if="inventory.length === 0" class="alert alert-info">
            Вы ещё не купили ни одного ножа.
        </div>

        <div class="row">
            <div v-for="knife in inventory" :key="knife.id" class="col-md-4 mb-4">
                <div class="card h-100">
                    <img :src="knife.image || defaultImage" class="card-img-top" />
                    <div class="card-body">
                        <h5 class="card-title">{{ knife.name }}</h5>
                        <p class="card-text">Цена: {{ knife.price }} $</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import {
        ref,
        onMounted
    } from 'vue'

    export default {
        name: 'Inventory',
        setup() {
            const inventory = ref([])
            const defaultImage = '/knives_img/default.png'

            const fetchInventory = async () => {
                try {
                    const token = localStorage.getItem('token')
                    const res = await axios.get('/inventory', {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    })
                    console.log('Ответ от сервера:', res.data)
                    inventory.value = res.data
                } catch (e) {
                    console.error('Ошибка загрузки инвентаря:', e)
                }
            }

            onMounted(fetchInventory)

            return {
                inventory,
                defaultImage
            }
        }
    }

</script>
