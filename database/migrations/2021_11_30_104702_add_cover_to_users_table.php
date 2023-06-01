<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoverToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cover', 191)->default('defaultcover.png');
            $table->boolean('homepage')->default(0);
            $table->boolean('status')->default(0);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('site_logo_light', 191)->default('logo-dark.png');
            $table->string('theme', 41)->default('dark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cover');
            $table->dropColumn('homepage');
            $table->dropColumn('status');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('site_logo_light');
            $table->dropColumn('theme');
        });
    }
}
