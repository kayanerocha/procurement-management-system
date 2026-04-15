<script setup>
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const suppliers = ref([]);

const fetchSuppliers = async () => {
    try {
        const response = await axios.get('/api/suppliers');
        suppliers.value = response.data;
    } catch (error) {
        console.log(error);
    }
};

onMounted(() => {
    fetchSuppliers();
})

</script>

<template>
    <Head title="Fornecedores" />

    <GuestLayout>
        <div class="container mt-10">
            <h1>Fornecedores</h1>
            <div class="d-flex justify-content-end mb-4">
                <Link href="/suppliers/create">
                    <button class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Novo Fornecedor</button>
                </Link>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="supplier in suppliers">
                        <td class="px-6 py-4 whitespace-nowrap">{{ supplier.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ supplier.cnpj }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ supplier.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ supplier.phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span v-if="supplier.status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativado</span>
                            <span v-if="!supplier.status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Desativado</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <Link :href="route('suppliers.edit', { supplier: supplier })">
                                <button class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Editar</button>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </GuestLayout>
</template>