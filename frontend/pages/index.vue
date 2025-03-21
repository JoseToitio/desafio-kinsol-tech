<script setup>
import { ref } from 'vue';
import FilterComponent from '~/components/FilterComponent.vue';
import ProductCard from '~/components/ProductCard.vue';
import ExportXlsxFile from '~/components/ExportXlsxFile.vue';
const { $api } = useNuxtApp();
const token = useState('token', () => null);
const isAuthenticated = computed(() => !!token.value);

const products = ref([]);
const filteredProducts = ref([]);
const status = ref('loading');

const filters = ref({
  name: '',
  category: '',
  minPrice: '',
  maxPrice: '',
});

async function fetchProducts() {
  try {
    const { data } = await $api.get('/products');
    products.value = data.value;
    filteredProducts.value = data.value;
    status.value = 'loaded';
  } catch (error) {
    console.error('Erro ao carregar produtos:', error);
    status.value = 'error';
  }
}

function applyFilters(newFilters) {
  filters.value = { ...filters.value, ...newFilters };

  let filtered = products.value;

  if (filters.value.name) {
    filtered = filtered.filter(product =>
      product.name.toLowerCase().includes(filters.value.name.toLowerCase())
    );
  }

  if (filters.value.category) {
    filtered = filtered.filter(product =>
      product.category.toLowerCase() === filters.value.category.toLowerCase()
    );
  }

  // Filtro por faixa de preço (somente para visitantes)
  if (!isAuthenticated.value) {
    const minPrice = parseFloat(filters.value.minPrice);
    const maxPrice = parseFloat(filters.value.maxPrice);

    filtered = filtered.filter(product => {
      const price = product.sale_price;

      const meetsMin = isNaN(minPrice) || price >= minPrice;
      const meetsMax = isNaN(maxPrice) || price <= maxPrice;

      return meetsMin && meetsMax;
    });
  }

  filteredProducts.value = filtered;
}

fetchProducts();
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <main class="container mx-auto p-6">
      <h1 class="text-2xl font-bold mb-4">Lista de Produtos</h1>

      <!-- Botão de Exportação -->
      <ExportXlsxFile v-if="filteredProducts.length" :products="filteredProducts" class="mb-3" />

      <!-- Componente de Filtro -->
      <FilterComponent @updateFilters="applyFilters" />

      <!-- Status de Carregamento -->
      <div v-if="status === 'loading'" class="mt-4 text-gray-700">Carregando...</div>
      <div v-else-if="status === 'error'" class="mt-4 text-red-500">Erro ao carregar produtos</div>

      <!-- Exibição dos Produtos -->
      <div v-else>
        <p v-if="filteredProducts.length === 0" class="text-center text-gray-500 mt-6">
          Nenhum produto encontrado.
        </p>

        <!-- Grid de Produtos -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
          <ProductCard v-for="product in filteredProducts" :key="product.id" :product="product" />
        </div>
      </div>
    </main>
  </div>
</template>
