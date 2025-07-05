<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnUser extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = true;

    public static function getAllUsers()
    {
        return DB::table('users')
            ->select('id', 'name', 'email', 'role')
            ->orderBy('name')
            ->get();
    }
    
        public function getAll(){
            return DB::select('Select * FROM users');
        }
    
        public function getIdUser($id){
            return DB::select('Select * FROM users WHERE id = ?', [$id]);
        }
}
