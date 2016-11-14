<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'users_roles', function( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'role_name', 200 )->unique();
            $table->text( 'role_description' );
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
        Schema::drop( 'users_roles' );
    }
}
