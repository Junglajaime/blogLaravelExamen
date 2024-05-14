<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tarea
 *
 * @property $id
 * @property $fecha
 * @property $hora
 * @property $titulo
 * @property $imagen
 * @property $descripcion
 * @property $prioridad
 * @property $lugar
 * @property $estado
 * @property $cat_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tarea extends Model
{
    protected $fillable = ['fecha', 'hora', 'titulo', 'imagen', 'descripcion', 'prioridad', 'lugar', 'estado', 'cat_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'cat_id');
    }
}
