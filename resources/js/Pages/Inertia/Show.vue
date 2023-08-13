<script setup>
import { Inertia } from '@inertiajs/inertia';

defineProps({
    id : String,
    blog: Object
})

const deleteConfirm = (id) => {
    // console.log(id)
    Inertia.delete(`/inertia/${id}`, {
        onBefore: () => confirm('정말 삭제하시겠습니까?')
    })
}

</script>

<template>
    {{ id }}<br>
    {{ blog.title }}<br>
    <button @click="deleteConfirm(blog.id)">삭제</button>
</template>