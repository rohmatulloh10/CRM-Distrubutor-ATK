<?php

namespace App\Http\Controllers;

use App\Models\Models\MnStore;
use App\Models\Models\MnUser;
use App\Models\Models\MnLead;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;



class StoreController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $model = new MnStore();
        $x = new MnUser();

        if ($user->role === 'admin') {
            if ($request->ajax()) {
                $data = $model->getAll();
                return response()->json(['data' => $data]);
            }
            $data2 = $x->getAll();
        } else {
            if ($request->ajax()) {
                $data = $model->getCreatedBy($user->id);
                return response()->json(['data' => $data]);
            }
            $data2 = $x->getIdUser($user->id);
        }
        return view('toko.index', compact('data2'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'owner_name',
            'phone',
            'created_by',
            'address',
            'created_at',
            'updated_at'
        ]);
        try {
            $newId = MnStore::insertStore($data);

            logActivity::add('insert', 'store', $newId, 'Menambahkan toko: ' . $data['name']);


            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $data2 = MnStore::getById($id);
        return response()->json($data2);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'namej' => 'required|string|max:255',
            'owner_namej' => 'required|string|max:255',
            'phonej' => 'required|string|max:20',
            'addressj' => 'required|string|max:255',
            'created_byj' => 'required|integer',
            'updated_at' => 'required',
        ]);

        MnStore::updateStore($id, $validated);
        logActivity::add('update', 'store', $id, 'Update toko: ' . $validated['namej']);


        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $store = MnStore::getById($id);
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'Toko tidak ditemukan'], 404);
        }
        MnStore::deleteStore($id);
        logActivity::add('delete', 'store', $id, 'Hapus toko: ' . $store->name);

        return response()->json(['success' => true]);
    }
}
