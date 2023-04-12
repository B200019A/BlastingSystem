<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Blaster;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','message','blaster_id','send_time','image'];

    public function blasters()
    {
        return $this->hasOne(Blaster::class,'id','blaster_id');
    }
}

// cronjob breast_messages
//     create  breasting_id, customer_id, message, status, created_at, updated_at, success_at, failed_at

//     foreach($messages as $message){
//         $oriText = $message->message;

//         foreach($message->breast->customers as $costomer){
//             $oriText = str_replace('[attribute1]', $costomer->attribute1, $oriText);
//             $oriText = str_replace('[attribute2]', $costomer->attribute2, $oriText);
//             $oriText = str_replace('[attribute3]', $costomer->attribute3, $oriText);
//             $oriText = str_replace('[attribute4]', $costomer->attribute4, $oriText);
//             $oriText = str_replace('[attribute5]', $costomer->attribute5, $oriText);
//             $oriText = str_replace('[attribute6]', $costomer->attribute6, $oriText);
//             $oriText = str_replace('[attribute7]', $costomer->attribute7, $oriText);

//             $breasting->breast_messages()->create([
//                 'costomer_id' => $costomer->id,
//                 'message' => $oriText
//             ]);
//         }
//     }

