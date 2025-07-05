<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\MnStore;
use App\Models\Models\MnLead;
use App\Models\Models\MnUser;
use App\Helpers\LogActivity;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $model = new MnStore();
        $led = new MnLead();
        $x = new MnUser();

        if ($user->role === 'admin') {
            if ($request->ajax()) {
                $data = $led->getAll();
                return response()->json(['data' => $data]);
            }
            $data2 = $x->getAll();
            $data3 = $model->getAll();
        } else {
            if ($request->ajax()) {
                $data = $led->getCreatedBy($user->id);
                return response()->json(['data' => $data]);
            }
            $data2 = $x->getIdUser($user->id);
            $data3 = $model->gettoko($user->id);
        }
        return view('prospek.index', compact('data2', 'data3'));
    }

    public function tampil($id)
    {
        $x = new MnLead();
        $data2 = $x->getTampil($id);
        if (!$data2) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data2);
    }

    public function pemilik($id)
    {
        $st =  new  MnStore();
        $data = $st->getById($id);
        if (!$data) {
            return response()->json(['message' => 'Data Pemilik Tidak Ada']);
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'store_id',
            'created_by',
            'status',
            'notes',
            'created_at',
            'updated_at'
        ]);
        try {
            $newId = MnLead::insertStore($data);
            logActivity::add('insert', 'leads', $newId, 'Menambahkan prospek: ' . $data['store_id']);

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            'updated_at' => 'required',
        ]);

        MnLead::updateStore($id, $validated);
        logActivity::add('update', 'leads', $id, 'update Prospek: ' . $validated['status']);


        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        MnLead::deleteProspek($id);
        logActivity::add('delete', 'leads', $id, 'Hapus prospek: ' . $id);
        return response()->json(['success' => true]);
    }
}
