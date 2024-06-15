<?php

namespace Tests\Unit;

use App\Http\Controllers\VehiculoController;
use App\Models\Usuario;
use App\Models\Vehiculo;
use App\Models\HistorialVehiculo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class VehiculoControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_store_creates_new_vehiculo_and_historial()
    {
        // Mock Request with input data
        $requestData = [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'patente' => 'ABC123',
            'anio' => 2020,
            'precio' => 20000,
            'nombres' => 'John',
            'apellidos' => 'Doe',
            'correo' => 'john.doe@example.com',
        ];

        // Mock Usuario model
        $usuarioMock = Mockery::mock(Usuario::class);
        $usuarioMock->shouldReceive('updateOrCreate')
            ->once()
            ->with(['correo' => $requestData['correo']], ['nombres' => 'John', 'apellidos' => 'Doe'])
            ->andReturn((object)['id' => 1]);

        // Mock Vehiculo model
        $vehiculoMock = Mockery::mock(Vehiculo::class);
        $vehiculoMock->shouldReceive('create')
            ->once()
            ->with(array_merge($requestData, ['usuario_id' => 1]))
            ->andReturn((object)['id' => 1, 'usuario_id' => 1]);

        // Mock HistorialVehiculo model
        $historialVehiculoMock = Mockery::mock(HistorialVehiculo::class);
        $historialVehiculoMock->shouldReceive('updateOrCreate')
            ->once()
            ->with(['usuario_id' => 1, 'vehiculo_id' => 1], ['vigente' => 1])
            ->andReturn(true);

        // Instantiate the controller manually with mocked dependencies
        $controller = new VehiculoController($usuarioMock, $vehiculoMock, $historialVehiculoMock);

        // Create a mock Request object with input data
        $request = new Request([], $requestData);

        // Call the store method and assert the behavior
        $response = $controller->store($request);

        // Assertions
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('vehiculos.index'), $response->headers->get('Location'));
        $this->assertEquals('Vehículo creado correctamente', $response->getSession()->get('message'));
    }
}