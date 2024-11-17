<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'


export type taskProps = {
    id: Number
    title: string
    status: string
    userName?: string
}

const statusTask = [{
    "key" : "pendente", 
    "title" : "Pendente",
    "color" : ""
}, {
    "key" : "em andamento",
    "title" : "Em andamento",
    "color" : ""
}, {
    "key" : "concluida",
    "title" : "Concluida",
    "color" : ""
}]

const props = defineProps<{
    task: taskProps
}>();

const form = useForm({
    id: props.task.id,
    status: props.task.status,
});
const changeStatus = () => {
    console.log(form.status)
    form.put(route('task.update.status'),{
        onSuccess: () => {
            console.log('certo')
        }
    })
};

</script>

<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
            class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
        >
            <div class="px-4 py-3 text-gray-900 flex justify-between items-center">
                <h3>{{ task.title }}</h3>
                <select @change="changeStatus()" v-model="form.status" class="py-0 text-right border-0 focus:border-0 focus:ring-0">
                    <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
                </select>
            </div>
        </div>
    </div>
</template>