<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\MnActivity;
use App\Models\Models\MnLead;
use App\Models\Models\MnStore;
use App\Models\Models\MnUser;
use APP\Models\User;
use App\Helpers\LogActivity;
use Illuminate\Container\Attributes\Auth;


class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $store = new MnStore();
        $leads = new MnLead();
        $user2 = new MnUser();
        $aktif = new MnActivity();

        if ($user->role === 'admin') {
            if ($request->ajax()) {
                $data = $aktif->getAll();
                return response()->json(['data' => $data]);
            }
            // $data2 = $user2->getAll();
            // $data3 = $store->getAll();
            // $data4 = $leads->getAll();
            $data2 = $leads->Dropdown();
        } else {
            if ($request->ajax()) {
                $data = $aktif->getById2($user->id);
                return response()->json(['data' => $data]);
            }
            // $data2 = $user2->getIdUser($user->id);
            // $data3 = $store->gettoko($user->id);
            // $data4 = $leads->getTampil($user->id);
            $data2 = $leads->Dropdown();
        }
        return view('aktifitas.index', compact('data2'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'date',
            'lead_id',
            'type',
            'description',
            'created_at',
            'updated_at'
        ]);
        try {
            $newId = MnActivity::insertStore($data);

            logActivity::add('insert', 'leads', $newId, 'Menambahkan aktifitas: ' . $data['lead_id']);


            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function lihat($id)
    {
        $x = new MnActivity();
        $data2 = $x->lihatById($id);
        if (!$data2) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data2);
    }

        public function update(Request $request, $id)
    {
        $data = $request->validate([
            'jenis_aktivitas' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'updated_at' => 'required',
        ]);

        MnActivity::updateStore($id, $data);
        logActivity::add('update', 'Activity', $id, 'Update activiti: ' . $id);


        return response()->json(['success' => true]);
    }

        public function delete($id)
    {
        $store = MnActivity::getById($id);
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'Toko tidak ditemukan'], 404);
        }
        MnActivity::deleteStore($id);
        logActivity::add('delete', 'aktifitas', $id, 'Hapus Aktifitas: ' . $id);

        return response()->json(['success' => true]);
    }

}
