<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Blaster;
use App\Models\SendMessage;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','message','blaster_id','send_time','image'];

    public function blasters()
    {
        return $this->hasOne(Blaster::class,'id','blaster_id');
    }
    public function send_messages()
    {
        return $this->hasMany(SendMessage::class,'message_id','id');
    }
}


