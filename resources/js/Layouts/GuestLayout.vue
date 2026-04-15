<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 text-lg font-bold border-b border-gray-700">
                Meu Sistema
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <Link href="/suppliers" class="block px-4 py-2 rounded hover:bg-gray-700">
                    Fornecedores
                </Link>

                <Link href="/products" class="block px-4 py-2 rounded hover:bg-gray-700">
                    Produtos
                </Link>

                <Link href="#" class="block px-4 py-2 rounded hover:bg-gray-700">
                    Pedidos
                </Link>
            </nav>
        </aside>

        <main class="flex-1 p-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <slot />
            </div>
        </main>
    </div>
</template>
