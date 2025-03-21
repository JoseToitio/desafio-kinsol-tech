<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['updateFilters']);
const token = useState('token', () => null);
const isAuthenticated = computed(() => !!token.value);
const nameFilter = ref('');
const categoryFilter = ref('');
const minPriceFilter = ref(null);
const maxPriceFilter = ref(null);

function applyFilters() {
    emit('updateFilters', {
        name: nameFilter.value,
        category: categoryFilter.value,
        minPrice: minPriceFilter.value,
        maxPrice: maxPriceFilter.value,
    });
}

</script>

<template>
    <div class="flex gap-4 mb-4">
        <!-- Filtro de Nome -->
        <input v-model="nameFilter" placeholder="Buscar por nome" class="border px-4 py-2 rounded-md w-1/4"
            @input="applyFilters" />

        <!-- Filtro de Categoria -->
        <select v-model="categoryFilter" class="border px-4 py-2 rounded-md w-1/4" @change="applyFilters">
            <option value="">Filtrar por categoria</option>
            <option value="Eletrônicos">Eletrônicos</option>
            <option value="roupas">Roupas</option>
            <option value="acessorios">Acessórios</option>
        </select>

        <!-- Filtros de Faixa de Preço (para visitantes) -->
        <div v-if="!isAuthenticated" class="flex gap-4">
            <input v-model="minPriceFilter" type="number" placeholder="Preço mínimo"
                class="border px-4 py-2 rounded-md w-auto" @input="applyFilters" />
            <input v-model="maxPriceFilter" type="number" placeholder="Preço máximo"
                class="border px-4 py-2 rounded-md w-auto" @input="applyFilters" />
        </div>
    </div>
</template>
