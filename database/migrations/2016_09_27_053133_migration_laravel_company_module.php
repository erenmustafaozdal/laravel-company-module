<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationLaravelCompanyModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->increments('id');

                $table->string('title');
                $table->string('slug');
                $table->longText('company_profile')->nullable();
                $table->longText('mission')->nullable();
                $table->longText('vision')->nullable();

                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->integer('read')->unsigned()->default(0);

                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->unique('slug');
            });
        }

        if ( ! Schema::hasTable('company_photos')) {
            Schema::create('company_photos', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('company_id')->unsigned();
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

                $table->string('photo');

                $table->engine = 'InnoDB';
            });
        }

        if ( ! Schema::hasTable('company_values')) {
            Schema::create('company_values', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('company_id')->unsigned();
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

                $table->string('title');
                $table->longText('value');

                $table->engine = 'InnoDB';
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company_values');
        Schema::drop('company_photos');
        Schema::drop('companies');
    }
}
