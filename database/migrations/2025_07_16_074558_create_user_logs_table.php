<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('action');
            $table->text('description');
            $table->string('ip_address');
            $table->text('user_agent');
            $table->json('data')->nullable();
            $table->string('hash')->nullable(); // Add ->nullable() here
            $table->timestamps();

            $table->index(['user_id', 'action', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
};