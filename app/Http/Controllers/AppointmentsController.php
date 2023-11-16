<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // retrieve all appoinments from the user// lấy tất cả các cuộc hẹn từ người dùng
        $appointment = Appointments::where('user_id', Auth::user()->id)->get();
        $doctor = User::where('type', 'doctor')->get();

        //sorting appointment and doctor details//  xếpsắp cuộc hẹn và chi tiết bác sĩ
        //and get all related appointment// và nhận tất cả các cuộc hẹn liên quan
        foreach($appointment as $data){
            foreach($doctor as $info){
                $details = $info->doctor;
                if($data['doc_id'] == $info['id']){
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                    $data['category'] = $details['category'];
                }
            }
        }

        return $appointment;
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
        //this controller is to store booking details post from mobile app// bộ điều khiển này dùng để lưu trữ thông tin đặt chỗ từ ứng dụng di động
        $appointment = new Appointments();
        $appointment->user_id = Auth::user()->id;
        $appointment->doc_id = $request->get('doctor_id');
        $appointment->date = $request->get('date');
        $appointment->day = $request->get('day');
        $appointment->time = $request->get('time');
        $appointment->status = 'upcoming'; //new appointment will saved as 'upcoming' by default//cuộc hẹn mới sẽ được lưu là 'sắp tới' theo mặc định
        $appointment->save();

        //if successfully, return 200// nếu thành công trả về 200
        return response()->json([
            'success'=>'New Appointments has been made successfully!',
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
