<template>
    <div>
        <h1>Gerenciador de Tarefas</h1>
        <task-form @task-added="fetchTasks" />
        <ul>
            <li v-for="task in tasks" :key="task.id">
                {{ task.title }} - <button @click="toggleCompletion(task)">Concluir</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';
import TaskForm from './TaskForm.vue';

export default {
    components: { TaskForm },
    data() {
        return {
            tasks: []
        };
    },
    methods: {
        fetchTasks() {
            axios.get('/api/tasks').then(response => {
                this.tasks = response.data;
            });
        },
        toggleCompletion(task) {
            axios.patch(`/api/tasks/${task.id}`, { completed: !task.completed }).then(() => {
                this.fetchTasks();
            });
        }
    },
    mounted() {
        this.fetchTasks();
    }
};
</script>