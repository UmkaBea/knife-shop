<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Вход</h2>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            <form @submit.prevent="login">
                <div class="mb-3">
                    <label>Email</label>
                    <input v-model="email" type="email" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Пароль</label>
                    <input v-model="password" type="password" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Войти</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import {
        ref
    } from 'vue'
    import {
        useRouter
    } from 'vue-router'

    export default {
        name: 'Login',
        setup() {
            const router = useRouter()
            const email = ref('')
            const password = ref('')
            const error = ref(null)

            const login = async () => {
                error.value = null
                try {
                    await axios.get('/sanctum/csrf-cookie')

                    const response = await axios.post('/login', {
                        email: email.value,
                        password: password.value
                    })

                    localStorage.setItem('token', response.data.access_token)

                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`

                    router.push('/')
                } catch (e) {
                    error.value = e.response?.data?.message || 'Ошибка авторизации'
                }
            }

            return {
                email,
                password,
                error,
                login
            }
        }
    }

</script>
