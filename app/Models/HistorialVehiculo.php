<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Usuario;
use App\Models\Vehiculo;


class HistorialVehiculo extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'usuario_id',
        'vehiculo_id',
        'vigente',
        'id'
        
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class , 'usuario_id' , 'id' );
    }

    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class , 'vehiculo_id' , 'id' );
    }
}
