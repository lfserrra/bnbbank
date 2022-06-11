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
        Schema::create('balance_status', function (Blueprint $table) {
            $table->id();
            $table->string('description', 10);
            $table->timestamps();
        });

        Schema::create('balance_types', function (Blueprint $table) {
            $table->id();
            $table->string('description', 10);
            $table->timestamps();
        });

        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('balance_status');
            $table->foreignId('type_id')->constrained('balance_types');
            $table->foreignId('customer_id')->constrained('users');
            $table->decimal('amount', 15, 2);
            $table->string('description', 50);

            $table->timestamps();
        });

        Schema::create('balance_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balance_id')->constrained('balances');
            $table->text('url');
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
        Schema::dropIfExists('balance_checks');
        Schema::dropIfExists('balances');
        Schema::dropIfExists('balance_types');
        Schema::dropIfExists('balance_status');
    }
};
