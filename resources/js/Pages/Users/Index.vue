<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, Link } from '@inertiajs/vue3';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

import TrashIcon from '@/Components/icons/TrashIcon.vue';

const props = defineProps(['users']);

const createUser = () => {
  router.get(route('users.create'))
}
</script>

<template>
  <app-layout title="Manage users">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Users
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="w-full flex justify-end">
          <primary-button class="gap-2 mb-5" @click="createUser">
            <svg class="h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Create user
          </primary-button>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <table class="w-full whitespace-nowrap">
              <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Name</th>
                <th class="pb-4 pt-6 px-6">Email</th>
              </tr>
              <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                    :href="route('users.edit', { 'user': user })">
                  {{ user.name }}
                  <trash-icon v-if="user.deleted_at"/>
                  <!-- <icon v-if="user.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" /> -->
                  </Link>
                </td>
                <td class="border-t">
                  <Link class="flex items-center px-6 py-4" :href="route('users.edit', { 'user': user })" tabindex="-1">
                  {{ user.email }}
                  </Link>
                </td>
              </tr>
              <tr v-if="users.data.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No users found.</td>
              </tr>
            </table>
            <pagination class="mt-6 flex justify-center items-center" :links="users.links" />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
