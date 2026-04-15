<script setup>
import Alert from '@/Components/Alert.vue';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Link } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from 'vue';

const form = ref({
    supplier_id: null,
    notes: '',
});

const errors = ref({
    supplier_id: null,
    notes: null,
});

const loading = ref(false);
const success = ref(null);
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
});

async function submit() {
    try {
        loading.value = true;

        await axios.post('/api/orders', form.value);

        form.value.supplier_id = null;
        form.value.notes = '';

        errors.value.supplier_id = null;
        errors.value.notes = null;

        success.value = true;
    } catch (error) {
        errors.value = error.response?.data?.errors;
        if (!errors.value) {
            success.value = false;
        }
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <Head title="Criar Pedido" />

    <GuestLayout>

        <Alert v-if="success == true" :message="'Pedido criado com sucesso.'" :class="'text-green-600 bg-green-100'" />
        <Alert v-if="success == false" :message="'Erro ao criar pedido, entre em contato com um administrador.'" :class="'text-red-600 bg-red-100'" />

        <form @submit.prevent="submit">
            <div class="space-y-12">
                <div class="border-b border-white/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-black">Pedido</h2>
                    <p class="mt-1 text-sm/6 text-gray-400">Preencha as informações sobre o pedido.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <InputLabel for="supplier_id" value="Fornecedor" />
                            <div class="mt-2 grid grid-cols-1">
                                <select id="supplier_id" name="supplier_id" autocomplete="supplier_id" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="form.supplier_id">
                                    <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="errors.supplier_id?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="notes" value="Observações" />
                            <div class="mt-2">
                                <textarea id="notes" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="form.notes" required>
                                </textarea>
                                <InputError class="mt-2" :message="errors.notes?.[0]" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <Link href="/orders">
                    <button type="button" class="text-sm/6 font-semibold text-gray-400">Cancelar</button>
                </Link>
                <button type="submit" class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">Salvar</button>
            </div>
        </form>
    </GuestLayout>
</template>