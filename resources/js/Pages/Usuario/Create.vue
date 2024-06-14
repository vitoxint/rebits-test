<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
//import TextArea from '@/Components/TextArea.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';


const form = useForm({
    nombres: '',
    apellidos: '',
    correo : ''
});

const submit = () => {
    form.post(route("usuarios.store"));
};
</script>
<template>
    <Head title="Nuevo Usuario" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear usuario</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="nombres" value="Nombres" />

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
                            <InputLabel for="apellidos" value="Apellidos" />

                            <TextInput
                                id="apellidos"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.apellidos"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.apellidos" />
                        </div>

                        <div>
                            <InputLabel for="correp" value="Correo electrónico" />

                            <TextInput
                                id="correo"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.correo"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.correo" />
                        </div>

                    
                        <!-- <div>
                            <InputLabel for="description" value="Description" />

                            <TextArea
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div> -->

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Agregar</PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Agregado.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>