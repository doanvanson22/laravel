<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    //there are fillable input// có đầu vào có thể điền
    protected $fillable = [
        'doc_id',
        'category',
        'patients',
        'experience',
        'bio_data',
        'satatus',
    ];

    //state this is belong to user table// nêu rõ cái này thuộc về bảng người dùng
    public function user(){
        return $this->belongsTo(User::class);
    }
}
