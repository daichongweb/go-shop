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
        Schema::create('sms_code', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 11)->default('')->nullable(false);
            $table->string('code', 16)->default('')->nullable(false);
            $table->tinyInteger('status')->default(0)->nullable(false)->comment('0未使用，1已使用，-1已过期');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_code');
    }
};
