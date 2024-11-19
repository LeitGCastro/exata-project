<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { taskProps, statusTaskProps } from './TaskItem.vue';

const props = defineProps<{
    task: taskProps
    statusTask: statusTaskProps[]
}>();

const updateTaskForm = useForm({
    id: props.task?.id,
    title: props.task?.title,
    status: props.task?.status,
    description: props.task?.description,
})
const submitUpdateTask = () => {
    updateTaskForm.put(route('task.update'), {
        onSuccess: () => {
            updateTaskForm.reset();
        },
    });
}

</script>

<template>
    <div class="lg:w-1/4 md:w-1/3 sm:w-4/6 w-full bg-white shadow-sm py-6">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-md">
            <form @submit.prevent="submitUpdateTask">
                
                <div class="px-4 space-y-4">
                    <div>
                        <label for="title" class="text-md font-medium text-gray-70">Titulo</label>
                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="updateTaskForm.title"
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
</template>