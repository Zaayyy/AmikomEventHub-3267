<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerRegistration extends Model
{
    protected $fillable = [

        'organization_name',

        'organization_type',

        'logo',

        'email',

        'phone',

        'address',

        'description',

        'proposal',

        'status',

        'admin_note'

    ];
}