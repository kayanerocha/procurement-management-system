<script setup>
import Alert from '@/Components/Alert.vue';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import SuppliersTable from '@/Pages/Supplier/Partials/SuppliersTable.vue';
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';

const props = defineProps({
    order: Object,
});

const form = ref({
    selectedSuppliers: [],
});

const order = ref([]);
const supplier = ref([]);
const linkedSuppliers = ref([]);
const unrelatedSuppliers = ref([]);
const linkingSupplier = ref(false);
const unlinkSuppliers = ref(false);

const fetchOrder = async () => {
    try {
        const response = await axios.get(`/api/orders/${props.order.id}`);
        order.value = response.data;

        const responseSupplier = await axios.get(`/api/suppliers/${props.order.supplier_id}`);
        supplier.value = responseSupplier.data;
        
    } catch (error) {
        console.log(error);
    }
};

// const fetchLinkedSuppliers = async () => {
//     try {
//         const response = await axios.get(`/api/orders/${props.order.id}/linked-suppliers`);
//         linkedSuppliers.value = response.data;
//     } catch (error) {
//         console.log(error);
//     }
// };

// const fetchUnrelatedSuppliers = async () => {
//     try {
//         const response = await axios.get(`/api/orders/${props.order.id}/unrelated-suppliers`);
//         unrelatedSuppliers.value = response.data;
//     } catch (error) {
//         console.log(error);
//     }
// };

onMounted(() => {
    fetchOrder();
    // fetchLinkedSuppliers();
    // fetchUnrelatedSuppliers();
});

// const linkSupplier = () => {
//     linkingSupplier.value = true;
// };

const closeModal = () => {
    linkingSupplier.value = false;
};

const loading = ref(false);
const success = ref(null);

async function submit() {
    try {
        loading.value = true;
        success.value = false;

        await axios.post(`/api/orders`, form.value);

        closeModal();
        // fetchLinkedSuppliers();
        // alert('Operação enviada para processamento.');
    } catch (error) {
        errors.value = error.response?.data?.errors;
        success.value = false;
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <Head title="Editar Produto" />

    <GuestLayout>

        <Alert v-if="success == true" :message="'Fornecedores vinculados com sucesso.'" :class="'text-green-600 bg-green-100'" />
        <Alert v-if="success == false" :message="'Erro ao vincular fornecedores, entre em contato com um administrador.'" :class="'text-red-600 bg-red-100'" />

        <div>
            <div class="px-4 sm:px-0">
                <h3 class="text-base/7 font-semibold text-black">Pedido</h3>
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-400">Detalhes do pedido.</p>
            </div>
            <div class="mt-6 border-t border-white/10">
                <dl class="divide-y divide-white/10">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-600">Fornecedor</dt>
                        <dd class="mt-1 text-sm/6 text-gray-400 sm:mt-0">{{ supplier.name }}</dd>
                    </div>
                    
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-600">Observações</dt>
                        <dd class="mt-1 text-sm/6 text-gray-400 sm:col-span-2 sm:mt-0">{{ order.notes }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-600">Itens</dt>
                        <dd class="mt-2 text-sm text-gray-600 sm:col-span-2 sm:mt-0">
                            <div class="d-flex justify-content-end mb-2">
                                <button @click="linkSupplier" class="px-2 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">Vincular Parceiros</button>
                            </div>
                            <SuppliersTable :suppliers="linkedSuppliers"></SuppliersTable>
                        </dd>
                    </div>

                    <!-- <div v-if="linkingSupplier" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white rounded-lg w-full max-w-md p-6">                            
                            <h2 class="text-lg font-semibold mb-4">Vincular parceiros</h2>

                            <form @submit.prevent="submit">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dd class="mt-2 text-sm text-gray-600 sm:col-span-2 sm:mt-0">
                                        <div class="space-y-2">
                                            <label v-for="unrelatedSupplier in unrelatedSuppliers" :key="unrelatedSupplier.id" class="flex items-center gap-2">
                                                <input type="checkbox" :value="unrelatedSupplier.id" v-model="form.selectedSuppliers"/>
                                                {{ unrelatedSupplier.name }}
                                            </label>
                                        </div>
                                    </dd>
                                </div>

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="closeModal" class="px-3 py-1 border rounded">Cancelar</button>

                                    <button @click="submit" :disabled="loading" type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Salvar</button>

                                    {{ loading ? 'Salvando...' : '' }}
                                </div>
                            </form>
                        </div>
                    </div> -->
                </dl>
            </div>
        </div>

    </GuestLayout>
</template>