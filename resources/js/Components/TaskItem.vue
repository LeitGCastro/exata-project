<script setup lang="ts">
import { FormatDate } from '@/utils/FormatDate'
import { useForm } from '@inertiajs/vue3'


export type taskProps = {
    id: Number
    title: string
    status: string
    created_at: Date
}

type statusTask = {
    key: string
    title: string
}

const props = defineProps<{
    task: taskProps
    statusTask: statusTask[]
}>();

props.task.created_at = new Date(props.task.created_at)

const form = useForm({
    id: props.task.id,
    status: "",
});
const changeStatus = () => {
    form.status = props.task.status
    form.put(route('task.updatestatus'),{
        onSuccess: () => {
        }
    })
};
</script>

<template>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg hover:bg-slate-200">
        <div class="px-4 py-3 text-gray-900 flex justify-between items-center hover:bg-slate-200 hover:underline">
            <a :href="route('task.form', {task_id: task.id})" class="w-full hover:cursor-pointer">
                <h3>{{ task.title }}</h3>
            </a>
            <select @change="changeStatus()" v-model="task.status" class="py-0 text-right border-0 bg-transparent focus:border-0 focus:ring-0 hover:cursor-pointer">
                <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
            </select>
            <a :href="route('task.form', {task_id: task.id})" class="hover:cursor-pointer min-w-fit border-l-2 border-zinc-300 pl-3">
                <h5>{{ FormatDate.ToBrDate(task.created_at) }} {{ FormatDate.ToBrTime(task.created_at) }}</h5>
            </a>
        </div>
    </div>
</template>