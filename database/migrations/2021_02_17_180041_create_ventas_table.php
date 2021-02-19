<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name_venta');
            $table->string('stock');
            $table->string('precio');
            $table->string('user_id');
            $table->foreignId('cards_id')->nullable()->constrained();

        });
    }

    public function down()
    {

        $table->dropForeign(['cards_id']);
        $table->dropColumn('cards_id');

        Schema::dropIfExists('ventas');
    }
}
