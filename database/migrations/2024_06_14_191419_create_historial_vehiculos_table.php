<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Usuario;
use App\Models\Vehiculo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Usuario::class);
            $table->foreignIdFor(Vehiculo::class);
            $table->boolean('vigente')->default(1);
            $table->timestamps();
            $table->softDeletes();
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_vehiculos');
    }
};
