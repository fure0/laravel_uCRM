<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const newTitle = ref('');
const newContent = ref('');

</script>

<template>
Inertia테스트입니다.<br>
<a href="/">a태그</a><br>
<Link href="/">링크</Link><br>
<Link :href="route('inertia.index')">이름붙힌 링크</Link><br>
<Link :href="route('inertia.show', { id: 1 })">루트 파라미터</Link><br>

<div class="mb-8"></div>
<input type="text" name="newTitle" v-model="newTitle"><br>
<input type="text" name="newContent" v-model="newContent"><br>
<Link as="button" method="post" :href="route('inertia.store')"
:data="{
    title: newTitle,
    content: newContent
}"
>DB저장 테스트</Link>


</template>