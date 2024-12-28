<script>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import UpdateSettingsForm from "@/Pages/Profile/Settings/Partials/UpdateSettingsForm.vue";

export default {
  name: "Settings/Index",
  props: {
    settings: {
      type: Object,
      required: true
    },
    confirmation_types: {
      type: Object,
      required: true
    }
  },
  components: {
    UpdateSettingsForm,
    TextInput, InputError, InputLabel,
    AuthenticatedLayout, Head
  },
}
</script>

<template>
  <Head title="Settings"/>

  <AuthenticatedLayout>
    <template #header>
      <h2
          class="text-xl font-semibold leading-tight text-gray-800"
      >
        Settings
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <div v-for="setting in settings">
            <UpdateSettingsForm v-bind="{setting: setting, confirmation_types: confirmation_types}"/>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style></style>