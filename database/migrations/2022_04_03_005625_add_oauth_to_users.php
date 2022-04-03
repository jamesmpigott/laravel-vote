<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('github_id');
            $table->dropColumn('github_token');
            $table->dropColumn('github_refresh_token');

            $table->string('oauth_id')->nullable();
            $table->string('oauth_token')->nullable();
            $table->string('oauth_refresh')->nullable();
            $table->string('avatar')->nullable();
            $table->string('oauth_source')->nullable();
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
            $table->dropColumn('oauth_id');
            $table->dropColumn('oauth_token');
            $table->dropColumn('oauth_refresh');
            $table->dropColumn('avatar');
            $table->dropColumn('oauth_source');

            $table->string('github_id')->nullable();
            $table->string('github_token')->nullable();
            $table->string('github_refresh_token')->nullable();
        });
    }
};
