<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',            // Nama Kontraktor
        'address',         // Alamat
        'email',           // Email
        'phone',           // Phone
        'pic_name',        // PIC (Personal In Charge)
    ];
}
