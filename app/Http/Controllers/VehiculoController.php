<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Usuario;
use App\Models\HistorialVehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Imports\VehiculoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; 
use Exception; 
use Illuminate\Support\Facades\Auth; 
use App\Mail\CargaMasivaEmail;


class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $vehiculos = Vehiculo::query()->with('usuario')
        ->orderBy('created_at', 'DESC')
        ->filter($request->only('filter'))
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('Vehiculo/Index', [
        'vehiculos' => $vehiculos,
        'filters' => $request->all('filter'),
        'message' => session('message'),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Vehiculo/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:255',
            'modelo'  => 'required|string|max:255',
            'patente' => 'required|unique:vehiculos|string|max:6|min:6',
            'anio' => 'required|numeric|max:2100|min:1900',
            'precio' => 'numeric|min:0',

            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255'

        ]);

        $usuario = Usuario::updateOrCreate(
            ['correo' => $request->correo], 
            ['nombres' => $request->nombres,
            'apellidos' => $request->apellidos
            ]
        );


        $vehiculo = Vehiculo::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'patente' => $request->patente,
            'anio' => $request->anio,
            'precio' => $request->precio,
            'usuario_id' => $usuario->id
        ]);

        HistorialVehiculo::updateOrCreate(
            ['usuario_id' => $vehiculo->usuario_id ,
             'vehiculo_id' => $vehiculo->id 
        
            ], 
            ['vigente' => 1
            ]
        );

        return redirect()->route('vehiculos.index')->with('message', 'Vehículo creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiculo $vehiculo)
    {

        /* $historialvehiculo =   HistorialVehiculo::all()->orderBy('created_at', 'DESC')->get();
        dd( compact( 'historialvehiculo'  )); */
        return Inertia::render(
            'Vehiculo/Edit',
            [
                'vehiculo' => $vehiculo->load('usuario'),
                //'historialvehiculo' =>  Vehiculo::query()->with('historial')->orderBy('created_at', 'DESC')->get()
                'historialvehiculo' => HistorialVehiculo::query()->where('vehiculo_id' , $vehiculo->id )->onlyTrashed()->with('usuario')
                ->orderBy('created_at', 'DESC')
                ->paginate(100)
                ->withQueryString()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'patente' => 'required|string|max:6',
            'anio' => 'required|numeric|max:2100|min:1900',
            'precio' => 'numeric|min:0',

            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|string|max:255'
        ]);

        $vehiculo->update([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'patente' => $request->patente,
            'anio' => $request->anio,
            'precio' => $request->precio,
            'usuario_id' => Usuario::updateOrCreate(
                ['correo' => $request->correo], 
                ['nombres' => $request->nombres,
                'apellidos' => $request->apellidos
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

        return redirect()->route('vehiculos.index')->with('message', 'Vehículo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();
        return redirect()->route('vehiculos.index')->with('message', 'Vehículo eliminado');
    }


    public function massiveUpload( Request $request )
    {

        $request->validate([
            'file' => [
                'required',
                'file'
            ],
        ]);

        
        try {
            
            Excel::import(new VehiculoImport, $request->file('file'));

            $recipient = 'support@rebits.cl';
            $data = [
                
                'username' => Auth::user()->name,
                'resultado' => 'Se ha ejecutado correntamente la carga de registro de vehículos.',
                
            ];

            Mail::to($recipient)->send(new CargaMasivaEmail( $data['username'], $data['resultado']));

        } catch (Exception $e) {
            
            Log::debug($e->getMessage());
            $recipient = 'support@rebits.cl'; 
            $data = [
                
                'username' => Auth::user()->name,
                'resultado' => 'Hubo un error en la carga de registro de vehículos , por favor revise su archivo o intente nuevamente o comuniquese con soporte.',
                
            ];

            Mail::to($recipient)->send(new CargaMasivaEmail( $data['username'], $data['resultado']));
            
            // Either form a friendlier message to display to the user OR redirect them to a failure page
        }



        return redirect()->route('vehiculos.index')->with('message', 'Vehículos cargados masivamente');

       



    }
}
