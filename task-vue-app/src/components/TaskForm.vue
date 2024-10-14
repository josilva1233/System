<template>
    <div class="task-form">
      <h2>{{ isEditing ? 'Editar Tarefa' : 'Adicionar Tarefa' }}</h2>
      <form @submit.prevent="handleSubmit">
        <div>
          <label for="title">Título:</label>
          <input type="text" id="title" v-model="task.title" required />
        </div>
        <div>
          <label for="description">Descrição:</label>
          <textarea id="description" v-model="task.description"></textarea>
        </div>
        <button type="submit">{{ isEditing ? 'Atualizar' : 'Adicionar' }}</button>
        <button type="button" @click="resetForm">Cancelar</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      existingTask: {
        type: Object,
        default: () => null,
      },
    },
    data() {
      return {
        task: {
          title: '',
          description: '',
        },
        isEditing: false,
      };
    },
    watch: {
      existingTask: {
        immediate: true,
        handler(newTask) {
          if (newTask) {
            this.task = { ...newTask };
            this.isEditing = true;
          } else {
            this.resetForm();
          }
        },
      },
    },
    methods: {
      async handleSubmit() {
        try {
          if (this.isEditing) {
            await axios.put(`/api/tasks/${this.task.id}`, this.task);
          } else {
            await axios.post('/api/tasks', this.task);
          }
          this.$emit('task-added'); // Emit an event to notify parent component
          this.resetForm();
        } catch (error) {
          console.error('Erro ao salvar a tarefa:', error);
        }
      },
      resetForm() {
        this.task = { title: '', description: '' };
        this.isEditing = false;
        this.$emit('clear-task'); // Emit an event to clear the selected task in the parent
      },
    },
  };
  </script>
  
  <style scoped>
  .task-form {
    margin-bottom: 20px;
  }
  
  .task-form h2 {
    margin-bottom: 10px;
  }
  
  .task-form form div {
    margin-bottom: 10px;
  }
  </style>