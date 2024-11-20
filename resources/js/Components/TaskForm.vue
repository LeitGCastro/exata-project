<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faTrash, faXmark } from '@fortawesome/free-solid-svg-icons'
import { taskProps, statusTaskProps } from './TaskItem.vue';
import Modal from './Modal.vue';
import { ref } from 'vue';

const props = defineProps<{
    task: taskProps
    statusTask: statusTaskProps[]
}>();

let isModalVisible = ref(false);
const toggleModal = () => {
    console.log('teste')
    isModalVisible.value = !isModalVisible.value
}

const updateTaskForm = useForm({
    title: props.task?.title,
    status: props.task?.status,
    description: props.task?.description,
})
const submitUpdateTask = () => {
    updateTaskForm.put(route('task.update', {task_id: props.task.id}), {
        onSuccess: () => {
            updateTaskForm.reset();
        },
    });
}

const deleteTaskForm = useForm({
})
const submitDeleteTask = () => {
    deleteTaskForm.delete(route('task.delete', {task_id: props.task.id}),{
        onSuccess: () => {
        },
    })
}

</script>

<template>
    <div class="lg:w-1/4 md:w-1/3 sm:w-4/6 w-full bg-white shadow-sm">
        <div class="overflow-hidden bg-white py-6">
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
                        <textarea name="description" id="description" v-model="updateTaskForm.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm min-h-48 focus:border-indigo-500 focus:ring-indigo-500">
                            {{ updateTaskForm.description }}
                        </textarea>
                        <InputError class="mt-2" :message="updateTaskForm.errors.description" />
                    </div>
                    <div class="flex justify-end space-x-2">
                        <PrimaryButton
                            class="m-0"
                            :class="{ 'opacity-25': updateTaskForm.processing }"
                            :disabled="updateTaskForm.processing"
                        >
                            Salvar
                        </PrimaryButton>
                        <button
                            type="button"
                            title="Excluir tarefa"
                            class="bg-red-500 hover:bg-red-700 inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                            :disabled="updateTaskForm.processing"
                            @click="toggleModal"
                        >
                            <FontAwesomeIcon :icon="faTrash" size="lg"/>
                        </button>
                    </div>
                </div>

            </form>
        </div>
        <Modal :show="isModalVisible" max-width="sm" @click.self="toggleModal" :closeable="false">
            <div class="overflow-hidden w-full bg-white shadow-sm px-4 py-3 sm:rounded-lg">
                <div class="flex justify-end w-full text-zinc-700">
                    <button type="button" @click="toggleModal">
                        <FontAwesomeIcon :icon="faXmark" class="color-" size="xl"/>
                    </button>
                </div>
                <form @submit.prevent="submitDeleteTask">
                    <div class="text-gray-900">
                        <h1>Tem certeza que deseja excluir a tarefa?</h1>
                    </div>
                    <div class="flex justify-end mt-3">
                        <button
                            class="bg-red-500 hover:bg-red-700 inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                            :class="{ 'opacity-25': deleteTaskForm.processing }"
                            :disabled="deleteTaskForm.processing"
                            @click="toggleModal"
                        >
                            Excluir tarefa
                        </button>
                    </div>
                </form>
            </div>

        </Modal>
    </div>
</template>