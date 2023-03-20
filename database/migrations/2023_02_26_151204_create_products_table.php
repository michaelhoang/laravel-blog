<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $_ENV['mdebug'] = 1;
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['Enable', 'Disable', 'Yeah'])->default('Yeah');
            $table->unsignedTinyInteger('mode')->default(0);
            $table->timestamps();
        });
        $_ENV['mdebug'] = 0;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
