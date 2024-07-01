<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>


<template>
  <Head title="Tableau de bord" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tableau de bord
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-4 text-gray-900">Vous êtes connecté !</div>
          <div class="p-4">
            <a
              class="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
              href="/"
            >
              Page du site
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
