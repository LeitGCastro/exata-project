<script setup lang="ts">
import TaskItem, { taskProps } from '@/Components/TaskItem.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    tasks?: taskProps[],
    successMessage?: string 
}>();

const form = useForm({
    title: '',
});

const submit = () => {
    form.post(route('task.store'), {
        // preserveState: true,
        onSuccess: () => {
          form.reset('title');
        },
    });
};

</script>

<template>
    <Head title="Minhas Tarefas" />

    <AuthenticatedLayout>        
        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-md"
                >
                    <form @submit.prevent="submit">

                        <div class="p-4 flex">
                            <div class="w-5/6">
                                <input
                                    class="block w-full border-gray-300 rounded-sm focus:border-gray-500 focus:ring-gray-500"
                                    v-model="form.title"
                                    placeholder="Adicione uma nova tarefa..." 
                                    ref="input"
                                />
                                <p v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</p>
                            </div>
                            <button 
                                class="w-1/6 border-gray-300 rounded-sm"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Salvando...' : 'Criar Tarefa' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <TaskItem v-for="task in tasks" :task="task"/>
        </div>
        
    </AuthenticatedLayout>
</template>
