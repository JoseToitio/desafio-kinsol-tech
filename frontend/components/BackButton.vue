<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const goBack = () => {
    router.back();
}
</script>

<template>
    <button @click="goBack" class="mb-4 bg-gray-200 p-2 rounded">
        ← Voltar
    </button>
</template>
