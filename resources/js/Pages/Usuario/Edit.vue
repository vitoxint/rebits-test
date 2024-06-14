<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { Link, useForm, usePage } from '@inertiajs/vue3';


const props = defineProps({
    usuario : Object
});

const form = useForm({
    id: props.usuario.id,
    nombres: props.usuario.nombres,
    apellidos: props.usuario.apellidos,
    correo : props.usuario.correo,
});

const submit = () => {
     form.put(route("usuarios.update", props.usuario.id));
};
</script>
<template>
    <Head title="Edit usuario" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar usuario</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="heading" value="Nombres" />

                            <TextInput
                                id="nombres"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nombres"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.nombres" />
                        </div>

                        <div>
                            <InputLabel for="slug" value="Apellidos" />

                            <TextInput
                                id="apellidos"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.apellidos"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.apellidos" />
                        </div>
                        <div>
                            <InputLabel for="correo" value="Correo electrónico" />

                            <TextInput
                                id="correo"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.correo"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.correo" />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Actualizado.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>