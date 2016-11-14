<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'options', function( Blueprint $table )  {
            $table->increments( 'id' );
            $table->string( 'key', 200 );
            $table->text( 'value' );
            $table->boolean( 'autoload' );
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
        Schema::drop( 'options' );
    }
}
