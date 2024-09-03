<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TrashIcon from '@/Components/icons/TrashIcon.vue';
import SaveIcon from '@/Components/icons/SaveIcon.vue';
import NavLink from '@/Components/NavLink.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['user', 'customers', 'products']);

//items to order
const orderProducts = ref([]);
const orderTotal = ref(0.0);

const order = useForm({
  user: props.user,
  items: orderProducts.value,
  total: orderTotal.value
});

const submit = () => {
  order.post(route('orders.store'));
};

const modalOpen = ref(false);

const addProductToOrder = (product) => {
  let existsItem = isProductAdded(product);
  let quantity = 0;
  let price = product.price * 1;

  if (!existsItem) {
    orderProducts.value.push({ 'product': product, 'quantity': quantity += 1, 'price': price = product.price });

    updateOrderTotal();
  }


  if (existsItem) {
    let foundItem = getItem(product);

    quantity = foundItem.quantity + 1;
    price = product.price * quantity;

    foundItem.quantity = quantity;
    foundItem.price = price;

    updateOrderTotal();
  }
}

const updateItemQuantity = (item) => {
  let quantity = item.quantity;
  let price = quantity*item.product.price;

  item.price = price;
  item.quantity = quantity;

  updateOrderTotal();
}

const isProductAdded = (product) => {
  let isAdded = false;

  let found = orderProducts.value.find((item) => item.product === product);

  if (found)
    isAdded = true;

  return isAdded;
}

const getItem = (product) => {
  let foundItem = orderProducts.value.find((item) => item.product === product);

  return foundItem;
}

const deleteItem = (item) => {
  let index = orderProducts.value.indexOf(item);

  orderProducts.value.splice(index, 1);

  updateOrderTotal();
}

const updateOrderTotal = () => {
  orderTotal.value = 0.0;
  if (orderProducts.value.length > 0)
    orderProducts.value.forEach((item) => orderTotal.value += item.price);
}

const closeModal = () => {
  modalOpen.value = false;
}

const saveOrder = () => {
  if (orderProducts.value.length === 0)
    modalOpen.value = true;
  else{
    console.log(order);
    order.items = orderProducts.value;
    order.total = orderTotal;
    submit();
  }

}


</script>

<template>
  <AppLayout title="New order">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('orders.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Orders
        </nav-link> / Create
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
                <tr class="bg-white border-b" v-for="item in orderProducts" :key="item.product.id">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ item.product.name }}
                  </th>
                  <td class="px-6 py-4 flex gap-2">
                    <input type="number" v-model="item.quantity" min="1"
                      @change="updateItemQuantity(item)"
                      class="border-gray-300 rounded-md shadow-sm text-sm w-16 font-extrabold"/>
                    <danger-button class="text-xs w-14 px-0 py-0"><trash-icon class="w-full"
                        @click="deleteItem(item)" /></danger-button>
                  </td>
                  <td class="px-6 py-4">
                    $ {{ item.price.toFixed(2) }}
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
                  :key="product.id" @click="addProductToOrder(product)">
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
            <h1 class="font-bold text-5xl w-2/5"> $ {{ orderTotal.toFixed(2) }}</h1>
            <primary-button @click="saveOrder"
              class="w-2/5 h-1/2 !text-2xl !font-extrabold bg-green-800 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:ring-green-900">
              <SaveIcon class="h-full mr-2" /> Save order
            </primary-button>
          </div>
          <div class="h-36 flex items-center justify-between col-span-3 border rounded-xl p-2">

          </div>
        </div>

      </div>
    </div>

    <dialog-modal :show="modalOpen" @close="closeModal">
      <template #title>
        <h1 class="text-2xl font-bold">Alert</h1>
      </template>
      <template #content>
        <h2 class="text-xl font-bold">You cannot create an order without products!</h2>
      </template>
      <template #footer>
        <div class="flex w-full gap-2 items-end justify-end">
          <primary-button @click="closeModal">Close</primary-button>
        </div>
      </template>
    </dialog-modal>
  </AppLayout>
</template>
