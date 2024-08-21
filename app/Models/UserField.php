<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserField extends Model
{
    protected $fillable = ['user_id', 'field_id'];
    use HasFactory;
}
