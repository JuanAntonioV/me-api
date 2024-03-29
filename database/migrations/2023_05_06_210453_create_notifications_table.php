<?php

use App\Entities\NotificationEntities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('sales_id')->nullable();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('type', 10)->nullable()->default(NotificationEntities::TYPE_GENERAL);
            $table->string('status', 10)->default(NotificationEntities::STATUS_DELIVERED);
            $table->boolean('is_read')->default(NotificationEntities::STATUS_UNREAD);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
