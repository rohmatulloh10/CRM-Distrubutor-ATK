<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnMenu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'name', 'icon', 'route'
    ];

    public $timestamps = false;
}
