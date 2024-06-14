<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Pagination from '@/Components/Pagination.vue';

import { Link, useForm, usePage } from '@inertiajs/vue3';


const props = defineProps({
    vehiculo : Object,
    historialvehiculo : Object

});

const form = useForm({
    //id: props.usuario.id,
    marca: props.vehiculo.marca,
    modelo: props.vehiculo.modelo,
    patente : props.vehiculo.patente,
    anio: props.vehiculo.anio,
    precio: props.vehiculo.precio,
    nombres: props.vehiculo.usuario.nombres,
    apellidos: props.vehiculo.usuario.apellidos,
    correo : props.vehiculo.usuario.correo,
});

const submit = () => {
     form.put(route("vehiculos.update", props.vehiculo.id));
};

const formatDate = (timestamp) => {
      const date = new Date(timestamp);
      const day = ('0' + date.getDate()).slice(-2);
      const month = ('0' + (date.getMonth() + 1)).slice(-2);
      const year = date.getFullYear();
      return `${day}-${month}-${year}`;
    };


</script>
<template>
    <Head title="Editar Vehículo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Vehículo</h2>
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




                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Datos del usuario/propietario</h2>

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
                            <PrimaryButton :disabled="form.processing">Actualizar</PrimaryButton>

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


                <section>

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Historial de usuarios/propietarios anteriores</h2>

                    
                    
                        <div class="bg-white rounded-md shadow overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left font-bold">
                                <!-- <th class="pb-4 pt-6 px-6">ID</th> -->
                                <th class="pb-4 pt-6 px-6">Nombres</th>
                                <th class="pb-4 pt-6 px-6">Apellidos</th>
                                <th class="pb-4 pt-6 px-6">Correo</th>
                               
                                <th class="pb-4 pt-6 px-6">Ingreso/Actualización</th>
                                <th class="pb-4 pt-6 px-6">Dado de baja</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="entry in props.historialvehiculo.data" :key="entry.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                    <td class="border-t">
                                    <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ entry.usuario.nombres }} 
                                    </span>
                                    </td>
                                    <td class="border-t">
                                    <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ entry.usuario.apellidos }}
                                    </span>
                                    </td>
                                    <td class="border-t">
                                    <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ entry.usuario.correo }}
                                    </span>
                                    </td>
                                    
                                    <td class="border-t">
                                    <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ formatDate (entry.updated_at )}}
                                    </span>
                                    </td>
                                    <td class="border-t">
                                    <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                                        {{ formatDate (entry.deleted_at )}}
                                    </span>
                                    </td>

                                
                            
                                    <td class="border-t" >
                                        
                                        <PrimaryLink v-if="entry.deleted_at == null" :href="route('usuarios.edit', {'id': entry.usuario.id})" class="max-w-xl ml-2" >EDITAR</PrimaryLink>
                                        
                                    </td>
                                </tr>
                                <tr v-if="props.historialvehiculo.data.length === 0">
                                    <td class="px-6 py-4 border-t" colspan="4">No se encotraron registros.</td>
                                    </tr>
                                
                            </tbody>
                            </table>
                        </div>
                        
                    
                </section>





            </div>
        </div>
    </AuthenticatedLayout>
</template>