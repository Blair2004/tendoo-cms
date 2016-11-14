<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionsRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'roles_permissions_relation', function( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'role_id' );
            $table->integer( 'permission_id' );
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
        Schema::drop( 'roles_permissions_relation' );
    }
}
