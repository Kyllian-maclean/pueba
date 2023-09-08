<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'programa_formacion',
        'status',
    ];

    protected $primaryKey = 'code'; 

    // Relación muchos a muchos con el modelo User para instructores
    public function instructors()
    {
        return $this->belongsToMany(User::class, 'instructors_fichas', 'ficha_id', 'user_id');
    }

    // Relación muchos a muchos con el modelo User para estudiantes
    public function students()
    {
        return $this->belongsToMany(User::class, 'students_fichas', 'ficha_id', 'user_id');
    }

    
}
