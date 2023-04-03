<script setup>
import dayjs from 'dayjs';
import 'dayjs/locale/pt-br'
import relativeTime from 'dayjs/plugin/relativeTime';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

dayjs.locale('pt-br'); // usar locale espanhol globalmente
dayjs.extend(relativeTime);

const props = defineProps(['despesa']);

const form = useForm({
    descricao: props.despesa.desp_descricao,
    date: new Date(props.despesa.desp_data).toISOString().slice(0,10),
    valor: props.despesa.desp_valor,
});
 
const editing = ref(false);
</script>
 
<template>
    <div class="p-6 flex space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">{{ despesa.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(despesa.created_at).fromNow() }}</small>
                    <small v-if="despesa.created_at !== despesa.updated_at" class="text-sm text-gray-600"> &middot; editado</small>
                </div>
                <Dropdown v-if="despesa.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Editar
                        </button>
                        <DropdownLink as="button" :href="route('despesas.destroy', despesa.desp_id)" method="delete">
                            Deletar
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="form.put(route('despesas.update', despesa.desp_id), { onSuccess: () => editing = false })">
                <!-- <textarea v-model="form.descricao" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.descricao" class="mt-2" /> -->
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
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancelar</button>
                </div>
            </form>
            <p v-else class="mt-4 text-lg text-gray-900">{{ despesa.desp_descricao }}</p>
        </div>
    </div>
</template>