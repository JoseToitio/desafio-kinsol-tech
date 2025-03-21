<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <NuxtLink :to="`/products/${product.id}`">
        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition grid grid-cols-2 gap-4">
            <!-- Coluna da Imagem -->
            <div>
                <img v-if="product.image" :src="product.image" alt="Imagem do Produto"
                    class="w-full h-40 object-cover rounded-md" />
                <img v-else src="" alt="Produto sem Imagem" class="w-full h-40 object-cover rounded-md bg-slate-200" />
            </div>

            <!-- Coluna das Informações -->
            <div class="flex flex-col justify-start">
                <h2 class="text-lg font-bold text-gray-800 truncate">{{ product.name }}</h2>
                <p class="text-gray-500 text-sm truncate">{{ product.category }}</p>

                <p class="text-gray-600 text-sm mt-2">
                    <span class="font-semibold">Compra:</span>
                    R$ {{ Number(product.purchase_price || 0).toFixed(2) }}
                </p>

                <p class="text-gray-700 font-semibold mt-1">
                    <span class="font-semibold">Venda:</span>
                    R$ {{ Number(product.sale_price || 0).toFixed(2) }}
                </p>
            </div>
        </div>
    </NuxtLink>
</template>
