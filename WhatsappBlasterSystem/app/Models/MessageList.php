<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlastingList;

class MessageList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','message','blastinglist_id','send_time'];

    public function blastingLists()
    {
        return $this->hasOne(BlastingList::class,'id','blasting_id');
    }

}
