<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // SERIAL primary key
            $table->string('username', 100);
            $table->string('email', 255)->unique();
            $table->text('password_hash');
            $table->timestamps(); // includes created_at and updated_at
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
