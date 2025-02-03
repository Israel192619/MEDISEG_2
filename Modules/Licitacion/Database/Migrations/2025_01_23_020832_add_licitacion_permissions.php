<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create(['name' => 'licitacion.create']);
        Permission::create(['name' => 'licitacion.update']);
        Permission::create(['name' => 'licitacion.view']);
        Permission::create(['name' => 'licitacion.delete']);

        //Permission::create(['name' => 'licitacion_status.update']);
        //Permission::create(['name' => 'licitacion_status.access']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
