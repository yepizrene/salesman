<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, Link } from '@inertiajs/vue3';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

import TrashIcon from '@/Components/icons/TrashIcon.vue';

const props = defineProps(['orders']);

const createOrder = () => {
  router.get(route('orders.create'));
}

</script>

<template>
  <app-layout title="Orders">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Orders
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="w-full flex justify-end">
          <primary-button class="gap-2 mb-5" @click="createOrder">
            <svg class="h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Create order
          </primary-button>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <table class="w-full whitespace-nowrap">
              <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Id</th>
                <th class="pb-4 pt-6 px-6">User</th>
                <th class="pb-4 pt-6 px-6">Customer</th>
                <th class="pb-4 pt-6 px-6">Items</th>
                <th class="pb-4 pt-6 px-6">Total</th>
                <th class="pb-4 pt-6 px-6">Status</th>
              </tr>
              <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                    :href="route('orders.show', { 'order': order })">
                  {{ order.id }}
                  <trash-icon v-if="order.deleted_at" />
                  </Link>
                </td>
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4" :href="route('orders.show', { 'order': order })"
                    tabindex="-1">
                  {{ order.user.name }}
                  </Link>
                </td>
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4" :href="route('orders.show', { 'order': order })"
                    tabindex="-1">
                  {{ order.customerName }}
                  </Link>
                </td>
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4" :href="route('orders.show', { 'order': order })"
                    tabindex="-1">
                  {{ order.items.length }}
                  </Link>
                </td>
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4" :href="route('orders.show', { 'order': order })"
                    tabindex="-1">
                  {{ order.formattedTotal }}
                  </Link>
                </td>
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4" :href="route('orders.show', { 'order': order })"
                    tabindex="-1">
                  <span v-if="!order.status"
                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Canceled</span>
                  <span v-if="order.status"
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                  </Link>
                </td>
              </tr>
              <tr v-if="orders.data.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No items found.</td>
              </tr>
            </table>
            <pagination class="mt-6 flex justify-center items-center" :links="orders.links" />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
