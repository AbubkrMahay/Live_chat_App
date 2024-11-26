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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // ID of the user sending the message
            $table->foreignId('receiver_id')->nullable()->constrained('users')->cascadeOnDelete(); // ID of the user receiving the message
            $table->foreignId('group_id')->nullable()->constrained()->cascadeOnDelete(); // For group messages
            $table->text('content'); // Message content
            $table->timestamps(); // Created at and updated at

            // Foreign key constraints
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
