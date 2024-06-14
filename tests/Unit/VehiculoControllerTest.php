<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\VehiculoController;
use App\Models\Usuario;
use App\Models\Vehiculo;
use App\Models\HistorialVehiculo;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Mockery;


class VehiculoControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use WithFaker;

    public function test_store_creates_new_vehiculo_and_historial()
    {
        // Create a mock request
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->andReturn([
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'patente' => 'ABCD23',
            'anio' => 2020,
            'precio' => 20000,
            'nombres' => 'John',
            'apellidos' => 'Doe',
            'correo' => 'john.doe@example.com',
        ]);

        // Create mock instances of Usuario and Vehiculo models
        $usuario = Mockery::mock(Usuario::class);
        $usuario->shouldReceive('updateOrCreate')
            ->with(
                ['correo' => 'john.doe@example.com'],
                ['nombres' => 'John', 'apellidos' => 'Doe']
            )
            ->andReturn((object)['id' => 1]);

        $vehiculo = Mockery::mock(Vehiculo::class);
        $vehiculo->shouldReceive('create')
            ->with([
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'patente' => 'ABCD23',
                'anio' => 2020,
                'precio' => 20000,
                'usuario_id' => 1,
            ])
            ->andReturn((object)['id' => 1, 'usuario_id' => 1]);

        $historialVehiculo = Mockery::mock(HistorialVehiculo::class);
        $historialVehiculo->shouldReceive('updateOrCreate')
            ->with(
                ['usuario_id' => 1, 'vehiculo_id' => 1],
                ['vigente' => 1]
            )
            ->andReturn(true);

        // Mock the redirect response
        $redirectResponse = Mockery::mock(RedirectResponse::class);
        $redirectResponse->shouldReceive('route')->with('vehiculos.index')->andReturnSelf();
        $redirectResponse->shouldReceive('with')->with('message', 'Vehículo creado correctamente')->andReturnSelf();

        // Replace the global helper with the mock
        $this->instance(RedirectResponse::class, $redirectResponse);

        // Inject mocks into the controller
        $controller = Mockery::mock(VehiculoController::class)->makePartial();
        $controller->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('redirect')->andReturn($redirectResponse);

        // Call the store method and assert the behavior
        $response = $controller->store($request);

        $this->assertSame($redirectResponse, $response);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
