<script setup>
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';

const props = defineProps({
    products: Array,
});

function exportXLSXFile() {
    if (!props.products || props.products.length === 0) {
        alert('Nenhum produto disponível para exportação!');
        return;
    }

    const data = props.products.map(product => ({
        ID: product.id,
        Nome: product.name,
        Imagem: product.image || 'Sem imagem',
        Categoria: product.category,
        PreçoVenda: product.sale_price,
        PreçoCompra: product.purchase_price,
    }));

    const ws = XLSX.utils.json_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Produtos');

    const xlsxBuffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
    const file = new Blob([xlsxBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

    saveAs(file, 'lista_de_produtos.xlsx');
}
</script>


<template>
    <client-only>
        <button @click="exportXLSXFile" class="bg-green-500 text-white px-4 py-2 rounded-md shadow hover:bg-green-600 mb-4">
            Exportar para XLSX
        </button>
    </client-only>
</template>