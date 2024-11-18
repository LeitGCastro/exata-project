<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'


export type taskProps = {
    id: Number
    title: string
    status: string
    description?: string
    userName?: string
}

type statusTask = {
    key: string
    title: string
    color: string
}

const props = defineProps<{
    task: taskProps
    statusTask: statusTask[]
}>();

const form = useForm({
    id: props.task.id,
    status: props.task.status,
});
const changeStatus = () => {
    console.log(form.status)
    form.put(route('task.updatestatus'),{
        onSuccess: () => {
        }
    })
};

</script>

<template>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg hover:bg-slate-200">
        <div class="px-4 py-3 text-gray-900 flex justify-between items-center hover:bg-slate-200">
            <a :href="route('task.form', {task_id: task.id})" class="w-full hover:cursor-pointer hover:underline ">
                <h3>{{ task.title }}</h3>
            </a>
            <select @change="changeStatus()" v-model="form.status" class="py-0 text-right border-0 bg-transparent focus:border-0 focus:ring-0">
                <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
            </select>
        </div>
    </div>
</template>