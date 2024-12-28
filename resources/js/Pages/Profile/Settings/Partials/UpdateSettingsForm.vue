<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import Modal from "@/Pages/Profile/Settings/Partials/Modal.vue";
import {useToast} from "vue-toastification";
import axios from "axios";

export default {
  name: "UpdateSettingsForm",
  components: {Modal, TextInput, InputError, InputLabel, PrimaryButton},
  props: {
    setting: {
      type: Object
    },
    confirmation_types: {
      type: Object
    },

  },
  setup(props) {
    const isModalOpen = ref(false); // Управляет видимостью модального окна
    const isCodeSend = ref(false);

    const isActive = ref(props.setting.editable);

    const codeInput = ref("0000"); // Код, вводимый пользователем
    const input = ref(null);
    const confirmationType = ref(null);

    const toast = useToast();

    const form = useForm({
      [props.setting.key]: props.setting.value.value,
    });

    const editButton = async () => {
      if (isActive.value) {
        try {
          const response = await axios.post(route('settings.update', {id: props.setting.id}), {
            value: form[props.setting.key]
          })

          toast.success('You have changed the value of the setting.');
          isActive.value = false;
        } catch (e) {
          if (e.response?.status === 422 || e.response?.status === 400) {
            toast.error(e.response.data.message);
          } else {
            toast.error("Something went wrong.")
          }
        }
        return;
      }

      toggleModal();
    }

    const toggleModal = () => {
      isModalOpen.value = !(isModalOpen.value);
    };

    const settingForm = useForm({
      source: "settings",
      confirmation_type: "email",
      action: "toggle_setting_update",
      action_data: {
        id: props.setting.id,
        key: props.setting.key
      }
    });

    const sendCode = async () => {
      try {
        const response = await axios.post(route('confirmation.sendCode', settingForm));

        if (response.data.success && response.data.data) {
          toast.success("Code was send");
          isCodeSend.value = true;
        }

      } catch (e) {
        if (e.response?.status === 422 || e.response?.status === 400) {
          toast.error(e.response.data.message);
        } else {
          toast.error("Something went wrong.")
        }
      }
    };

    const confirmCode = async () => {
      try {
        const response = await axios.post(route('confirmation.checkCode'), {
          source: "settings",
          confirmation_type: settingForm.confirmation_type.valueOf(),
          action: `toggle_setting_update`,
          code: codeInput.value.toString().padStart(4, '0'),
        });

        isCodeSend.value = false;
        isActive.value = true;
        toggleModal();
        toast.success("Now you can edit value of the input");
      } catch (e) {
        if (e.response?.status === 422 || e.response?.status === 400) {
          toast.error(e.response.data.message);
        } else {
          toast.error("Something went wrong.")
        }
      }

    };

    return {
      isModalOpen,
      isCodeSend,
      form,
      input,
      codeInput,
      toast,
      toggleModal,
      editButton,
      confirmCode,
      sendCode,
      confirmationType,
      settingForm,
      isActive
    };
  },
  mounted() {
    Echo.channel(`App.Models.Setting.${this.$props.setting.id}`)
        .listen("SettingEditToggled", (event) => {
              console.log(event);
              this.$props.setting.editable = event.editable;
              this.$refs.isActive = event.editable;
            }
        );
  }
}
</script>

<template>
  <section>
    <div>
      <InputLabel :for="form[$props.setting.key]" :value="$props.setting.label"/>
      <div class="flex">
        <div>
          <input
              ref="input"
              v-model="form[$props.setting.key]"
              :disabled="!$props.setting.editable"
              class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          >
        </div>
        <div>
          <PrimaryButton :disabled="form.processing" class="h-full" @click.prevent="editButton">Edit</PrimaryButton>
        </div>
      </div>
    </div>

    <Modal v-if="isModalOpen" @close="toggleModal">
      <template #title>Setting update</template>
      <template #body>
        <div class="flex flex-col gap-y-3">
          <div v-if="!isCodeSend" class="flex flex-col">
            <p v-if="Object.keys($props.confirmation_types).length < 3">
              aaa
            </p>
            <InputLabel value="Send method"/>
            <div class="flex">
              <select v-model="settingForm.confirmation_type" class="w-full">
                <option v-for="item in $props.confirmation_types" :value="item.alias">{{ item.name }}</option>
              </select>
              <PrimaryButton @click.prevent="sendCode">Send code</PrimaryButton>
            </div>
          </div>
          <div v-else class="flex flex-col gap-y-3">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquid at aut esse fugiat, ipsam
              laboriosam nisi nostrum odit porro possimus praesentium, quae quaerat quasi sunt, tempora unde voluptas
              voluptatibus.
            </p>
            <InputLabel value="Confirmation code"/>
            <input
                ref="input"
                v-model="codeInput"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                maxlength="4"
                type="number"
                @input="limitInput"
            />
          </div>
        </div>

      </template>
      <template #footer>
        <PrimaryButton v-if="isCodeSend" class="disabled:opacity-75" @click.prevent="confirmCode">Confirm
        </PrimaryButton>
        <PrimaryButton class="ml-2" @click="toggleModal">Cancel</PrimaryButton>
      </template>
    </Modal>
  </section>
</template>

<style scoped>

</style>