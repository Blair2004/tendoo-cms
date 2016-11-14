<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'roles_permissions', function( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'namespace', 200 );
            $table->string( 'name', 200 );
            $table->text( 'description', 200 );
            $table->dateTime( 'created_at' );
            $table->dateTime( 'updated_at' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'roles_permissions' );
    }
}
