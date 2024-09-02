<script setup>
import { ref } from 'vue';

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
  user: Object
});

const form = useForm({
  _method: 'PUT',
  name: props.user.name,
  email: props.user.email,
  password: "",
});

const modalOpen = ref(false);

const deleteUser = (selectedUser) => {
  closeModal();
  router.delete(route('users.destroy', { user: selectedUser }));
}

const closeModal = () => {
  modalOpen.value = false;
}

const submit = () => {
  form.post(route('users.update', props.user), {
    preserveScroll: true,
  });
};

</script>

<template>
  <AppLayout title="New user">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('users.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Users
        </nav-link> / {{ user.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200 flex justify-center">
            <div class="w-1/2">
              <form @submit.prevent="submit">
                <div>
                  <input-label for="name" value="Name" />
                  <text-input id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                    :class="form.errors.name ? 'border-red-600' : ''" autofocus autocomplete="name" />
                  <input-error class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                  <input-label for="email" value="Email" />
                  <text-input id="email" v-model="form.email" type="text" class="mt-1 block w-full"
                    :class="form.errors.email ? 'border-red-600' : ''" autocomplete="username" />
                  <input-error class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                  <input-label for="password" value="Password" />
                  <text-input id="password" v-model="form.password" type="password" class="mt-1 block w-full"
                    :class="form.errors.password ? 'border-red-600' : ''" autocomplete="new-password" />
                  <input-error class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex mt-4">
                  <div class="w-1/2 flex items-center justify-start ">
                    <danger-button @click="modalOpen=true">
                      delete user
                    </danger-button>
                  </div>
                  <div class="w-1/2 flex items-center justify-end">
                    <action-message :on="form.recentlySuccessful" class="me-3">
                      Saved.
                    </action-message>
                    <primary-button class="ms-4">
                      Save
                    </primary-button>
                  </div>
                </div>
              </form>

              <dialog-modal :show="modalOpen" @close="closeModal">
                <template #title>
                  <h1 class="text-2xl font-bold">Delete user</h1>
                </template>
                <template #content>
                  <h2 class="text-xl font-bold">Are you sure to delete this user?</h2>
                  <p class="text-lg font-bold text-blueberry-500">{{ user.email }}</p>
                </template>
                <template #footer>
                  <div class="flex w-full gap-2 items-end justify-end">
                    <danger-button @click="deleteUser(user)">Delete</danger-button>
                    <primary-button @click="closeModal">Close</primary-button>
                  </div>
                </template>
              </dialog-modal>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
