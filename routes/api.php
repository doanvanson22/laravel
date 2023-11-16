<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\DocsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// this is the endpoint with prefix /api
// đây là điểm cuối có tiền tố /api
Route::post('/login', [UsersController::class, 'login']);
Route::post('/register',[UsersController::class, 'register']);

// modify this// sửa đổi cái này
// this group mean return user's data if authenticated successfully// nhóm này có nghĩa là trả về dữ liệu của người dùng nếu được xác thực thành công
Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user', [UsersController::class, 'index']);
    Route::post('/logout', [UsersController::class, 'logout']);
    Route::post('/book', [AppointmentsController::class, 'store']);
    Route::post('/reviews', [DocsController::class, 'store']);
    Route::get('/appointments', [AppointmentsController::class, 'index']); // retrieve appointments// truy xuất các cuộc hẹn
});

// as you can see at terminal, a generated token is well received// như bạn có thể thấy ở thiết bị đầu cuối, mã thông báo được tạo sẽ được đón nhận nồng nhiệt
// now, use this token to get user data// bây giờ, hãy sử dụng mã thông báo này để lấy dữ liệu người dùng
// first, let me show the result without token// trước tiên, hãy để tôi hiển thị kết quả mà không cần mã thông báo

// now pass the booking data into database
// bây giờ chuyển dữ liệu đặt phòng vào cơ sở dữ liệu
