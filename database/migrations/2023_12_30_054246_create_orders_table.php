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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable()->index()->comment('所属人id');
            $table->integer('pay_member_id')->nullable()->index()->comment('购买人id');
            $table->integer('reference_member_id')->nullable()->index()->comment('推荐人id');
            $table->integer('product_id')->nullable()->index();
            $table->integer('pay_price')->nullable()->default(1)->unsigned()->comment('单位分');
            $table->integer('num')->nullable()->default(1)->unsigned();
            $table->tinyInteger('status')->nullable()->default(0)->comment('0待支付，1完成，-1取消');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
