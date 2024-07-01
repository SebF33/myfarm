<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeTextArea from "@/Components/Textarea.vue";
import { Head, Link, router, useForm } from "@inertiajs/vue3";

const props = defineProps({
  animal: Object,
  breeds: Array,
  mammals: Array,
  photos: Array,
  statuses: Array,
});

const form = useForm({
  name: props.animal.name,
  age: props.animal.age,
  mammal_id: props.animal.mammal_id,
  breed_id: props.animal.breed_id,
  description: props.animal.description,
  status_id: props.animal.status_id,
  htprice: props.animal.htprice,
  newPhotos: [],
});

const handlePhotoUpload = (event) => {
  const files = event.target.files;
  for (let i = 0; i < files.length; i++) {
    form.newPhotos.push(files[i]);
  }
};

const photoUrl = (path) => {
  return `/storage/${path.replace("public/", "")}`;
};

const removePhoto = (photoId) => {
  router.delete(route("photos.destroy", photoId), {
    onSuccess: () => {
      props.animal.photos = props.animal.photos.filter(
        (photo) => photo.id !== photoId
      );
      alert("Photo supprimée avec succès.");
    },
    onError: (error) => {
      console.error("Error removing photo:", error);
      alert("Échec de la suppression de la photo.");
    },
  });
};

// Inertia.js Multipart limitations: https://inertiajs.com/file-uploads
const submit = async () => {
  const formData = {
    _method: "put",
    name: form.name,
    age: form.age,
    mammal_id: form.mammal_id,
    breed_id: form.breed_id,
    description: form.description,
    status_id: form.status_id,
    htprice: form.htprice,
  };

  if (form.newPhotos.length > 0) {
    formData.newPhotos = form.newPhotos;
  }

  try {
    const response = await router.post(
      route("animals.update", props.animal.id),
      formData
    );
  } catch (error) {
    console.error("Exception:", error);
  }
};
</script>


<template>
  <Head title="Modifier un animal" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Modifier un animal
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

            <form name="editForm" @submit.prevent="submit">
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

                <!-- Photos existantes -->
                <div class="mb-4">
                  <BreezeLabel value="Photos existantes" />
                  <div class="grid grid-cols-3 gap-4">
                    <div v-if="photos && photos.length">
                      <div
                        v-for="photo in photos"
                        :key="photo.id"
                        class="relative"
                      >
                        <img
                          :src="photoUrl(photo.file_path)"
                          alt="Photo de l'animal"
                          class="w-full h-auto object-cover rounded-lg"
                        />
                        <button
                          @click.prevent="removePhoto(photo.id)"
                          class="absolute top-0 right-0 bg-red-600 text-white rounded-full px-2 py-1"
                        >
                          Supprimer la photo
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Upload nouvelles photos -->
                <div class="mb-4">
                  <BreezeLabel
                    for="newPhotos"
                    value="Ajouter de nouvelles photos"
                  />
                  <BreezeInput
                    id="newPhotos"
                    type="file"
                    class="mt-1 block w-full"
                    multiple
                    @change="handlePhotoUpload"
                  />
                  <span class="text-red-600" v-if="form.errors.newPhotos">{{
                    form.errors.newPhotos
                  }}</span>
                </div>
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
