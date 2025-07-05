<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnStore extends Model
{
    protected $table = 'stores';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'owner_name',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function getAll()
    {
        return DB::select(
            "SELECT A.* , B.id AS id_usr, B.name AS nm_sales
            FROM stores AS A 
            INNER JOIN users AS B
            ON A.created_by = B.id"
        );
    }

    public function getCreatedBy($id)
    {
        return DB::select(
            "SELECT A.* , B.id AS id_usr, B.name AS nm_sales
            FROM stores AS A 
            INNER JOIN users AS B
            ON A.created_by = B.id
            WHERE A.created_by = ?",
            [$id]
        );
    }
    public function gettoko($id)
    {
        return DB::select(
            "SELECT * FROM stores WHERE created_by = ?", [$id]
        );
    }

    // public static function insert($data)
    // {
    //     return DB::insert(
    //         "INSERT INTO stores (nama, owner_name, address, phone, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)",
    //         [
    //             $data['name'],
    //             $data['owner_name'],
    //             $data['phone'],
    //             $data['address'],
    //             $data['created_by'],
    //             $data['created_at'],
    //             $data['updated_at']
    //         ]
    //     );
    // }

    public static function insertStore($data)
    {
        return DB::insert("
            INSERT INTO stores (name, owner_name, phone, created_by, address, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $data['name'],
            $data['owner_name'],
            $data['phone'],
            $data['created_by'],
            $data['address'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }


    public static function getById($id)
    {
        return DB::selectOne("select * from stores where id = ?", [$id]);
    }

    public static function updateStore($id, $data)
    {
        DB::table('stores')
            ->where('id', $id)
            ->update([
                'name' => $data['namej'],
                'owner_name' => $data['owner_namej'],
                'phone' => $data['phonej'],
                'address' => $data['addressj'],
                'created_by' => $data['created_byj'],
                'updated_at' => $data['updated_at'],
            ]);
    }

    public static function deleteStore($id)
    {
        DB::table('stores')->where('id', $id)->delete();
    }
}
