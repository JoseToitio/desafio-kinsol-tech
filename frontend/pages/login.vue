<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const email = ref('');
const password = ref('');
const router = useRouter(); 
const { $api } = useNuxtApp();
const token = useState('token', () => null);

async function login() {

  try {
    const response = await $api.post('/auth/login', { email: email.value, password: password.value });
    if (response?.access_token) {
      token.value = response.access_token;
      localStorage.setItem('token', response.access_token);
      router.push('/');
    } else {
      console.error('Login falhou, token não retornado');
    }
  } catch (error) {
    console.error('Erro no login:', error.response || error.message || error);
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-96">
      <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login</h2>

      <!-- Formulário de Login -->
      <div class="space-y-4">
        <!-- Campo de Email -->
        <div>
          <label for="email" class="block text-gray-600 font-medium">Email</label>
          <input
            v-model="email"
            id="email"
            type="email"
            placeholder="Digite seu email"
            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <!-- Campo de Senha -->
        <div>
          <label for="password" class="block text-gray-600 font-medium">Senha</label>
          <input
            v-model="password"
            id="password"
            type="password"
            placeholder="Digite sua senha"
            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <!-- Botão de Login -->
        <div>
          <button
            @click="login"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Entrar
          </button>
        </div>

        <!-- Link para registro -->
        <div class="text-center mt-4">
          <span class="text-gray-600">Não tem uma conta? </span>
          <router-link to="/register" class="text-blue-600 hover:text-blue-700">Cadastre-se</router-link>
        </div>
      </div>
    </div>
  </div>
</template>
