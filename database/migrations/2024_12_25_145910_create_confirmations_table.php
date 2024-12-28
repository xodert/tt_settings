<?php

use App\Enums\Confirmation\ConfirmationStatusEnum;
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
        Schema::create('confirmations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('confirmation_type_id')
                ->constrained('confirmation_types')
                ->cascadeOnDelete();

            $table->foreignId('source_id')
                ->constrained('sources')
                ->cascadeOnDelete();

            $table->enum('status', ConfirmationStatusEnum::toArray())
                ->default(ConfirmationStatusEnum::PENDING->value);

            $table->string('action');

            $table->json('action_data')->nullable();

            $table->string('message')->nullable();

            $table->string('code');

            $table->dateTime('expires_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirmations');
    }
};
