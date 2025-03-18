<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import BackButton from '~/components/BackButton.vue';

const route = useRoute();
const router = useRouter();

const product = ref({
    name: '',
    description: '',
    sale_price: 0,
    purchase_price: 0,
    category: '',
    image: ''
});
const errorMessage = ref('');
const successMessage = ref('');
const { $api } = useNuxtApp();

const fetchProduct = async () => {
    try {
        const { data, error } = await $api.get(`/products/${route.params.id}`);
        if (error.value) {
            errorMessage.value = 'Produto não encontrado.';
        } else {
            product.value = data.value;
        }
    } catch (err) {
        errorMessage.value = 'Erro ao carregar o produto.';
    }
};

const updateProduct = async () => {
    try {
        const data = await $api.put(`/products/${route.params.id}`, product.value);
        if (!data) {
            errorMessage.value = 'Erro ao salvar as alterações.';
        } else {
            successMessage.value = 'Produto atualizado com sucesso!';
            router.push('/');
        }
    } catch (err) {
        errorMessage.value = 'Erro ao salvar as alterações.';
    }
};

onMounted(() => {
    fetchProduct();
});
</script>

<template>
    <div class="container mx-auto p-4">
        <BackButton />

        <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
        <div v-if="successMessage" class="text-green-500">{{ successMessage }}</div>

        <div v-if="product" class="border p-4 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">Editar Produto</h1>

            <form @submit.prevent="updateProduct">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                    <input v-model="product.name" type="text" class="mt-1 p-2 w-full border rounded" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                    <textarea v-model="product.description" class="mt-1 p-2 w-full border rounded" ></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Preço de Venda</label>
                    <input v-model="product.sale_price" type="number" class="mt-1 p-2 w-full border rounded" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Preço de Compra</label>
                    <input v-model="product.purchase_price" type="number" class="mt-1 p-2 w-full border rounded"
                        required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Categoria</label>
                    <input v-model="product.category" type="text" class="mt-1 p-2 w-full border rounded" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Imagem (Opcional)</label>
                    <input v-model="product.image" type="text" class="mt-1 p-2 w-full border rounded" />
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Salvar Alterações
                </button>
            </form>
        </div>
    </div>
</template>
