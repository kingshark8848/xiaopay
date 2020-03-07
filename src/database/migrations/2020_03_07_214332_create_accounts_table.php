<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string("id", 30)->primary();
            $table->string('user_id',30);

            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('address');
            $table->string('gender',10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->float('balance', 8, 2)->default(0)->comment("unit: AUD");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
