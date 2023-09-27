<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->nullable()->comment('公司名称');
            $table->string('tax_number')->default('')->nullable()->comment('税号');
            $table->string('business_img')->default('')->nullable()->comment('营业执照图片');
            $table->string('id_card_main_img')->default('')->nullable()->comment('身份证正面');
            $table->string('id_card_back_img')->default('')->nullable()->comment('身份证反面');
            $table->tinyInteger('status')->default('0')->nullable()->comment('0：待审核，1已审核，-1驳回，-2下线');
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
        Schema::dropIfExists('companys');
    }
}
