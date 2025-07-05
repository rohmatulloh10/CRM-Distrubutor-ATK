<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class LogActivity
{
    public static function add($action, $module, $referenceId = null, $description = null)
    {
        DB::table('log_activity')->insert([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'module'      => $module,
            'reference_id'=> $referenceId,
            'description' => $description,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::header('User-Agent'),
            'created_at'  => now(),
            'updated_at'  => now()
        ]);
    }
}
