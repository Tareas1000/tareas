<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'Libros';

    protected $fillable = [
        'titulo',
        'año_publicacion',
        'id_categoria'
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'Libro_Autor', 'id_libro', 'id_autor');
    }

    public function prestamos(): BelongsToMany
    {
        return $this->belongsToMany(Prestamo::class, 'Detalle_Prestamo', 'id_libro', 'id_prestamo');
    }
}
