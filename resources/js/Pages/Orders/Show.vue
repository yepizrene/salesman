<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CircleCrossIcon from '@/Components/icons/CircleCrossIcon.vue';
import NavLink from '@/Components/NavLink.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import EditIcon from '@/Components/icons/EditIcon.vue';

const props = defineProps(['order', 'products']);
const modalOpen = ref(false);
const canceled = ref(!props.order.status);

const cancelOrder = () => {
  router.post(route('orders.cancel'),props.order);
}

const closeModal = () => {
  modalOpen.value = false;
}
</script>

<template>
  <AppLayout title="Show order" :class="{ canceled: canceled }">
    <template #header>
      <h2 class="w-full flex font-semibold text-xl text-gray-800 leading-tight justify-between">
        <div>
          <nav-link :href="route('orders.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
            Orders
          </nav-link> / order id:{{ order.id }} | created by: {{ order.user.name }} | {{ order.customerName }} | {{
            order.items.length }} Items | {{ order.formattedTotal }}
        </div>
      </h2>
    </template>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="p-4 h-full bg-white border-b border-gray-200 grid grid-cols-6 gap-2 rounded-md justify-center">
          <div class="h-80 col-span-3 border rounded-xl p-2 overflow-y-scroll">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3">
                    Product
                  </th>
                  <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                      Quantity
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                      Price
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-white border-b" v-for="item in order.items" :key="item.id">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ item.product.name }}
                  </th>

                  <td class="px-6 py-4 flex gap-2">
                    {{ item.quantity }}
                  </td>

                  <td class="px-6 py-4">
                    $ {{ item.formattedPrice }}
                  </td>
                </tr>
              </tbody>
            </table>

          </div>
          <div class="h-80 p-2 col-span-3 border rounded-xl overflow-y-scroll">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 table-fixed">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                <tr>
                  <th scope="col" class="px-6 py-3">
                    Description
                  </th>
                  <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                      Quantity
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                      Price
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-white border-b cursor-pointer hover:bg-gray-100" v-for="product in products"
                  :key="product.id">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ product.name }}
                  </th>
                  <td class="px-6 py-4">
                    {{ product.quantity }}
                  </td>
                  <td class="px-6 py-4">
                    $ {{ product.price.toFixed(2) }}
                  </td>
                </tr>
                <tr class="bg-white border-b" v-if="products.length === 0">
                  <td class="px-6 py-4 border-t" colspan="4">No items found.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="h-36 flex items-center justify-between col-span-3 border rounded-xl p-2">
            <h1 class="font-bold text-5xl w-2/5">$ {{ order.formattedTotal }}</h1>
            <danger-button v-if="order.status" class="w-3/5 h-1/2 !text-2xl !font-bold" @click="modalOpen = true">
              <CircleCrossIcon class="h-full mr-2" /> Cancel order
            </danger-button>
          </div>
          <div class="h-36 flex items-baseline col-span-3 border rounded-xl p-2">
            <Link :href="route('orders.edit', { 'order': order })" v-if="order.status"
              class=" inline-flex items-center px-4 py-2 bg-blueberry-800 border border-transparent rounded-md font-semibold text-sm text-white hover:text-white focus:text-white uppercase hover:bg-blueberry-700 focus:bg-blueberry-700 active:bg-blueberry-900 focus:outline-none focus:ring-2 focus:ring-blueberry-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
            <EditIcon class="h-6 mr-4" /> Edit order
            </Link>
          </div>
        </div>
      </div>
    </div>

    <dialog-modal :show="modalOpen" @close="closeModal">
      <template #title>
        <h1 class="text-2xl font-bold">Cancel order</h1>
      </template>
      <template #content>
        <h2 class="text-xl font-bold">Are you sure to cancel this order?</h2>
      </template>
      <template #footer>
        <div class="flex w-full gap-2 items-end justify-end">
          <danger-button @click="cancelOrder()">Cancel order</danger-button>
          <primary-button @click="closeModal">No</primary-button>
        </div>
      </template>
    </dialog-modal>

  </AppLayout>
</template>
