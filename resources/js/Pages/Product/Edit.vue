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

const props = defineProps({
    product: Object,
});

const form = ref({
    name: '',
    description: '',
    internal_code: '',
    status: '',
});

const product = ref([]);

const fetchProduct = async () => {
    try {
        const response = await axios.get(`/api/products/${props.product.id}`);
        form.value.name = response.data.name;
        form.value.description = response.data.description;
        form.value.internal_code = response.data.internal_code;
        form.value.status = response.data.status ? '1' : '0';
        product.value = response.data;
    } catch (error) {
        console.log(error);
    }
};

onMounted(() => {
    fetchProduct();
})

const errors = ref({
    name: null,
    description: null,
    internal_code: null,
    status: null,
});

const loading = ref(false);
const success = ref(null);

async function update() {
    try {
        loading.value = true;
        success.value = false;

        await axios.put(`/api/products/${product.value.id}`, form.value);

        errors.value.name = null;
        errors.value.description = null;
        errors.value.internal_code = null;
        errors.value.status = null;

        success.value = true;
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

        <Alert v-if="success == true" :message="'Produto atualizado com sucesso.'" :class="'text-green-600 bg-green-100'" />
        <Alert v-if="success == false" :message="'Erro ao atualizar produto, entre em contato com um administrador.'" :class="'text-red-600 bg-red-100'" />

        <form @submit.prevent="update">
            <div class="space-y-12">
                <div class="border-b border-white/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-black">Produto</h2>
                    <p class="mt-1 text-sm/6 text-gray-400">Preencha as informações sobre o produto.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <InputLabel for="name" value="Nome" />
                            <div class="mt-2">
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                                <InputError class="mt-2" :message="errors.name?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="description" value="Descrição" />
                            <div class="mt-2">
                                <textarea id="description" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="form.description" required>
                                </textarea>
                                <InputError class="mt-2" :message="errors.description?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="internal_code" value="Código Interno" />
                            <div class="mt-2">
                                <TextInput id="internal_code" type="text" class="mt-1 block w-full" v-model="form.internal_code" required autocomplete="internal_code" />
                                <InputError class="mt-2" :message="errors.internal_code?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="name" value="Status" />
                            <div class="mt-2 grid grid-cols-1">
                                <select id="status" name="status" autocomplete="status-name" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="form.status">
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                                <InputError class="mt-2" :message="errors.status?.[0]" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <Link href="/products">
                    <button type="button" class="text-sm/6 font-semibold text-gray-400">Cancelar</button>
                </Link>
                <button type="submit" class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">Salvar</button>
            </div>
        </form>
    </GuestLayout>
</template>