<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->text('link')->nullable();
            $table->boolean('blank')->default(0);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('cookie_option')->default(1);
            $table->string('cookie_title', 191)->default('Cookie Consent');
            $table->text('cookie_body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('link');
            $table->dropColumn('blank');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('cookie_option');
            $table->dropColumn('cookie_title');
            $table->dropColumn('cookie_body');
        });
    }
}
