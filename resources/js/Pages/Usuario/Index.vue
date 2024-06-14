<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    usuarios : Object,
    filters : Object,
    message : String
});

const formatDate = (timestamp) => {
      const date = new Date(timestamp);
      const day = ('0' + date.getDate()).slice(-2);
      const month = ('0' + (date.getMonth() + 1)).slice(-2);
      const year = date.getFullYear();
      return `${day}-${month}-${year}`;
    };

const filters = {
    filter: props.filters.filter,
}
const form = useForm(filters);

const deleteTrade = (id) => {
    if (confirm("Estas seguro de eliminar este elemento")) {
	   form.delete(route('usuarios.destroy',{id:id}), {
		  preserveScroll: true,
	   });
    }
};
</script>
<template>
	<Head title="Usuarios" />
	<AuthenticatedLayout>
		<template #header>
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><a :href="route('usuarios.index')">Usuarios</a> 
            <!-- <PrimaryLink :href="route('usuarios.index', {filter:'only'})" class="max-w-xl ml-2" >Ver eliminado</PrimaryLink> --></h2>
		</template>

        

		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			  <div
				 v-if="props.message"
				 class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
				 role="alert"
			  >
				 <span class="font-medium">
					{{ props.message }}
				 </span>
			  </div>
			   <div class="bg-white rounded-md shadow overflow-x-auto">

                <PrimaryLink :href="route('usuarios.create')" class="max-w-xl ml-2 mt-2" >Nuevo Usuario</PrimaryLink>
				<table class="w-full whitespace-nowrap">
				  <thead>
				    <tr class="text-left font-bold">
					 <!-- <th class="pb-4 pt-6 px-6">ID</th> -->
					 <th class="pb-4 pt-6 px-6">Nombres</th>
                     <th class="pb-4 pt-6 px-6">Apellidos</th>
					 <th class="pb-4 pt-6 px-6">Correo</th>
					 <th class="pb-4 pt-6 px-6">Acciones</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr v-for="entry in props.usuarios.data" :key="entry.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                        <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                            {{ entry.nombres }}
                        </span>
                        </td>
                        <td class="border-t">
                        <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                            {{ entry.apellidos }}
                        </span>
                        </td>
                        <td class="border-t">
                        <span class="flex items-center px-6 py-4 focus:text-indigo-500">
                            {{  entry.correo  }}
                        </span>
                        </td>
                        <td class="border-t" >
                            <!-- <PrimaryLink v-if="entry.deleted_at == null" :href="route('usuarios.show', {'id': entry.id})" class="max-w-xl ml-2" >VIEW</PrimaryLink> -->
                            <PrimaryLink v-if="entry.deleted_at == null" :href="route('usuarios.edit', {'id': entry.id})" class="max-w-xl ml-2" >EDITAR</PrimaryLink>
                            <!--<DangerButton
								class="ml-3"
								@click="deleteTrade(entry.id)" v-if="entry.deleted_at == null"
								>
								DAR DE BAJA
							</DangerButton>-->
                        </td>
				    </tr>
				    <tr v-if="props.usuarios.data.length === 0">
					 <td class="px-6 py-4 border-t" colspan="4">No se encontraron datos.</td>
				    </tr>
				  </tbody>
				</table>
			   </div>
			   <pagination class="mt-6" :links="props.usuarios.links" />
			</div>
		</div>
	</AuthenticatedLayout>
</template>