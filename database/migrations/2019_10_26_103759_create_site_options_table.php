<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('logo_url', 100);
            $table->string('copyright', 200);
            $table->char('github_url',100);
            $table->char('linkedin_url',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_options');
    }
}
