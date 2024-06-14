<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
//import TextArea from '@/Components/TextArea.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';


const form = useForm({
    //vehiculo
    marca: '',
    modelo: '',
    patente : '',
    anio: '',
    precio: '',
    //usuario
    nombres: '',
    apellidos: '',
    correo : ''

});

const submit = () => {
    form.post(route("vehiculos.store"));
};
</script>
<template>
    <Head title="Nuevo Vehículo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear vehículo</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>

                    

                    <form @submit.prevent="submit" class="mt-6 space-y-6">

                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Datos del Vehículo</h2> 

                        <div>
                            <InputLabel for="marca" value="Marca" />

                            <TextInput
                                id="marca"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.marca"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.marca" />
                        </div>

                        <div>
                            <InputLabel for="modelo" value="Modelo" />

                            <TextInput
                                id="modelo"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.modelo"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.modelo" />
                        </div>

                        <div>
                            <InputLabel for="patente" value="Patente" />

                            <TextInput
                                id="patente"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.patente"
                                
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.patente" />
                        </div>

                        <div>
                            <InputLabel for="anio" value="Año" />

                            <TextInput
                                id="anio"
                                class="mt-1 block w-full"
                                v-model="form.anio"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.anio" />
                        </div>

                        <div>
                            <InputLabel for="precio" value="Precio avalúo" />

                            <TextInput
                                id="precio"
                                class="mt-1 block w-full"
                                v-model="form.precio"
                                
                            />

                            <InputError class="mt-2" :message="form.errors.precio" />
                        </div>


                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Datos del Usuario/Propietario</h2> 


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




                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Registrar</PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Registrado.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>