<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeTextArea from "@/Components/Textarea.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  breeds: Array,
  mammals: Array,
  statuses: Array,
});

const form = useForm({
  name: "",
  age: 0,
  mammal_id: "",
  breed_id: "",
  description: "",
  status_id: "",
  htprice: 0,
  photo: null,
});

const handlePhotoUpload = (event) => {
  form.photo = event.target.files[0];
};

const submit = () => {
  form.post(route("animals.store"), {
    onSuccess: () => {
      alert("Animal créé avec succès !");
    },
    onError: (errors) => {
      console.log("Error:", errors);
    },
  });
};
</script>


<template>
  <Head title="Créer un animal" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Créer un animal
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between mb-6">
              <Link
                class="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                :href="route('animals.index')"
              >
                Retour
              </Link>
            </div>

            <form name="createForm" @submit.prevent="submit">
              <div class="flex flex-col">
                <div class="mb-4">
                  <BreezeLabel for="name" value="Nom" />
                  <BreezeInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autofocus
                  />
                  <span class="text-red-600" v-if="form.errors.name">
                    {{ form.errors.name }}
                  </span>
                </div>

                <div class="mb-4">
                  <BreezeLabel for="age" value="Âge" />
                  <BreezeInput
                    id="age"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.age"
                    autofocus
                  />
                  <span class="text-red-600" v-if="form.errors.age">
                    {{ form.errors.age }}
                  </span>
                </div>

                <div class="mb-4">
                  <BreezeLabel for="description" value="Description" />
                  <BreezeTextArea
                    id="description"
                    class="mt-1 block w-full"
                    v-model="form.description"
                  />
                  <span class="text-red-600" v-if="form.errors.description">
                    {{ form.errors.description }}
                  </span>
                </div>

                <div class="mb-4">
                  <BreezeLabel for="htprice" value="Prix HT" />
                  <BreezeInput
                    id="htprice"
                    type="number"
                    step="0.01"
                    class="mt-1 block w-full"
                    v-model="form.htprice"
                    autofocus
                  />
                  <span class="text-red-600" v-if="form.errors.htprice">
                    {{ form.errors.htprice }}
                  </span>
                </div>

                <div class="mb-4">
                  <BreezeLabel for="breed" value="Race" />
                  <select
                    id="breed"
                    class="mt-1 block w-full"
                    v-model="form.breed_id"
                  >
                    <option value="">Sélectionnez la race</option>
                    <option
                      v-for="breed in props.breeds"
                      :key="breed.id"
                      :value="breed.id"
                    >
                      {{ breed.name }}
                    </option>
                  </select>
                  <span class="text-red-600" v-if="form.errors.breed_id">
                    {{ form.errors.breed_id }}
                  </span>
                </div>

                <div class="mb-4">
                  <BreezeLabel for="mammal" value="Mammifère" />
                  <select
                    id="mammal"
                    class="mt-1 block w-full"
                    v-model="form.mammal_id"
                  >
                    <option value="">Sélectionner un mammifère</option>
                    <option
                      v-for="mammal in props.mammals"
                      :key="mammal.id"
                      :value="mammal.id"
                    >
                      {{ mammal.name }}
                    </option>
                  </select>
                  <span class="text-red-600" v-if="form.errors.mammal_id">
                    {{ form.errors.mammal_id }}
                  </span>
                </div>

                <div class="mb-4">
                  <BreezeLabel for="mammal" value="Statut" />
                  <select
                    id="status"
                    class="mt-1 block w-full"
                    v-model="form.status_id"
                  >
                    <option value="">Sélectionnez le statut</option>
                    <option
                      v-for="status in props.statuses"
                      :key="status.id"
                      :value="status.id"
                    >
                      {{ status.name }}
                    </option>
                  </select>
                  <span class="text-red-600" v-if="form.errors.status_id">
                    {{ form.errors.status_id }}
                  </span>
                </div>
              </div>

              <div class="mb-4">
                <BreezeLabel for="photo" value="Photo" />
                <input
                  id="photo"
                  type="file"
                  class="mt-1 block w-full"
                  @change="handlePhotoUpload"
                />
                <span class="text-red-600" v-if="form.errors.photo">
                  {{ form.errors.photo }}
                </span>
              </div>

              <div class="mt-4">
                <button
                  type="submit"
                  class="px-6 py-2 font-bold text-white bg-green-500 rounded"
                >
                  Enregistrer
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
