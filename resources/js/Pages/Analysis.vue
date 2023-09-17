<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, onMounted } from 'vue';
import { getToday } from '@/common';
import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';

onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay'
})

const data = reactive({})

const getData = async () => {
    try{
        await axios.get('/api/analysis/', {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type
            }
        })
        .then( res => {
            data.data = res.data.data;
            data.labels = res.data.labels;
            data.totals = res.data.totals;
            data.type = res.data.type;
            console.log(res.data);
        })
    } catch (e) {
        console.log(e.message);
    }
}

</script>

<template>
    <Head title="데이터 분석" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">데이터 분석</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getData">
                            분석방법<br>
                            <input type="radio" v-model="form.type" value="perDay" checked><span class="mr-2">일별</span>
                            <input type="radio" v-model="form.type" value="perMonth"><span class="mr-2">월별</span>
                            <input type="radio" v-model="form.type" value="perYear"><span class="mr-2">년별</span>
                            <input type="radio" v-model="form.type" value="decile"><span class="mr-2">데실</span>
                            <br>
                            From: <input type="date" name="startDate" v-model="form.startDate">
                            To: <input type="date" name="endDate" v-model="form.endDate">
                            <br>
                            <button class="flex mx-auto text-white bg-indigo-500 border-0 mt-4 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">분석하기</button>
                        </form>

                        <div v-show="data.data">
                            <Chart :data="data" />
                            <ResultTable :data="data" />
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
