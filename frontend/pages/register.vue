<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const name = ref('');
const email = ref('');
const password = ref('');
const errorMessage = ref('');
const router = useRouter();

async function register() {
    const { $api } = useNuxtApp();

    try {
        const response = await $api.post('/auth/register', {
            name: name.value,
            email: email.value,
            password: password.value,
        });
        if (response) {
            router.push('/login');
        } else {
            errorMessage.value = 'Erro ao registrar usuário, tente novamente.';
        }
    } catch (error) {
        errorMessage.value = 'Erro no registro: ' + (error.response?.message || error.message || 'Tente novamente.');
    }
}
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Criar Conta</h2>
            <form @submit.prevent="register" class="space-y-4">
                <div>
                    <input v-model="name" type="text" placeholder="Nome" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <input v-model="email" type="email" placeholder="Email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <input v-model="password" type="password" placeholder="Senha" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Registrar
                </button>
            </form>

            <div v-if="errorMessage" class="text-red-600 text-center mt-4">
                {{ errorMessage }}
            </div>

            <p class="text-center text-gray-600 mt-4">
                Já tem uma conta?
                <NuxtLink to="/login" class="text-blue-600 hover:underline">Faça login</NuxtLink>
            </p>
        </div>
    </div>
</template>
