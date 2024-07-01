<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
  animals: Array,
});

function destroy(id) {
  if (confirm("Êtes-vous sûr de vouloir supprimer ?")) {
    router.delete(route("animals.destroy", id));
  }
}
</script>


<template>
  <Head title="Animaux" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Animaux</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between mb-6">
              <Link
                class="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
                :href="route('animals.create')"
              >
                Créer un animal
              </Link>
            </div>

            <table class="table-fixed w-full">
              <thead>
                <tr class="bg-gray-100">
                  <th class="px-4 py-2 w-20">N.</th>
                  <th class="px-4 py-2">Nom</th>
                  <th class="px-4 py-2">Âge</th>
                  <th class="px-4 py-2">Race</th>
                  <th class="px-4 py-2">Mammifère</th>
                  <th class="px-4 py-2">Description</th>
                  <th class="px-4 py-2">Statut</th>
                  <th class="px-4 py-2">Prix HT</th>
                  <th class="px-4 py-2">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="animal in props.animals" :key="animal.id">
                  <td class="border px-4 py-2">{{ animal.id }}</td>
                  <td class="border px-4 py-2">{{ animal.name }}</td>
                  <td class="border px-4 py-2">{{ animal.age }}</td>
                  <td class="border px-4 py-2">{{ animal.breed.name }}</td>
                  <td class="border px-4 py-2">{{ animal.mammal.name }}</td>
                  <td class="border px-4 py-2">
                    <p class="truncate">
                      {{ animal.description }}
                    </p>
                  </td>
                  <td class="border px-4 py-2">{{ animal.status.name }}</td>
                  <td class="border px-4 py-2">{{ animal.htprice }}</td>
                  <td class="border px-4 py-2">
                    <Link
                      tabIndex="1"
                      class="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                      :href="route('animals.edit', animal.id)"
                    >
                      Modifier
                    </Link>
                    <button
                      @click="destroy(animal.id)"
                      tabIndex="-1"
                      type="button"
                      class="mt-2 px-4 py-2 text-sm text-white bg-red-500 rounded"
                    >
                      Supprimer
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
