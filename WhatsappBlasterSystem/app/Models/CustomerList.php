<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerList extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','blasting_id','attribute1','attribute2','attribute3','attribute4','attribute5','attribute6',,'attribute7'];
}
