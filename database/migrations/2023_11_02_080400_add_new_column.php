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
        Schema::table('user_details', function (Blueprint $table) {
            //let add new column after bio data// hãy thêm cột mới sau dữ liệu sinh học
            // the data type is json, so that it can save list file// kiểu dữ liệu là json nên có thể lưu file danh sách
            $table->json('fav')->nullable()->after('bio_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            //
        });
    }
};
