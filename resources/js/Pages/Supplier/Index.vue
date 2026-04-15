<script setup>
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import SuppliersTable from './Partials/SuppliersTable.vue';

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
            <h1 class="font-medium text-lg">Fornecedores</h1>
            <div class="d-flex justify-content-end mb-4">
                <Link href="/suppliers/create">
                    <button class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Novo Fornecedor</button>
                </Link>
            </div>
            <SuppliersTable :suppliers="suppliers"></SuppliersTable>
        </div>
    </GuestLayout>
</template>