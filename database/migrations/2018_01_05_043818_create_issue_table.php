<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sequence')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('issues_comments', function(Blueprint $table) {
            $table->string('id', 36);
            $table->bigInteger('issue_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('name');
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
        Schema::dropIfExists('issues_comments');
        Schema::dropIfExists('issues');
    }
}
