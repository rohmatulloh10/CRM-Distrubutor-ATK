<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnAccess extends Model
{
    protected $table = 'accesses';

    protected $fillable = [
        'role', 'menu_id', 'can_view', 'can_create', 'can_update', 'can_delete'
    ];

    public $timestamps = false;
}
