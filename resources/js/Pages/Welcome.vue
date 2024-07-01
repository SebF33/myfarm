<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { computed, ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";

const { animals, canLogin, canRegister, laravelVersion, phpVersion } =
  defineProps({
    animals: Array,
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  });

const photoUrl = (path) => {
  return `/storage/${path.replace("public/", "")}`;
};

function ttcCalcul(htPrice) {
  let taux = 20;
  let ttcPrice = htPrice * (1 + taux / 100);
  return ttcPrice.toFixed(2).toString().replace(".", ",") + "€ TTC";
}

// Options de filtrage et de tri
const filterText = ref("");
const sortKey = ref("name");
const sortOrder = ref("asc");

const filteredSortedAnimals = computed(() => {
  let result = animals || [];

  // Filtrer les animaux par nom ou race
  if (filterText.value) {
    const filter = filterText.value.toLowerCase();
    result = result.filter(
      (animal) =>
        animal.name.toLowerCase().includes(filter) ||
        animal.breed.name.toLowerCase().includes(filter)
    );
  }

  // Trier les animaux par clé et ordre sélectionnés
  result.sort((a, b) => {
    const keyA = sortKey.value === "breed" ? a.breed.name : a[sortKey.value];
    const keyB = sortKey.value === "breed" ? b.breed.name : b[sortKey.value];

    if (keyA < keyB) return sortOrder.value === "asc" ? -1 : 1;
    if (keyA > keyB) return sortOrder.value === "asc" ? 1 : -1;
    return 0;
  });

  return result;
});

// Basculer l'ordre de tri
const toggleSortOrder = () => {
  sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
};
</script>


<template>
  <Head title="Accueil" />

  <div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
  >
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Tableau de bord</Link
      >

      <template v-else>
        <Link
          :href="route('login')"
          class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Se connecter</Link
        >
      </template>
    </div>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
      <div class="flex justify-center">
        <ApplicationLogo class="block h-44 w-auto fill-current text-gray-800" />
      </div>

      <!-- Contrôles de filtrage et de tri -->
      <div class="m-auto mt-16 max-w-96">
        <div class="mb-4">
          <label
            for="filter"
            class="mt-1 text-lg italic font-semibold text-gray-900 dark:text-white"
            >Filtrer par nom ou race :</label
          >
          <input
            id="filter"
            type="text"
            v-model="filterText"
            class="mt-1 block w-full"
          />
        </div>

        <div class="mb-4">
          <label
            for="sort"
            class="mt-1 text-lg italic font-semibold text-gray-900 dark:text-white"
            >Trier par :</label
          >
          <select id="sort" v-model="sortKey" class="mt-1 block w-full">
            <option value="name">Nom</option>
            <option value="breed">Race</option>
          </select>
          <div class="flex flex-col justify-center items-center mt-2">
            <button
              @click="toggleSortOrder"
              class="flex-1 px-4 py-2 bg-[#fed702] rounded"
            >
              {{ sortOrder === "asc" ? "Ascendant" : "Descendant" }}
            </button>
          </div>
        </div>
      </div>

      <!-- Animaux -->
      <div class="mt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
          <template v-if="filteredSortedAnimals.length > 0">
            <div
              v-for="animal in filteredSortedAnimals"
              :key="animal.id"
              class="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex flex-col items-center motion-safe:hover:scale-[1.02] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
            >
              <div class="w-full mb-4">
                <div class="grid grid-cols-3 gap-2">
                  <div
                    v-for="photo in animal.photos"
                    :key="photo.id"
                    class="overflow-hidden rounded-lg max-w-xs mx-auto"
                  >
                    <img
                      :src="photoUrl(photo.file_path)"
                      alt="Photo de l'animal"
                      class="w-full h-auto object-cover will-change-transform"
                    />
                  </div>
                </div>
              </div>
              <h2
                class="mt-4 text-2xl font-semibold text-gray-900 dark:text-white"
              >
                {{ animal.name }}
                <span class="text-sm">({{ animal.status.name }})</span>
              </h2>
              <h3
                class="mt-1 text-lg italic font-semibold text-gray-900 dark:text-white"
              >
                {{ animal.mammal.name }} — {{ animal.breed.name }} de
                {{ animal.age }} an(s)
              </h3>
              <p
                class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed text-center"
              >
                {{ animal.description }}
              </p>
              <p class="mt-2 text-gray-500 dark:text-gray-400 text-xl">
                {{ ttcCalcul(animal.htprice) }}
              </p>
            </div>
          </template>
          <template v-else>
            <!-- Placeholder -->
            <div
              class="p-6 text-center text-4xl text-gray-500 dark:text-gray-400"
            >
              Aucun animal n'a été trouvé.
            </div>
          </template>
        </div>
      </div>

      <!-- Footer -->
      <div
        class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between"
      >
        <div
          class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left"
        >
          <div class="flex items-center gap-4">
            <a
              href="/"
              class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >
              © MyFarm
            </a>
          </div>
        </div>

        <div
          class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0"
        >
          Écrivez-moi pour commander :
          <a href="mailto:sebastien.flouriot@gmail.com" class="underline"
            >sebastien.flouriot@gmail.com</a
          >
        </div>
      </div>
    </div>
  </div>
</template>


<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
