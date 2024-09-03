<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import NumberInput from '@/Components/NumberInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';

const form = useForm({
  name: '',
  description: '',
  price: '',
  quantity: '',
  status: '1'
});

const submit = () => {
  form.post(route('products.store'), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <AppLayout title="New product">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('products.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Products
        </nav-link> / Create
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200 flex justify-center">
            <div class="w-2/3">
              <form @submit.prevent="submit">
                <div class="w-full">
                  <input-label for="name" value="Name" />
                  <text-input id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                    :class="form.errors.name ? 'border-red-600' : ''" autofocus />
                  <input-error class="mt-2" :message="form.errors.name" />
                </div>
                <div class="w-full">
                  <input-label for="description" value="Description" />
                  <text-input id="description" v-model="form.description" type="text" class="mt-1 block w-full"
                    :class="form.errors.description ? 'border-red-600' : ''" />
                  <input-error class="mt-2" :message="form.errors.description" />
                </div>

                <div class="w-full flex gap-4 mt-4">
                  <div class="w-1/3">
                    <input-label for="price" value="Price" />
                    <text-input id="price" v-model="form.price" type="text" class="mt-1 block w-full"
                      :class="form.errors.price ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.price" />
                  </div>

                  <div class="w-1/3">
                    <input-label for="quantity" value="Quantity" />
                    <text-input id="quantity" v-model="form.quantity" type="text" class="mt-1 block w-full"
                      :class="form.errors.quantity ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.quantity" />
                  </div>

                  <div class="w-1/3">
                    <input-label for="status" value="Status" />
                    <select name="status" v-model="form.status"
                      class="border-gray-300 w-full mt-1 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      :class="form.errors.status ? 'border-red-600' : ''">

                      <option value=1>Active</option>
                      <option value=0>Inactive</option>
                    </select>
                    <input-error class="mt-2" :message="form.errors.status" />
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
