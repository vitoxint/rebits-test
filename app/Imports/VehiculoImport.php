<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Usuario;
use App\Models\Vehiculo;
use App\Models\HistorialVehiculo;

class VehiculoImport implements ToCollection ,  WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {

            $vehiculo = Vehiculo::updateOrCreate([
                
                'patente' => $row['patente']
            ],[
                'marca'=> $row['marca'],
                'modelo' => $row['modelo'],
                'anio' => $row['anio'],
                'precio' => $row['precio'],
                'usuario_id' => Usuario::updateOrCreate(
                    [
                        'correo' => $row['correo'], 
                        'nombres' => $row['nombres'],
                        'apellidos' => $row['apellidos']
                    ]
                )->id
               
            ]);
    
            HistorialVehiculo::updateOrCreate(
                ['usuario_id' => $vehiculo->usuario_id ,
                 'vehiculo_id' => $vehiculo->id 
            
                ], 
                ['vigente' => 1
                ]
            );
    
            HistorialVehiculo::where('vehiculo_id', $vehiculo->id)
            ->where('usuario_id', '!=', $vehiculo->usuario_id)->delete();


            /* $customer = Customer::where('email', $row['email'])->first();
            if($customer){

                $customer->update([
                    'name' => $row['name'],
                    'phone' => $row['phone'],
                ]);

            }else{

                Customer::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                ]);
            } */

        }
    }
}
