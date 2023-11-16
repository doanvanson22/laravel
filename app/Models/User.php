<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\FuncCall;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public function getJWTIdentifier(){
        return $this ->getKey();
    }

    public function getJWTCustomClaims(){
        return[];   
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',//add this "type", to differential user and doctor// thêm "loại" này vào người dùng và bác sĩ khác nhau
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //this is to state that users has one relationship with doctor// điều này thể hiện rằng người dùng có một mối quan hệ với bác sĩ
    ///each user id refer yo one doctor id///mỗi id người dùng giới thiệu một id bác sĩ
    public function doctor(){
        return $this->hasOne(Doctor::class, 'doc_id');
    }

    //same go to user datails// đi tới dữ liệu người dùng cũng vậy
    public function user_details(){
        return $this->hasOne(User_details::class, 'user_id');
    }

    //a user may has many appointments// một người dùng có thể có nhiều cuộc hẹn
    public function appointments(){
        return$this->hashMany(Appointments::class, 'user_id');
    }

    public function reviews(){
        return$this->hashMany(Reviews::class, 'user_id');
    }
}
