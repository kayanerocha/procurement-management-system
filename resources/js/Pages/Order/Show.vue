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
                </dl>
            </div>
        </div>

    </GuestLayout>
</template>