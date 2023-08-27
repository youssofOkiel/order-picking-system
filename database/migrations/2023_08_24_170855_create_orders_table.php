<?php

use App\Enums\OrderStatus;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(OrderStatus::Pending);
            $table->integer('priority')->nullable();
            $table->foreignId('owner_id')->constrained('users');
            $table->foreignIdFor(TimeSlot::class)->nullable()->constrained();

            $table->index(['owner_id', 'time_slot_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
