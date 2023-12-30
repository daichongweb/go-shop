<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 11)->unique();
            $table->string('nickname', 18)->default('')->nullable();
            $table->string('password', 64)->nullable()->default('');
            $table->integer('vip')->nullable()->default(0)->unsigned();
            $table->tinyInteger('status',)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
