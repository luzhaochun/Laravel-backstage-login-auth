<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClerkTalbeForNickname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clerk', function (Blueprint $table) {
            $table->string('nickname',30)->nullable();
            $table->string('avatar',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clerk', function (Blueprint $table) {
            $table->dropColumn(['nickname','avatar']);
        });
    }
}
