<script setup>
import Alert from '@/Components/Alert.vue';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Link } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { Head } from "@inertiajs/vue3";
import { ref } from 'vue';

const form = ref({
    name: '',
    cnpj: '',
    email: '',
    phone: '',
    status: '',
});

const errors = ref({
    name: null,
    cnpj: null,
    email: null,
    phone: null,
    status: null,
});

const loading = ref(false);
const success = ref(null);

async function submit() {
    try {
        loading.value = true;
        success.value = false;

        await axios.post('/api/suppliers', form.value);

        form.value.name = '';
        form.value.cnpj = '';
        form.value.email = '';
        form.value.phone = '';
        form.value.status = '';

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
    <Head title="Cadastrar Fornecedor" />

    <GuestLayout>

        <Alert v-if="success == true" :message="'Forncecedor cadastrado com sucesso.'" :class="'text-green-600 bg-green-100'" />
        <Alert v-if="success == false" :message="'Erro ao cadastrar fornecedor, entre em contato com um administrador.'" :class="'text-red-600 bg-red-100'" />

        <form @submit.prevent="submit">
            <div class="space-y-12">
                <div class="border-b border-white/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-black">Fornecedor</h2>
                    <p class="mt-1 text-sm/6 text-gray-400">Preencha as informações sobre o fornecedor.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <InputLabel for="name" value="Nome" />
                            <div class="mt-2">
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                                <InputError class="mt-2" :message="errors.name?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="cnpj" value="CNPJ" />
                            <div class="mt-2">
                                <TextInput id="cnpj" type="text" class="mt-1 block w-full" v-model="form.cnpj" required autocomplete="cnpj" />
                                <InputError class="mt-2" :message="errors.cnpj?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="email" value="E-mail" />
                            <div class="mt-2">
                                <TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.email" required autocomplete="email" />
                                <InputError class="mt-2" :message="errors.email?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="phone" value="Telefone" />
                            <div class="mt-2">
                                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required autocomplete="phone" />
                                <InputError class="mt-2" :message="errors.phone?.[0]" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <InputLabel for="name" value="Status" />
                            <div class="mt-2 grid grid-cols-1">
                                <select id="status" name="status" autocomplete="status-name" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="form.status">
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
                <Link href="/suppliers">
                    <button type="button" class="text-sm/6 font-semibold text-gray-400">Cancelar</button>
                </Link>
                <button type="submit" class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-500">Salvar</button>
            </div>
        </form>
    </GuestLayout>
</template>