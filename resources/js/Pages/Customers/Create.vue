<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps(['customers']);

const form = useForm({
  name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  region: '',
  country: '',
  postal_code: ''
});

const submit = () => {
  form.post(route('customers.store'), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <AppLayout title="New customer">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('customers.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Customers
        </nav-link> / Create
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200 flex justify-center">
            <div class="w-2/3">
              <form @submit.prevent="submit">
                <div class="w-full flex gap-4">
                  <div class="w-1/2">
                    <input-label for="name" value="Name" />
                    <text-input id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                      :class="form.errors.name ? 'border-red-600' : ''" autofocus/>
                    <input-error class="mt-2" :message="form.errors.name" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="email" value="Email" />
                    <text-input id="email" v-model="form.email" type="text" class="mt-1 block w-full"
                      :class="form.errors.email ? 'border-red-600' : ''"/>
                    <input-error class="mt-2" :message="form.errors.email" />
                  </div>
                </div>

                <div class="w-full flex gap-4 mt-4">
                  <div class="w-1/2">
                    <input-label for="phone" value="Phone number" />
                    <text-input id="phone" v-model="form.phone" type="text" class="mt-1 block w-full"
                      :class="form.errors.phone ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.phone" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="address" value="Address" />
                    <text-input id="address" v-model="form.address" type="text" class="mt-1 block w-full"
                      :class="form.errors.address ? 'border-red-600' : ''"/>
                    <input-error class="mt-2" :message="form.errors.address" />
                  </div>
                </div>

                <div class="w-full flex gap-4 mt-4">
                  <div class="w-1/2">
                    <input-label for="city" value="City" />
                    <text-input id="city" v-model="form.city" type="text" class="mt-1 block w-full"
                      :class="form.errors.city ? 'border-red-600' : ''"/>
                    <input-error class="mt-2" :message="form.errors.city" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="region" value="Province/State" />
                    <text-input id="region" v-model="form.region" type="text" class="mt-1 block w-full"
                      :class="form.errors.region ? 'border-red-600' : ''"/>
                    <input-error class="mt-2" :message="form.errors.region" />
                  </div>
                </div>

                <div class="w-full flex gap-4 mt-4">
                  <div class="w-1/2">
                    <input-label for="country" value="Country" />
                    <select name="country" v-model="form.country" class="border-gray-300 w-full mt-1 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :class="form.errors.country ? 'border-red-600' : ''">
                      <option :value="null" />
                      <option value="US">United States</option>
                      <option value="MX">Mexico</option>
                    </select>
                    <input-error class="mt-2" :message="form.errors.country" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="postal_code" value="Postal code"/>
                    <text-input id="postal_code" v-model="form.postal_code" type="text" class="mt-1 block w-full"
                      :class="form.errors.postal_code ? 'border-red-600' : ''"/>
                    <input-error class="mt-2" :message="form.errors.postal_code" />
                  </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                  <primary-button class="ms-4">
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
