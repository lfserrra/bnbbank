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
        Schema::create('transaction_status', function (Blueprint $table) {
            $table->id();
            $table->string('description', 10);
            $table->timestamps();
        });

        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('description', 10);
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('transaction_status');
            $table->foreignId('type_id')->constrained('transaction_types');
            $table->foreignId('customer_id')->constrained('users');
            $table->decimal('amount', 15, 2);
            $table->string('description', 50);

            $table->timestamps();
        });

        Schema::create('transaction_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions');
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
        Schema::dropIfExists('transaction_checks');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('transaction_types');
        Schema::dropIfExists('transaction_status');
    }
};
