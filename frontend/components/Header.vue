<script setup>
import { useRouter } from 'vue-router';
import { ref, computed, watch, onMounted } from 'vue';

const router = useRouter();
const user = ref({});
const { $api } = useNuxtApp();
const token = useState('token', () => null);
const isAuthenticated = computed(() => !!token.value);
async function fetchUser() {
    if (!token.value) return

    try {
        const data = await $api.post('/auth/me');
        user.value = data;
    } catch (error) {
        console.error('Erro ao buscar usuário:', error);
        logout();
    }
}

async function logout() {
    await $api.get('/logout');
    localStorage.removeItem('token');
    token.value = null;
    router.push('/login');
}

watch(token, async (newToken) => {
    if (newToken) {
        await fetchUser();
    }
});
onMounted(() => {
    if (typeof window !== 'undefined') {
        token.value = localStorage.getItem('token');
        if (token.value) {
            fetchUser();
        }
    }
});

</script>

<template>
    <header class="bg-blue-600 text-white shadow-md py-4 px-6 flex  ">
        <div class="container mx-auto flex items-center justify-between">
            <div class="text-xl font-bold">
                <NuxtLink to="/" class="hover:text-gray-200">Store API</NuxtLink>
            </div>

            <nav class="space-x-4 flex items-center">
                <NuxtLink to="/products/new" class="hover:text-gray-200">Novo Produto</NuxtLink>
                <!-- Se usuário estiver logado, mostra nome e botão de sair -->
                <div v-if="isAuthenticated" class="flex items-center 78ujknspace-x-4 gap-3">
                    <NuxtLink class="font-semibold hover:text-gray-200" to="/profile">👤 {{ user?.name || 'Usuário' }}
                    </NuxtLink>
                    <button @click="logout" class="bg-red-500 px-4 py-1 rounded-md hover:bg-red-600 transition">
                        Sair
                    </button>
                </div>

                <!-- Se NÃO estiver logado, mostra botões de Login e Cadastro -->
                <div v-else class="flex space-x-4">
                    <NuxtLink to="/login" class="bg-green-500 px-4 py-2 rounded-md hover:bg-green-600 transition">
                        Entrar
                    </NuxtLink>
                    <NuxtLink to="/register" class="bg-yellow-500 px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                        Registrar
                    </NuxtLink>
                </div>
            </nav>
        </div>
    </header>
</template>
