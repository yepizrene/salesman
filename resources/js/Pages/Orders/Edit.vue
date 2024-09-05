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

const props = defineProps(['order', 'products']);
const modalOpen = ref(false);

const order = useForm({
  _method: 'PUT',
  id: props.order.id,
  user: props.order.user,
  items: props.order.items,
  total: props.order.total
});

const updateOrderTotal = () => {
  order.total = 0.0;
  if (order.items.length > 0)
    order.items.forEach((item) => order.total += item.price);
}

const updateItemQuantity = (item) => {
  let quantity = item.quantity;
  let price = quantity * item.product.price;

  item.price = price;
  item.quantity = quantity;

  updateOrderTotal();
}

const deleteItem = (item) => {
  let index = order.items.indexOf(item);

  order.items.splice(index, 1);

  updateOrderTotal();
}

const getItem = (product) => {
  let foundItem = order.items.find((item) => item.product === product);

  return foundItem;
}

const addProductToOrder = (product) => {
  let existsItem = isProductAdded(product);
  let quantity = 0;
  let price = product.price * 1;

  if (!existsItem) {
    order.items.push({ 'product': product, 'quantity': quantity += 1, 'price': price = product.price });

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

const isProductAdded = (product) => {
  let isAdded = false;
  let found = order.items.find((item) => item.product === product);
  if (found)
    isAdded = true;
  return isAdded;
}

const closeModal = () => {
  modalOpen.value = false;
}

const submit = () => {
  order.post(route('orders.update', { 'order': order }));
};

const saveOrder = () => {
  if (order.items.length === 0)
    modalOpen.value = true;
  else {
    submit();
  }
}

const number_format = (number, decimals, dec_point, thousands_sep) => {
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
</script>

<template>
  <AppLayout title="Edit order">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <nav-link :href="route('orders.index')" class="font-semibold text-xl text-blueberry-600 leading-tight">
          Orders
        </nav-link> / Edit / order id: {{ props.order.id }} | created by: {{ props.order.user.name }} | {{
          props.order.customerName }} | {{
          props.order.items.length }} Items | {{ props.order.formattedTotal }}

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
                <tr class="bg-white border-b" v-for="item in order.items" :key="item.product.id">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ item.product.name }}
                  </th>
                  <td class="px-6 py-4 flex gap-2">
                    <input type="number" v-model="item.quantity" min="1" @change="updateItemQuantity(item)"
                      class="border-gray-300 rounded-md shadow-sm text-sm w-16 font-extrabold" />
                    <danger-button class="text-xs w-14 px-0 py-0"><trash-icon class="w-full"
                        @click="deleteItem(item)" /></danger-button>
                  </td>
                  <td class="px-6 py-4">
                    $ {{ number_format(item.price, 2) }}
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
                    $ {{ number_format(product.price, 2) }}
                  </td>
                </tr>
                <tr class="bg-white border-b" v-if="products.length === 0">
                  <td class="px-6 py-4 border-t" colspan="4">No items found.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="h-36 flex items-center justify-between col-span-3 border rounded-xl p-2">
            <h1 class="font-bold text-5xl w-2/5"> $ {{ number_format(order.total, 2) }}</h1>
            <primary-button @click="saveOrder"
              class="w-3/5 h-1/2 !text-2xl flex items-center justify-center !font-extrabold bg-green-800 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:ring-green-900">
              <SaveIcon class="h-full mr-2" /> Update order
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
