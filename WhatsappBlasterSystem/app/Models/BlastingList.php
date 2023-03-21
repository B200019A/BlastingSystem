<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CustomerList;
use App\Models\MessageList;

class BlastingList extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','name'];

    protected $table = 'blasting_lists';

    public function customerlists()
    {
        return $this->hasMany(CustomerList::class,'blasting_id','id');
    }

    public function messageLists()
    {
        return $this->belongsTo(MessageList::class,'blasting_id','id');
    }
}
