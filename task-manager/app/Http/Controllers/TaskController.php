<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    // Lista todas as tarefas
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Cria uma nova tarefa
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Criação da nova tarefa
        $task = Task::create($request->only('title', 'description'));

        // Copia para o MySQL
        DB::connection('mysql')->table('tasks')->insert([
            'title' => $task->title,
            'description' => $task->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json($task, 201); // Retorna um código de status 201 para criação
    }

    // Atualiza uma tarefa existente
    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Busca a tarefa no MongoDB
        $task = Task::find($id);
        
        // Verifica se a tarefa existe
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        // Atualiza a tarefa
        $task->update($request->only('title', 'description'));

        // Atualiza no MySQL
        DB::connection('mysql')->table('tasks')->where('id', $id)->update([
            'title' => $task->title,
            'description' => $task->description,
            'updated_at' => now(),
        ]);

        return response()->json($task);
    }

    // Deleta uma tarefa
    public function destroy($id)
    {
        // Verifica se a tarefa existe antes de tentar deletar
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        // Deleta a tarefa do MongoDB
        Task::destroy($id);

        // Deleta no MySQL
        DB::connection('mysql')->table('tasks')->where('id', $id)->delete();

        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
