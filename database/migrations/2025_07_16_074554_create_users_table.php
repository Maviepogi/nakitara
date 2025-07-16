<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->integer('failed_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};