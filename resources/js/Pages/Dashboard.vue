<script setup lang="ts">
import TaskItem, { taskProps } from '@/Components/TaskItem.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    tasks: taskProps[],
    task?: taskProps,
    successMessage?: string 
}>();

const statusTask = [{
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

const updateTaskForm = useForm({
    ...props.task
})
const submitUpdateTask = () => {
    updateTaskForm.put(route('task.update'), {
        onSuccess: () => {
            updateTaskForm.reset();
        },
    });
}

const filterForm = useForm({
    status: "",
    sortMethod: "desc"
})
const filtredTasks = () => {
    const filtred = !filterForm.status ? props.tasks : props.tasks.filter((task) => task.status === filterForm.status)
    return filtred.sort((a,b) => {
        const dateA = new Date(a.created_at).getTime();
        const dateB = new Date(b.created_at).getTime();
        return filterForm.sortMethod === "asc" ? dateA - dateB : dateB - dateA
    });
}
</script>

<template>
    <Head title="Minhas Tarefas" />

    <AuthenticatedLayout>     
        <div class="flex">
            <div class="py-6 w-full sm:block hidden">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                    <div class="overflow-hidden bg-white shadow-sm mb-6 sm:rounded-md">
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

                    <div class="mb-3 mr-4 flex justify-end">
                        <select v-model="filterForm.status" class="py-0 text-center border-0 border-b-2 border-zinc-200 bg-transparent focus:border-b-2 focus:ring-0">
                            <option value="">Todos</option>
                            <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
                        </select>
                        <span @click="" class="py-0 text-center border-0 border-b-2 border-zinc-200 bg-transparent hover:cursor-pointer focus:border-b-2 focus:ring-0 min-w-fit border-l-2 pl-5">Data de criação</span>
                    </div>

                    <div class="space-y-3">
                        <TaskItem v-for="task in filtredTasks()" :task="task" :status-task="statusTask"/>
                    </div>

                </div>
            </div>
            <div v-if="task" class="lg:w-1/4 md:w-1/3 sm:w-4/6 w-full bg-white shadow-sm">
                <div class="overflow-hidden bg-white shadow-sm mb-6 sm:rounded-md">
                    <form @submit.prevent="submitUpdateTask">
                        
                        <div class="px-4 space-y-4">
                            <div>
                                <label for="title" class="text-md font-medium text-gray-70">Titulo</label>
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="updateTaskForm.title"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="updateTaskForm.errors.title" />
                            </div>
                            <div>
                                <label for="status" class="text-md font-medium text-gray-70">Status</label>
                                <select v-model="updateTaskForm.status" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option v-for="status in statusTask" :value="status.key" :key="status.key">{{ status.title }}</option>
                                </select>
                                <InputError class="mt-2" :message="updateTaskForm.errors.status" />
                            </div>
                            <div>
                                <label for="description" class="text-md font-medium text-gray-70">Descrição</label>
                                <textarea name="description" id="description" v-model="updateTaskForm.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    {{ updateTaskForm.description }}
                                </textarea>
                                <InputError class="mt-2" :message="updateTaskForm.errors.description" />
                            </div>
                            <div class="flex justify-end">
                                <PrimaryButton
                                    class="ms-4"
                                    :class="{ 'opacity-25': updateTaskForm.processing }"
                                    :disabled="updateTaskForm.processing"
                                >
                                    Salvar
                                </PrimaryButton>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>           
    </AuthenticatedLayout>
</template>
