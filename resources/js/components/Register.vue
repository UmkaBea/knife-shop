<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Регистрация</h2>
            <div v-if="error" class="alert alert-danger">{{ error }}</div>
            <form @submit.prevent="register">
                <div class="mb-3">
                    <label>Имя</label>
                    <input v-model="name" type="text" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input v-model="email" type="email" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Пароль</label>
                    <input v-model="password" type="password" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label>Подтвердите пароль</label>
                    <input v-model="password_confirmation" type="password" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { ref } from 'vue'
    import {
        useRouter
    } from 'vue-router'

    export default {
        name: 'Register',
        setup() {
            const router = useRouter()

            const name = ref('')
            const email = ref('')
            const password = ref('')
            const password_confirmation = ref('')
            const error = ref(null)

            const register = async () => {
                error.value = null
                try {
                    await axios.post('/register', {
                        name: name.value,
                        email: email.value,
                        password: password.value,
                        password_confirmation: password_confirmation.value
                    })
                    router.push('/login')
                } catch (e) {
                    error.value = e.response?.data ?.message || 'Ошибка регистрации'
                }
            }

            return {
                name,
                email,
                password,
                password_confirmation,
                error,
                register
            }
        }
    }

</script>
