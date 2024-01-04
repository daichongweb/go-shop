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
            $table->string('nickname', 18)->default('')->nullable(false);
            $table->string('password', 64)->nullable(false)->default('');
            $table->integer('vip')->nullable()->default(0)->unsigned();
            $table->tinyInteger('status',)->default(0)->nullable(false);
            $table->string('remark', 40)->default('')->nullable(false);
            $table->bigInteger('channel_code')->nullable()->unsigned()->unique();
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
