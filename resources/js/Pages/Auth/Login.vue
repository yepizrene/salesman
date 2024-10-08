<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const buttonClassStyle = 'inline-flex items-center px-4 py-2 bg-blueberry-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blueberry-700 focus:bg-blueberry-700 active:bg-blueberry-900 focus:outline-none focus:ring-2 focus:ring-blueberry-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150';

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>

  <Head title="Log in" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />
        <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
          autocomplete="current-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox v-model:checked="form.remember" name="remember" />
          <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <div class="flex w-full mt-4">
        <div class="fixed">
          <Link :class="buttonClassStyle" :href="route('register')">
            Register
          </Link>
        </div>

        <div class="w-full flex justify-end">
          <Link v-if="canResetPassword" :href="route('password.request')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Forgot your password?
          </Link>
          <primary-button class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Log in
          </primary-button>
        </div>
      </div>
    </form>
  </AuthenticationCard>
</template>
