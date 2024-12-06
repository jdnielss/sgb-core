<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityReport extends Model
{
    protected $fillable = [
        'affected_user_name',
        'executed_by',
        'executed_at',
        'facebook_link',
        'action_type',
        'notes',
        'attachment'
    ];
}
