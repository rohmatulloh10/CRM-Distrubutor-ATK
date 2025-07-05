<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MnActivity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'lead_id',
        'date',
        'type',
        'description'
    ];

    public $timestamps = true;

    public static function getAll()
    {
        return DB::select(
            "SELECT 
    activities.id,
    stores.name AS store_name,
    users.name AS sales_name,
    activities.type,
    activities.date,
    activities.description
FROM activities
JOIN leads ON activities.lead_id = leads.id
JOIN users ON leads.created_by = users.id
JOIN stores ON leads.store_id = stores.id
ORDER BY activities.date DESC; "
        );
    }

    public function getById2($id){

      return DB::select(
        "SELECT 
    activities.id, stores.created_by,
    stores.name AS store_name,
    users.name AS sales_name,
    activities.type,
    activities.date,
    activities.description
FROM activities
JOIN leads ON activities.lead_id = leads.id
JOIN users ON leads.created_by = users.id
JOIN stores ON leads.store_id = stores.id
WHERE  users.id = ?
ORDER BY activities.date DESC;", [$id]);  
    }

    public static function insertStore($data)
    {
        return DB::insert("
            INSERT INTO activities (lead_id, type, description, date, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?)", [
            $data['lead_id'],
            $data['type'],
            $data['description'],
            $data['date'],
            $data['created_at'],
            $data['updated_at']
        ]);
    }

    public static function lihatById($id)
    {
        return DB::select(
            "SELECT 
    stores.name AS nama_toko,
    stores.owner_name AS nama_pemilik,
    stores.phone AS no_hp,
    stores.address AS alamat,
    users.name AS nama_sales,
    activities.id,
    activities.type AS jenis_aktivitas,
    activities.date AS tanggal_aktivitas,
    activities.description AS deskripsi,
    activities.created_at AS dibuat_pada,
    activities.updated_at AS diperbarui_pada
FROM activities
JOIN leads ON activities.lead_id = leads.id
JOIN stores ON leads.store_id = stores.id
JOIN users ON leads.created_by = users.id
WHERE activities.id = ?",
            [$id]
        );
    }

    public static function updateStore($id, $data)
    {
        DB::table('activities')
            ->where('id', $id)
            ->update([
                'type' => $data['jenis_aktivitas'],
                'description' => $data['deskripsi'],
                'updated_at' => $data['updated_at'],
            ]);
    }

    public static function getById($id)
    {
        return DB::selectOne("select * from activities where id = ?", [$id]);
    }

    public static function deleteStore($id)
    {
        DB::table('activities')->where('id', $id)->delete();
    }

    public static function getType()
    {
        return DB::select("SELECT type FROM `activities` GROUP BY type;");
    }
}
