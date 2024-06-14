<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Usuario;
use App\Models\Vehiculo;

class Vehiculo extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'marca',
        'modelo',
        'patente',
        'anio',
        'usuario_id',
        'precio',
        'usuario.nombres'
    ];

    /**
     * Filter to fetch the trashed items
     *
     * @var $query, array $filters
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['filter'] ?? null, function ($query, $filter) {
            if ($filter === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class , 'usuario_id' , 'id' );
    }

    public function historial()
    {
        return $this->hasMany(HistorialVehiculo::class , 'id' , 'vehiculo_id');
    }
}
