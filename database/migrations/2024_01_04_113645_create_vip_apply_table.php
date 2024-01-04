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
        Schema::create('vip_apply', function (Blueprint $table) {
            $table->id();
            $table->string('name', 24)->nullable(false)->default('');
            $table->string('mobile', 11)->default('')->nullable(false);
            $table->string('id_card', 24)->default('')->nullable(false);
            $table->tinyInteger('type')->default(1)->nullable(false)->comment("1运营中心，2经销商");
            $table->tinyInteger('status')->default(1)->nullable(false)->comment('0待审核，1通过，-1拒绝');
            $table->string('remark', 128)->default('')->nullable(false);
            $table->string('reject_message', 128)->default('')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vip_apply');
    }
};
