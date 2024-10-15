<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // Adiciona suporte para factories

    protected $connection = 'mongodb'; // Define a conexão do MongoDB
    protected $fillable = ['title', 'description']; // Campos que podem ser preenchidos em massa

    // Opcional: Você pode adicionar métodos ou relacionamentos aqui
}
