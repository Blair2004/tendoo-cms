<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \DB as DB;

class CreateUsersMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'users_meta', function(Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'user_id' );
            $table->string( 'key', 200 );
            $table->text( 'value' );
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
        Schema::drop( 'users_meta' );
    }
}
