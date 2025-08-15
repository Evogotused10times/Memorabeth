<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_name',
        'address',
        'cellphone_no',
        'email',
        'facebook_messenger',
        'next_of_kin',
        'lots',
        'terms',
        'remarks',
        'purchaser_name',
        'agent_name',
        'date',
        'signature_agreement',
        'file_path',
        'status',
    ];

    protected $casts = [
        'lots' => 'array',
        'signature_agreement' => 'boolean',
        'date' => 'date',
    ];
}