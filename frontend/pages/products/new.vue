<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import BackButton from '~/components/BackButton.vue';

const { $api } = useNuxtApp();
const router = useRouter();

const product = ref({
    name: '',
    description: null,
    image: null,
    category: '',
    purchase_price: null,
    sale_price: null,
});

async function saveProduct() {
    try {
        await $api.post('/products', product.value);

        router.push('/');
    } catch (error) {
        console.error('Erro ao salvar produto:', error.response || error.message || error);
    }
}
</script>

<template>
    <div class="container mx-auto p-4">
        <BackButton></BackButton>

        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
            <h1 class="text-2xl font-bold mb-6 text-center">Novo Produto</h1>

            <form @submit.prevent="saveProduct" class="space-y-4">
                <input v-model="product.name" placeholder="Nome do Produto" required
                    class="w-full p-2 border border-gray-300 rounded-md" />

                <textarea v-model="product.description" placeholder="Descrição (opcional)"
                    class="w-full p-2 border border-gray-300 rounded-md"></textarea>

                <input v-model="product.image" placeholder="URL da Imagem (opcional)"
                    class="w-full p-2 border border-gray-300 rounded-md" />

                <input v-model="product.category" placeholder="Categoria" required
                    class="w-full p-2 border border-gray-300 rounded-md" />

                <input v-model="product.purchase_price" placeholder="Preço de Compra" type="number" required
                    class="w-full p-2 border border-gray-300 rounded-md" />

                <input v-model="product.sale_price" placeholder="Preço de Venda" type="number" required
                    class="w-full p-2 border border-gray-300 rounded-md" />

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                    💾 Salvar Produto
                </button>
            </form>

    </div>
    </div>
</template>
