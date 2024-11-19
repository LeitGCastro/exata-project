<script setup lang="ts">
import TaskItem, { taskProps, statusTaskProps } from '@/Components/TaskItem.vue';
import TaskForm from '@/Components/TaskForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    tasks: taskProps[],
    task?: taskProps,
    successMessage?: string 
}>();

const statusTask:statusTaskProps[] = [{
    "key" : "pendente", 
    "title" : "Pendente"
}, {
    "key" : "em andamento",
    "title" : "Em andamento"
}, {
    "key" : "concluida",
    "title" : "Concluida"
}]

const createTaskForm = useForm({
    title: '',
});
const submit = () => {
    createTaskForm.post(route('task.store'), {
        onSuccess: () => {
            createTaskForm.reset('title');
        },
    });
};

const filterForm = useForm({
    status: "",
    sortIsAscending: true
})

function sortTasks() {
    filterForm.sortIsAscending = !filterForm.sortIsAscending;
    props.tasks.sort((a, b) => {
        const dateA = new Date(a.created_at).getTime();
        const dateB = new Date(b.created_at).getTime();

        return filterForm.sortIsAscending 
        ? dateA - dateB 
        : dateB - dateA
    })
}

const filtredTasks = () => {
    return !filterForm.status 
    ? props.tasks 
    : props.tasks.filter((task) => task.status === filterForm.status)
}
</script>

<template>
    <Head title="Minhas Tarefas" />

    <AuthenticatedLayout>     
        <div class="flex">
            <div class="py-6 w-full sm:block hidden">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm mb-3 sm:rounded-md">
                        <form @submit.prevent="submit">
                            <div class="p-4 flex items-center">
                                <div class="w-full">
                                    <input
                                        class="block w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500"
                                        v-model="createTaskForm.title"
                                        placeholder="Adicione uma nova tarefa..." 
                                        ref="input"
                                    />
                                    <p v-if="createTaskForm.errors.title" class="text-red-500">{{ createTaskForm.errors.title }}</p>
                                </div>
                                <PrimaryButton
                                    class="ms-4 min-w-fit py-3"
                                    :class="{ 'opacity-25': createTaskForm.processing }"
                                    :disabled="createTaskForm.processing"
                                >
                                    {{ createTaskForm.processing ? 'Salvando...' : 'Criar Tarefa' }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>

                    <div v-if="tasks.length" class="mb-3 flex justify-end">
                        <div class="bg-white px-4 py-1 shadow-sm sm:rounded-md flex">
                            <select v-model="filterForm.status" class="py-0 text-center border-0 border-zinc-200 focus:border-0 focus:ring-0">
                                <option value="">Todos</option>
                                <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
                            </select>
                            <span @click="sortTasks()" class="py-0 text-center border-0 border-zinc-200 hover:cursor-pointer focus:border-b-2 focus:ring-0 min-w-fit border-l-2 pl-4">Data de criação</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <TaskItem v-for="task in filtredTasks()" :task="{...task, created_at: new Date(task.created_at)}" :status-task="statusTask"/>
                    </div>

                </div>
            </div>
            <TaskForm v-if="task" :task="task" :statusTask="statusTask"/>
        </div>           
    </AuthenticatedLayout>
</template>
