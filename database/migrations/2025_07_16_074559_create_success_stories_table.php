<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('success_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('finder_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->text('story');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['item_id', 'created_at']);
            $table->index('finder_id');
            $table->index('owner_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('success_stories');
    }
};