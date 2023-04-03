<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Despesa from '@/Components/Despesa.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
 
defineProps(['despesas']);

const form = useForm({
    descricao: '',
    date: new Date().toISOString().slice(0,10),
    valor: 0
});
</script>
 
<template>
    <Head title="Despesas" />
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

            <form @submit.prevent="form.post(route('despesas.store'), { onSuccess: () => form.reset() })">

                <div>
                    <InputLabel for="date" value="Data" />

                    <TextInput
                        id="date"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.date"
                    />

                    <InputError class="mt-2" :message="form.errors.date" />
                </div>
                
                <div>
                    <InputLabel for="valor" value="Valor" />

                    <TextInput
                        id="valor"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.valor"
                        step=".01"
                        autofocus
                    />

                    <InputError class="mt-2" :message="form.errors.valor" />
                </div>
                
                <div>
                    <InputLabel for="descricao" value="Descrição" />

                    <textarea
                        id="descricao"
                        type="text"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                        v-model="form.descricao"
                        style="height:200px"
                    ></textarea>

                    <InputError :message="form.errors.descricao" class="mt-2" />
                </div>
                <PrimaryButton class="mt-4">Salvar despesa</PrimaryButton>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Despesa
                    v-for="despesa in despesas"
                    :key="despesa.id"
                    :despesa="despesa"
                />
            </div>

        </div>
    </AuthenticatedLayout>
</template>

