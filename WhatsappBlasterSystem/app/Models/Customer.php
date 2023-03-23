<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Blaster;
class Customer extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','blaster_id','attribute1','attribute2','attribute3','attribute4','attribute5','attribute6','attribute7'];

    public function blasters()
    {
        return $this->belongsTo(Blaster::class,'id','blaster_id');
    }


}
