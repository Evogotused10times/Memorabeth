<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['applicant_name', 'applicant_email', 'applicant_phone', 'deceased_name', 'file_path', 'status'];
}