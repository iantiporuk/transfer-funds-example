<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->foreignId('sender_wallet_id')->constrained('wallets')->nullable()->onDelete('set null');
            $table->foreignId('destination_wallet_id')->constrained('wallets')->nullable()->onDelete('set null');
            $table->float('amount', 7, 2);
            $table->enum('status', ['pending', 'canceled', 'committed']);
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
        Schema::dropIfExists('transactions');
    }
}
