<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnLogActivity extends Model
{
    protected $table = 'log_activity';

    protected $fillable = [
        'user_id', 'action', 'module', 'reference_id', 'description', 'ip_address', 'user_agent'
    ];

    public $timestamps = true;
}