<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('name', 40);
            $table->string('image', 255);
            $table->string('url', 255);
            $table->string('email', 255);
            $table->string('address', 255);
            $table->text('about');
            $table->text('tags')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->double('avg_rating', 28, 2)->default(0.00);
            $table->text('admin_feedback', 255)->nullable();
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
        Schema::dropIfExists('companies');
    }
}
