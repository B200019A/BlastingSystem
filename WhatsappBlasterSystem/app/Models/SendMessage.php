<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\Blaster;
use App\Models\Customer;

class SendMessage extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','message_id','blaster_id','customer_id','full_message','send_time'];

    public function messages()
    {
        return $this->hasOne(Message::class,'id','message_id');
    }

    public function blasters()
    {
        return $this->hasOne(Blaster::class,'id','blaster_id');
    }
    public function customers(){
        return $this->hasOne(Customer::class,'id','customer_id');

    }
}
