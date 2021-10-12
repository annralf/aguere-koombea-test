<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'dateOfBirth',
        'phone',
        'address',
        'creditCard',
        'franchise',
        'email',
        'file_id',
        'user_id'
    ];
}
