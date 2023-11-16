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
        //create a database table for doctor//tạo bảng cơ sở dữ liệu cho bác sĩ
        //and this doctor table is refer to User table   // và bảng bác sĩ này được tham chiếu đến bảng Người dùng
        //when a new doctor registered, the doctor details will be created as well// khi một bác sĩ mới đăng ký, thông tin chi tiết về bác sĩ cũng sẽ được tạo
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doc_id')->unique();
            $table->string('category')->nullable();
            $table->unsignedInteger('patients')->nullable();
            $table->unsignedInteger('experience')->nullable();
            $table->longText('bio_data')->nullable();
            $table->string('status')->nullable();
            //this is state that this doc_id is refer to id on users table// đây là trạng thái rằng doc_id này được tham chiếu đến id trên bảng người dùng
            $table->foreign('doc_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    //maybe FK is not match with the primary key// có thể FK không khớp với khóa chính
    //after that, roll back and push again// sau đó, quay lại và đẩy lại
    //Bingo, all table are pushed succesfully//Bingo, tất cả các bảng được đẩy thành công
    //now, let's create data//bây giờ hãy tạo dữ liệu

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
