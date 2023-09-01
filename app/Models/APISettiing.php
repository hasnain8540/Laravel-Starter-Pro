<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class APISettiing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
