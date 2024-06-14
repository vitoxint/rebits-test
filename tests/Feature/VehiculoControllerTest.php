<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Vehiculo;
use App\Models\HistorialVehiculo;

class VehiculoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_store()
    {
        // data faker
        $data = [
            'marca' => $this->faker->word,
            'modelo' => $this->faker->word,
            'patente' => strtoupper($this->faker->bothify('AAAA00')),
            'anio' => $this->faker->numberBetween(1900, 2100),
            'precio' => $this->faker->randomFloat(2, 0, 100000),
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'correo' => $this->faker->unique()->safeEmail,
        ];

        // POST REQUEST
        $response = $this->post(route('vehiculos.store'), $data);

        // REDIRECT
        $response->assertRedirect(route('vehiculos.index'));
        $response->assertSessionHas('message', 'Vehículo creado correctamente');

        // EN CASO DE QUE EL USUARIO ES CREADO
        $this->assertDatabaseHas('usuarios', [
            'correo' => $data['correo'],
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
        ]);

        // EN CASO DE QUE EL VEHICULO ES CREADO
        $this->assertDatabaseHas('vehiculos', [
            'marca' => $data['marca'],
            'modelo' => $data['modelo'],
            'patente' => $data['patente'],
            'anio' => $data['anio'],
            'precio' => $data['precio'],
        ]);

        // OBTENER EL USUARIO
        $usuario = Usuario::where('correo', $data['correo'])->first();

        // INGRESAR A LA TABLA HISTORIAL
        $this->assertDatabaseHas('historial_vehiculos', [
            'usuario_id' => $usuario->id,
            'vehiculo_id' => Vehiculo::where('patente', $data['patente'])->first()->id,
            'vigente' => 1,
        ]);
    }
}
