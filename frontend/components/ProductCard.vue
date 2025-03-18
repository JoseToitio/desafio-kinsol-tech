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
        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
            <img v-if="product.image" :src="product.image" alt="Imagem do Produto"
                class="w-full h-40 object-cover rounded-md mb-3" />
            <!-- Se não houver imagem, mostramos uma imagem padrão -->
            <img v-else src="" alt="Produto sem Imagem"
                class="w-full h-44 object-cover rounded-md mb-3 bg-slate-200" />

            <h2 class="text-lg font-bold text-gray-800 truncate">{{ product.name }}</h2>
            <p class="text-gray-500 text-sm truncate">{{ product.description }}</p>

            <!-- Preço de Compra -->
            <p class="text-gray-600 text-sm mt-2">
                R$ {{ Number(product.purchase_price || 0).toFixed(2) }} (Compra)
            </p>

            <!-- Preço de Venda -->
            <p class="text-gray-700 font-semibold mt-1">
                R$ {{ Number(product.sale_price || 0).toFixed(2) }} (Venda)
            </p>
        </div>
    </NuxtLink>
</template>
