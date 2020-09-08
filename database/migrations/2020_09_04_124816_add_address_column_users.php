<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressColumnUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         *   SQLSTATE[23000]: Integrity constraint violation: 19 FOREIGN KEY constraint failed (SQL: DROP TABLE users)
         */

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
}
