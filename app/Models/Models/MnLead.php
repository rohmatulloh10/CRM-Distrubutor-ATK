<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnLead extends Model
{
    protected $table = 'leads';

    protected $fillable = [
        'store_id',
        'created_by',
        'status',
        'notes',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function getAll()
    {
        return DB::select(
            "SELECT 
                leads.id,
                stores.name AS store_name,
                stores.owner_name,
                stores.phone,
                stores.address,
                leads.status,
                leads.notes,
                users.name AS created_by,
                users.id AS id_sales,
                leads.created_at,
                leads.updated_at
            FROM leads
            JOIN stores ON leads.store_id = stores.id
            JOIN users ON leads.created_by = users.id
            ORDER BY leads.created_at DESC;"
        );
    }
    public function getTampil($id)
    {
        return DB::select(
            "SELECT A.*, B.name, c.name, c.owner_name,  c.address, c.phone
            FROM leads AS a 
            INNER JOIN users AS B 
            ON A.created_by = B.id
            INNER JOIN stores AS C 
            ON a.store_id = c.id
            WHERE A.id = ? ",
            [$id]
        );
    }
    public function getCreatedBy($id)
    {
        return DB::select(
            "SELECT 
                leads.id,
                stores.name AS store_name,
                stores.owner_name,
                stores.phone,
                stores.address,
                leads.status,
                leads.notes,
                users.name AS created_by,
                users.id AS id_sales,
                leads.created_at,
                leads.updated_at
            FROM leads
            JOIN stores ON leads.store_id = stores.id
            JOIN users ON leads.created_by = users.id
            WHERE users.id = ?",
            [$id]
        );
    }

    public static function insertStore($data)
    {
        return DB::insert("
            INSERT INTO leads (store_id, created_by, status, notes, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?)", [
            $data['store_id'],
            $data['created_by'],
            $data['status'],
            $data['notes'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public static function updateStore($id, $data)
    {
        DB::table('leads')
            ->where('id', $id)
            ->update([
                'status' => $data['status'],
                'notes' => $data['notes'],
                'updated_at' => $data['updated_at'],
            ]);
    }

    public static function deleteProspek($id)
    {
        DB::table('leads')->where('id', $id)->delete();
    }

    public static function Dropdown() {
        return DB::select(
            "SELECT 
    leads.id,
    CONCAT(stores.name, ' - ', users.name, ' - ', leads.status) AS label
FROM leads
JOIN stores ON leads.store_id = stores.id
JOIN users ON leads.created_by = users.id;"
        );
    }

    public static function getStatus(){
        return DB::select("SELECT status FROM `leads` GROUP BY status;");
    }
}
