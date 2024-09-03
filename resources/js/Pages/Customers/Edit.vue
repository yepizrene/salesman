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
  customer: Object
});

const form = useForm({
  _method: 'PUT',
  name: props.customer.name,
  email: props.customer.email,
  phone: props.customer.phone,
  address: props.customer.address,
  city: props.customer.city,
  region: props.customer.region,
  country: props.customer.country,
  postal_code: props.customer.postal_code
});

const modalOpen = ref(false);

const deleteCustomer = (selectedCustomer) => {
  closeModal();
  router.delete(route('customers.destroy', { customer: selectedCustomer }));
}

const closeModal = () => {
  modalOpen.value = false;
}

const submit = () => {
  form.post(route('customers.update', props.customer), {
    preserveScroll: true,
  });
};

</script>

<template>
  <AppLayout title="New user">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('customers.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Customers
        </nav-link> / {{ customer.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200 flex justify-center">
            <div class="w-1/2">
              <form @submit.prevent="submit">
                <div class="w-full flex gap-4">
                  <div class="w-1/2">
                    <input-label for="name" value="Name" />
                    <text-input id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                      :class="form.errors.name ? 'border-red-600' : ''" autofocus />
                    <input-error class="mt-2" :message="form.errors.name" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="email" value="Email" />
                    <text-input id="email" v-model="form.email" type="text" class="mt-1 block w-full"
                      :class="form.errors.email ? 'border-red-600' : ''" />
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
                      :class="form.errors.address ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.address" />
                  </div>
                </div>

                <div class="w-full flex gap-4 mt-4">
                  <div class="w-1/2">
                    <input-label for="city" value="City" />
                    <text-input id="city" v-model="form.city" type="text" class="mt-1 block w-full"
                      :class="form.errors.city ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.city" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="region" value="Province/State" />
                    <text-input id="region" v-model="form.region" type="text" class="mt-1 block w-full"
                      :class="form.errors.region ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.region" />
                  </div>
                </div>

                <div class="w-full flex gap-4 mt-4">
                  <div class="w-1/2">
                    <input-label for="country" value="Country" />
                    <select name="country" v-model="form.country"
                      class="border-gray-300 w-full mt-1 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      :class="form.errors.country ? 'border-red-600' : ''">
                      <option :value="null" />
                      <option value="US">United States</option>
                      <option value="MX">Mexico</option>
                    </select>
                    <input-error class="mt-2" :message="form.errors.country" />
                  </div>

                  <div class="w-1/2">
                    <input-label for="postal_code" value="Postal code" />
                    <text-input id="postal_code" v-model="form.postal_code" type="text" class="mt-1 block w-full"
                      :class="form.errors.postal_code ? 'border-red-600' : ''" />
                    <input-error class="mt-2" :message="form.errors.postal_code" />
                  </div>
                </div>

                <div class="flex mt-4">
                  <div class="w-1/2 flex items-center justify-start ">
                    <danger-button @click="modalOpen = true">
                      delete customer
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
                  <h1 class="text-2xl font-bold">Delete customer</h1>
                </template>
                <template #content>
                  <h2 class="text-xl font-bold">Are you sure to delete this customer?</h2>
                  <p class="text-lg font-bold text-blueberry-500">{{ customer.email }}</p>
                </template>
                <template #footer>
                  <div class="flex w-full gap-2 items-end justify-end">
                    <danger-button @click="deleteCustomer(customer)">Delete</danger-button>
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
