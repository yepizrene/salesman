<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps(['users']);

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '', 
});

const submit = () => {
  form.post(route('users.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <AppLayout title="New user">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('users.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Users
        </nav-link> / Create
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
                  <text-input id="name" v-model="form.name" type="text" class="mt-1 block w-full" :class="form.errors.name ? 'border-red-600': ''" autofocus
                    autocomplete="name" />
                  <input-error class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                  <input-label for="email" value="Email" />
                  <text-input id="email" v-model="form.email" type="text" class="mt-1 block w-full" :class="form.errors.email ? 'border-red-600': ''"
                    autocomplete="username" />
                  <input-error class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                  <input-label for="password" value="Password" />
                  <text-input id="password" v-model="form.password" type="password" class="mt-1 block w-full" :class="form.errors.password ? 'border-red-600': ''"
                    autocomplete="new-password" />
                  <input-error class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                  <input-label for="password_confirmation" value="Confirm Password" />
                  <text-input id="password_confirmation" v-model="form.password_confirmation" type="password" :class="form.errors.password_confirmation ? 'border-red-600': ''"
                    class="mt-1 block w-full" autocomplete="new-password" />
                  <input-error class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">
                  <primary-button class="ms-4" >
                    Save
                  </primary-button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
