<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 255)->nullable();
            $table->string('date', 255)->nullable();
            $table->tinyInteger('temperature')->default(0);
            $table->string('sample_type', 255)->nullable();
            $table->bigInteger('order_number')->default(0);
            $table->unsignedInteger('country_id')->default(0);
            $table->string('package', 255)->nullable();
            $table->string('weight', 255)->nullable();
            $table->date('production_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('release_date')->nullable();
            $table->string('customer', 255)->nullable();
            $table->text('protocol')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
