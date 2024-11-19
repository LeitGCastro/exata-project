<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

export type taskProps = {
    id: Number
    title: string
    status: string
    description?: string
    created_at: Date
    user?: userProps
}

type userProps = {
    id: Number
    name: string
    email: string
}

export type statusTaskProps = {
    key: string
    title: string
}

const props = defineProps<{
    task: taskProps
    statusTask: statusTaskProps[]
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
        <div class="px-4 py-3 text-gray-900 hover:bg-slate-200 hover:underline">
            <div class="flex justify-between items-center">
                <a :href="route('task.form', {task_id: task.id})" class="w-full hover:cursor-pointer">
                    <h3>{{ task.title }}</h3>
                </a>
                <select @change="changeStatus()" v-model="task.status" class="py-0 text-right border-0 bg-transparent focus:border-0 focus:ring-0 hover:cursor-pointer">
                    <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
                </select>
                <a :href="route('task.form', {task_id: task.id})" class="hover:cursor-pointer min-w-fit border-l-2 border-zinc-300 pl-2">
                    <h5>{{ props.task.created_at.toLocaleDateString('pt-BR')+' '+props.task.created_at.toLocaleTimeString('pt-BR', {hour: "2-digit", minute: "2-digit"}) }}</h5>
                </a>
            </div>
            <a :href="route('task.form', {task_id: task.id})" v-if="task.description || task.user" class="mt-2 border-t-2 border-zinc-300 text-zinc-500 flex justify-between items-center">
                <p>{{ task.description }}</p>
                <h5 v-if="task.user">{{ task.user.name }}</h5>
            </a>            
        </div>
    </div>
</template>