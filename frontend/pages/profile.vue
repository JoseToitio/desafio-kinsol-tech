<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import BackButton from "~/components/BackButton.vue";

const name = ref("");
const email = ref("");
const currentPassword = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const errorMessage = ref("");
const successMessage = ref("");
const showDeleteConfirmation = ref(false);
const router = useRouter();
const { $api } = useNuxtApp();

async function fetchUserProfile() {

    try {
        const response = await $api.post("/auth/me");
        name.value = response?.name || "";
        email.value = response?.email || "";
    } catch (error) {
        console.error("Erro ao buscar perfil do usuário:", error);
        errorMessage.value = "Erro ao carregar os dados do perfil.";
    }
}

async function updateProfile() {
    if (password.value && password.value !== passwordConfirmation.value) {
        errorMessage.value = "As senhas não coincidem.";
        return;
    }

    const profileData = {
        name: name.value,
        current_password: currentPassword.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
    };

    try {
        const response = await $api.put(
            "/user",
            profileData
        );
        if (response?.user) {
            successMessage.value = "Perfil atualizado com sucesso!";
            router.push("/");
        }
    } catch (error) {
        errorMessage.value = "Erro ao atualizar perfil.";
    }
}
async function deleteUser() {

    try {
        const response = await $api.delete('/user');

        if (response) {
            localStorage.removeItem('token');
            router.push('/login');
        }
    } catch (error) {
        console.error('Erro ao remover o usuário:', error);
        errorMessage.value = 'Erro ao remover a conta.';
    }
}

fetchUserProfile();
</script>

<template>
    <div class="container mx-auto p-4">
        <BackButton></BackButton>

        <div class="max-w-2xl bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Perfil do Usuário</h2>

            <!-- Mensagem de sucesso ou erro -->
            <div v-if="errorMessage" class="text-red-600 mb-4">
                {{ errorMessage }}
            </div>
            <div v-if="successMessage" class="text-green-600 mb-4">
                {{ successMessage }}
            </div>

            <!-- Formulário para editar o nome -->
            <div class="mb-4">
                <label for="name" class="block text-gray-600 font-medium">Nome</label>
                <input v-model="name" id="name" type="text" placeholder="Seu nome"
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required />
            </div>

            <!-- Formulário para editar o email (opcional) -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-medium">Email</label>
                <input v-model="email" id="email" type="email" placeholder="Seu email"
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    disabled />
            </div>

            <!-- Formulário para alterar a senha -->
            <div class="mb-4">
                <label for="currentPassword" class="block text-gray-600 font-medium">Senha Atual</label>
                <input v-model="currentPassword" id="currentPassword" type="password"
                    placeholder="Digite sua senha atual"
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-medium">Nova Senha</label>
                <input v-model="password" id="password" type="password" placeholder="Digite a nova senha"
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <div class="mb-6">
                <label for="passwordConfirmation" class="block text-gray-600 font-medium">Confirmar Nova Senha</label>
                <input v-model="passwordConfirmation" id="passwordConfirmation" type="password"
                    placeholder="Confirme a nova senha"
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <button @click="updateProfile"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Salvar Alterações
            </button>

            <!-- Botão para excluir a conta -->
            <div v-if="!showDeleteConfirmation" class="mt-6">
                <button @click="showDeleteConfirmation = true"
                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Excluir Conta
                </button>
            </div>

            <!-- Confirmação de Exclusão -->
            <div v-if="showDeleteConfirmation" class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-yellow-600">Tem certeza de que deseja excluir sua conta? Esta ação não pode ser desfeita.
                </p>
                <div class="flex space-x-4 mt-4">
                    <button @click="deleteUser"
                        class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Sim, excluir conta
                    </button>
                    <button @click="showDeleteConfirmation = false"
                        class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>