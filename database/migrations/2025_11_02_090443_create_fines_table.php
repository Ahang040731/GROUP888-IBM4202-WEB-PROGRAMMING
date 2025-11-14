<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fines', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('borrowing_id')->nullable()
            ->constrained('borrow_history')->nullOnDelete(); // tie to a loan if applicable

        $table->enum('reason', ['late', 'lost', 'damage', 'activate', 'manual', 'other'])->default('late');
        $table->decimal('amount', 8, 2);

        $table->enum('status', ['unpaid', 'pending', 'paid', 'waived', 'reversed'])->default('unpaid');

        $table->enum('method', ['credit', 'card', 'online_banking', 'tng', 'cash'])->nullable();
        $table->string('transaction_ref')->nullable(); // gateway ref / receipt no.
        $table->timestamp('paid_at')->nullable();

        $table->foreignId('handled_by')->nullable()->constrained('admins')->nullOnDelete(); // if admins are also in users; else separate admins table
        //$table->json('meta')->nullable(); // keep raw gateway payloads or notes

        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
