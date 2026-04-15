<script setup>
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const products = ref([]);

const fetchProducts = async () => {
    try {
        const response = await axios.get('/api/products');
        products.value = response.data;
    } catch (error) {
        console.log(error);
    }
};

onMounted(() => {
    fetchProducts();
})

</script>

<template>
    <Head title="Produtos" />

    <GuestLayout>
        <div class="container mt-10">
            <h1 class="font-medium text-lg">Produtos</h1>
            <div class="d-flex justify-content-end mb-4">
                <Link href="/products/create">
                    <button class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Novo Produto</button>
                </Link>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código Interno</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="product in products">
                        <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ product.internal_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span v-if="product.status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativado</span>
                            <span v-if="!product.status" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Desativado</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <Link :href="route('products.edit', { product: product })">
                                <button class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Editar</button>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </GuestLayout>
</template>