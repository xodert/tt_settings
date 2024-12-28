<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useToast} from "vue-toastification";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Pages/Profile/Settings/Partials/Modal.vue";

export default {
  name: "LinkTelegramForm",
  components: {Modal, InputLabel, TextInput, PrimaryButton},
  setup(props) {
    const toast = useToast();
    const showModal = ref(false);
    const isLinking = ref(false);
    const modalButton = ref(null);

    const linkTelegram = async () => {
      isLinking.value = true;
      try {
        const response = await axios.post(route("telegram.link"));

        window.open(response.data.data.link, '_blank');

        toast.success("Telegram is successfully linked.");

        // Закрываем модалку
        showModal.value = false;
      } catch (e) {
        toast.error(e.response?.data?.message || "The error occurred while trying to link a Telegram.");
      }
    };

    return {
      showModal,
      isLinking,
      modalButton,
      linkTelegram
    };
  },
  mounted() {
    Echo.channel(`App.Models.User.${this.$page.props.auth.user.id}`)
        .listen("TelegramLinked", (event) => {
              this.$page.props.auth.user.telegram_id = event.telegram_id;
            }
        );
  }
}
</script>

<template>
  <section class="space-y-6">
    <header>
      <div class="flex">
        <svg height="24" viewBox="0 0 48 48" width="24" x="0px" xmlns="http://www.w3.org/2000/svg" y="0px">
          <path d="M24 4A20 20 0 1 0 24 44A20 20 0 1 0 24 4Z" fill="#29b6f6"></path>
          <path
              d="M33.95,15l-3.746,19.126c0,0-0.161,0.874-1.245,0.874c-0.576,0-0.873-0.274-0.873-0.274l-8.114-6.733 l-3.97-2.001l-5.095-1.355c0,0-0.907-0.262-0.907-1.012c0-0.625,0.933-0.923,0.933-0.923l21.316-8.468 c-0.001-0.001,0.651-0.235,1.126-0.234C33.667,14,34,14.125,34,14.5C34,14.75,33.95,15,33.95,15z"
              fill="#fff"></path>
          <path
              d="M23,30.505l-3.426,3.374c0,0-0.149,0.115-0.348,0.12c-0.069,0.002-0.143-0.009-0.219-0.043 l0.964-5.965L23,30.505z"
              fill="#b0bec5"></path>
          <path
              d="M29.897,18.196c-0.169-0.22-0.481-0.26-0.701-0.093L16,26c0,0,2.106,5.892,2.427,6.912 c0.322,1.021,0.58,1.045,0.58,1.045l0.964-5.965l9.832-9.096C30.023,18.729,30.064,18.416,29.897,18.196z"
              fill="#cfd8dc"></path>
        </svg>
        <h2 class="text-lg font-medium text-gray-900 max-h-auto">
          Telegram
        </h2>
      </div>
    </header>
    <div v-if="$page.props.auth.user.telegram_id ?? false" class="flex flex-col gap-y-2">
      You have already linked telegram!
    </div>
    <div v-else>
      <PrimaryButton v-if="!isLinking" @click="showModal = true">Link</PrimaryButton>
      <PrimaryButton v-else>Waiting for link</PrimaryButton>
    </div>

    <Modal v-if="showModal" style="margin-top: 0" @close="showModal = false">
      <template #title>Telegram link</template>
      <template #body>
        <div class="flex flex-col gap-y-3">
          <p>Press the button below to link your Telegram account.</p>
        </div>
      </template>
      <template #footer>
        <PrimaryButton :disabled="isLinking" @click="linkTelegram">
          {{ isLinking ? "Linking..." : "Link" }}
        </PrimaryButton>
        <PrimaryButton class="ml-2" @click="showModal = true">Cancel</PrimaryButton>
      </template>
    </Modal>

  </section>
</template>

<style scoped>

</style>