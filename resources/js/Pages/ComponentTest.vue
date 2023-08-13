<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'

const emitTest = e => console.log(e)

</script>

<template>
<GuestLayout>
    <InputLabel value="제목">Title</InputLabel>
    <TextInput 
        modelValue="초기치 확인"
        @update:modelValue="emitTest"
    ></TextInput>
</GuestLayout>
</template>