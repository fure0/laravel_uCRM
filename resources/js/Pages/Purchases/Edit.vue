<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted, ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import dayjs from 'dayjs';

const props = defineProps({
    'order': Array,
    'items': Array
})

onMounted(() => {
    props.items.forEach((item) => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.quantity
        })
    })
})

const itemList = ref([])

const form = reactive({
    id: props.order[0].id,
    date: dayjs(props.order[0].created_at).format("YYYY-MM-DD"),
    customer_id: props.order[0].customer_id,
    status: props.order[0].status,
    items: []
})

const totalPrice = computed(() => {
    let total = 0
    itemList.value.forEach( item => {
        total += item.price * item.quantity
    })
    return total
})


const updatePurchase = (id) => {
    itemList.value.forEach( item => {
        if (item.quantity > 0) {
            form.items.push({
                id: item.id,
                quantity: item.quantity
            })
        }
    })
    Inertia.put(route('purchases.update', { purchase: id }), form)
}

const quantity = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"] // option用

</script>

<template>
    <Head title="구매이력 수정" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">구매이력 수정</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updatePurchase(form.id)">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="date" class="leading-7 text-sm text-gray-600">날짜</label>
                                                    <input disabled type="date" id="date" name="date" :value="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="customer" class="leading-7 text-sm text-gray-600">회원명</label>
                                                    <input disabled type="text" id="customer" name="customer" :value="props.order[0].customer_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                </div>
                                            </div>

                                            <div class="w-full mt-4 mx-auto overflow-auto">
                                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                                    <thead>
                                                        <tr>
                                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Id</th>
                                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">상품명</th>
                                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">가격</th>
                                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">수량</th>
                                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">소계</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="item in itemList" :key="item.id">
                                                            <td class="border-b-2 border-gray-200 px-4 py-3">{{ item.id }}</td>
                                                            <td class="border-b-2 border-gray-200 px-4 py-3">{{ item.name }}</td>
                                                            <td class="border-b-2 border-gray-200 px-4 py-3">{{ item.price }}</td>
                                                            <td class="border-b-2 border-gray-200 px-4 py-3">
                                                                <select name="quantity" v-model="item.quantity">
                                                                    <option v-for="q in quantity" :value="q" :key="q">{{ q }}</option>
                                                                </select>
                                                            </td>
                                                            <td class="border-b-2 border-gray-200 px-4 py-3">{{ item.price * item.quantity }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div>
                                                    <label for="price" class="leading-7 text-sm text-gray-600">합계</label>
                                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        {{ totalPrice }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="status" class="leading-7 text-sm text-gray-600">상태</label>
                                                    <input type="radio" class="ml-2" v-model="form.status" name="status" value="1">정상
                                                    <input type="radio" class="ml-2" v-model="form.status" name="status" value="0">취소
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">수정하기</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
