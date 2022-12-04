<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('address')->default('abc123@gmail.com');
            $table->string('gender')->default('Male');
            $table->string('designation')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('age')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('12345678');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
