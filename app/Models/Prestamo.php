<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'Prestamos';

    protected $fillable = [
        'id_usuario',
        'fecha_prestamo',
        'fecha_devolucion'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function libros(): BelongsToMany
    {
        return $this->belongsToMany(Libro::class, 'Detalle_Prestamo', 'id_prestamo', 'id_libro');
    }
}
