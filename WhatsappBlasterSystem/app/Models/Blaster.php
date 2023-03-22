<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\Message;
class Blaster extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','name'];

    protected $table = 'blasters';

    public function customers()
    {
        return $this->hasMany(Customer::class,'blasting_id','id');
    }

    public function messages()
    {
        return $this->hasOne(Message::class,'blasting_id','id');
    }
}
