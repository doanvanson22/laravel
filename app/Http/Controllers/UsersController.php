<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\Doctor;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = array(); //this will return a set of user and and doctor data// điều này sẽ trả về một tập hợp dữ liệu người dùng và bác sĩ
        $user = Auth::user();
        $doctor = User::where('type', 'doctor')->get();
        //$details = $user->user_details;
        $doctorData = Doctor::all();

        //this is the data format without leading
        $date = now()->format('j/n/Y');
        // change date format to suit the format in database
        //make this appointment filter only status is"umcoming"
        $appointment = Appointments::where('status', 'upcoming')->where('date', $date)->first();

        // collect user data and all doctor details//thu thập dữ liệu người dùng và tất cả thông tin chi tiết về bác sĩ
        foreach($doctorData as $data){
            // sorting doctor name and doctor details// sắp xếp tên bác sĩ và chi tiết bác sĩ
            foreach($doctor as $info){
                if($data['doc_id'] == $info['id']){
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                    if(isset($appointment)&& $appointment['doc_id'] == $info['id']){
                        $data['appointments'] = $appointment;
                    }
                }
            }
        }
        
        $user['doctor'] = $doctorData;
        //$user['details'] = $details; // return user datails here together with doctor list// trả về dữ liệu người dùng ở đây cùng với danh sách bác sĩ

        return $user;//return all data
    }

    /**
     * login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //create a controller to handle incoming request//tạo bộ điều khiển để xử lý yêu cầu đến
        // and return some data// và trả về một số dữ liệu

        // validate incoming inputs// xác thực đầu vào đến
        $request->validate([
            'email' =>'required|email',
            'password'=>'required',
        ]);
        // check matching user// kiểm tra người dùng phù hợp
        $user = User::where('email', $request->email)->first();
        // check password// kiểm tra mật khẩu
        if(!$user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email'=>['The provided credentials are incorrect'],
            ]);
        }
        // then return generated token// sau đó trả về mã thông báo đã tạo
        return $user->createToken($request->email)->plainTextToken;
        // $validator = Validator::make($request->all(),[
        //     'email' =>'required|email',
        //     'password'=>'required',
        // ]);
        // if($validator->fails()){
        //     return response()->json($validator->errors(), 442);
        // }
        // if(! $token = auth()->attempt($validator->validated())){
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        // return $this->CreateNewToken($token);
        
    }

        /**
     * register.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //create a controller to handle incoming request//tạo bộ điều khiển để xử lý yêu cầu đến
        // and return some data// và trả về một số dữ liệu

        // validate incoming inputs// xác thực đầu vào đến
        $request->validate([
            'name' => 'required|string',
            'email' =>'required|email',
            'password'=>'required',
        ]); 
        
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'type' =>'user',
            'password' =>Hash::make($request->password),
        ]);

        $userInfo = UserDetails::create([
            'user_id' => $user->id,
            'status'=>'active',
        ]);

        return $user;
    }

    /**
     * logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'success'=>'Logout successfully!',
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
