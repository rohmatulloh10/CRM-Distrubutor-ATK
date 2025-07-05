<?php

namespace App\Http\Controllers;

use App\Models\Models\MnActivity;
use App\Models\Models\MnLead;
use Illuminate\Http\Request;
use App\Models\Models\MnStore;
use App\Models\Models\MnUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{
    // public function toko(Request $request)
    // {
    //     $x = new MnUser();

    //     if ($request->ajax()) {
    //         $salesId   = $request->input('sales_id');
    //         $startDate = $request->input('start_date');
    //         $endDate   = $request->input('end_date');

    //         $query = "
    //         SELECT A.*, B.id AS id_usr, B.name AS nm_sales
    //         FROM stores AS A
    //         INNER JOIN users AS B ON A.created_by = B.id
    //         WHERE 1 = 1
    //     ";

    //         $params = [];

    //         // if (!empty($salesId)) {
    //         //     $query .= " AND A.created_by = ?";
    //         //     $params[] = $salesId;
    //         // }
    //         if (is_numeric($salesId)) {
    //             $query .= " AND A.created_by = ?";
    //             $params[] = $salesId;
    //         }

    //         if (!empty($startDate)) {
    //             $query .= " AND DATE(A.created_at) >= ?";
    //             $params[] = $startDate;
    //         }

    //         if (!empty($endDate)) {
    //             $query .= " AND DATE(A.created_at) <= ?";
    //             $params[] = $endDate;
    //         }

    //         $data = DB::select($query, $params);

    //         return response()->json(['data' => $data]);
    //     }
    //     $data2 = $x->getAll();

    //     return view('laporan.toko', compact('data2'));
    // }

    public function toko(Request $request)
    {
        $x = new MnUser();

        if ($request->ajax()) {
            $salesId   = $request->input('sales_id');
            $startDate = $request->input('start_date');
            $endDate   = $request->input('end_date');

            $query = DB::table('stores as A')
                ->join('users as B', 'A.created_by', '=', 'B.id')
                ->select('A.*', 'B.id as id_usr', 'B.name as nm_sales');

            if (is_numeric($salesId)) {
                $query->where('A.created_by', $salesId);
            }

            if (!empty($startDate)) {
                $query->whereDate('A.created_at', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->whereDate('A.created_at', '<=', $endDate);
            }

            $data = $query->get();

            return response()->json(['data' => $data]);
        }

        $data2 = $x->getAll();

        return view('laporan.toko', compact('data2'));
    }

    public function tokoexportPDF(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        $sales_id = $request->sales_id;

        $query = DB::table('stores')
            ->select(
                'stores.name as store_name',
                'stores.owner_name',
                'stores.phone',
                'stores.address',
                'stores.created_at',
                'users.name as sales_name'
            )
            ->leftJoin('users', 'stores.created_by', '=', 'users.id')
            ->orderBy('stores.created_at', 'desc');

        // Filter tanggal (jika start dan end ada)
        if ($start && $end) {
            $query->whereBetween('stores.created_at', [
                Carbon::parse($start)->startOfDay(),
                Carbon::parse($end)->endOfDay()
            ]);
        }

        // Filter sales (jika ada)
        if (is_numeric($sales_id)) {
            $query->where('stores.created_by', $sales_id);
        }

        $data = $query->get();

        $salesName = $sales_id
            ? DB::table('users')->where('id', $sales_id)->value('name')
            : 'Semua Sales';

        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $periode = ($start && $end)
            ? Carbon::parse($start)->format('d-m-Y') . ' s/d ' . Carbon::parse($end)->format('d-m-Y')
            : 'Semua Periode';
        $adminName = auth()->user()->name;

        $pdf = Pdf::loadView('laporan.tokoPdf', compact('data', 'salesName', 'periode', 'tanggalCetak', 'adminName'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-toko.pdf');
    }

    public function prospek(Request $request)
    {
        $x = new MnUser();
        $dtx = new MnLead();

        if ($request->ajax()) {
            $salesId = $request->input('sales_id');
            $status = $request->input('status');
            $endDate = $request->input('end_date');
            $startDate = $request->input('start_date');

            $query = DB::table('leads AS A')
                ->join('stores AS B', 'A.store_id', '=', 'B.id')
                ->join('users AS C', 'A.created_by', '=', 'C.id')
                ->select(
                    'A.*',
                    'C.id as id_usr',
                    'C.name as nm_sales',
                    'B.name as store_name'
                );

            if (is_numeric($salesId)) {
                $query->where('A.created_by', $salesId);
            }

            if (!empty($status) && $status !== 'all') {
                $query->where('A.status', $status);
            }

            if (!empty($startDate)) {
                $query->whereDate('A.created_at', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->whereDate('A.created_at', '<=', $endDate);
            }

            // Total data sebelum filter
            $recordsTotal = $query->count();

            // Pagination & draw
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $draw = intval($request->input('draw'));

            $data = $query
                ->offset($start)
                ->limit($length)
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsTotal, // bisa disesuaikan jika ada pencarian
                'data' => $data,
                'message' => $recordsTotal === 0 ? 'Data tidak ditemukan.' : null

            ]);
        }

        $data2 = $x->getAll();
        $data3 = $dtx->getStatus();

        return view('laporan.prospek', compact('data2', 'data3'));
    }

    public function prospekExportPDF(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        $sales_id = $request->sales_id;
        $status = $request->status;

        $query = DB::table('leads')
            ->select(
                'stores.name as store_name',
                'stores.owner_name',
                'stores.phone',
                'stores.address',
                'users.name as sales_name',
                'leads.status',
                'leads.notes',
                'leads.created_at'
            )
            ->join('stores', 'leads.store_id', '=', 'stores.id')
            ->join('users', 'leads.created_by', '=', 'users.id')
            ->orderBy('leads.created_at', 'desc');

        if ($start && $end) {
            $query->whereBetween('leads.created_at', [
                Carbon::parse($start)->startOfDay(),
                Carbon::parse($end)->endOfDay()
            ]);
        }

        if (is_numeric($sales_id)) {
            $query->where('leads.created_by', $sales_id);
            $salesName = DB::table('users')->where('id', $sales_id)->value('name');
        } else {
            $salesName = null;
        }

        if ($status && in_array($status, ['baru', 'follow_up', 'closing', 'gagal'])) {
            $query->where('leads.status', $status);
            $statusLabel = ucfirst($status);
        } else {
            $statusLabel = null;
        }

        $data = $query->get();

        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $periode = ($start && $end)
            ? Carbon::parse($start)->format('d-m-Y') . ' s/d ' . Carbon::parse($end)->format('d-m-Y')
            : 'Semua Periode';
        $adminName = auth()->user()->name;

        $pdf = Pdf::loadView('laporan.prospekPdf', compact(
            'data',
            'salesName',
            'statusLabel',
            'periode',
            'tanggalCetak',
            'adminName'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan-prospek.pdf');
    }
    public function aktifitas(Request $request)
    {
        $x = new MnUser();
        $dtx = new MnActivity();

        if ($request->ajax()) {
            $salesId = $request->input('sales_id');
            $status = $request->input('status');
            $endDate = $request->input('end_date');
            $startDate = $request->input('start_date');

            $query = DB::table('activities')
                ->join('leads', 'activities.lead_id', '=', 'leads.id')
                ->join('stores', 'leads.store_id', '=', 'stores.id')
                ->join('users', 'leads.created_by', '=', 'users.id')
                ->select(
                    'activities.date',
                    'activities.type',
                    'activities.description',
                    'stores.name as store_name',
                    'users.name as sales_name'
                );

            if (is_numeric($salesId)) {
                $query->where('users.id', $salesId);
            }

            if (!empty($status) && $status !== 'all') {
                $query->where('activities.type', $status);
            }

            if (!empty($startDate)) {
                $query->whereDate('activities.created_at', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->whereDate('activities.created_at', '<=', $endDate);
            }

            // Total data sebelum filter
            $recordsTotal = $query->count();

            // Pagination & draw
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $draw = intval($request->input('draw'));

            $data = $query
                ->offset($start)
                ->limit($length)
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsTotal, // bisa disesuaikan jika ada pencarian
                'data' => $data,
                'message' => $recordsTotal === 0 ? 'Data tidak ditemukan.' : null

            ]);
        }

        $data2 = $x->getAll();
        $data3 = $dtx->getType();

        return view('laporan.aktifitas', compact('data2', 'data3'));
    }

    public function aktifitasexportPDF(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        $sales_id = $request->sales_id;
        $type = $request->status;

        $query = DB::table('activities')
            ->join('leads', 'activities.lead_id', '=', 'leads.id')
            ->join('stores', 'leads.store_id', '=', 'stores.id')
            ->join('users', 'leads.created_by', '=', 'users.id')
            ->select(
                'activities.date',
                'activities.type',
                'activities.description',
                'stores.name as store_name',
                'users.name as sales_name'
            )
            ->orderBy('activities.date', 'desc');

        if ($start && $end) {
            $query->whereBetween('activities.date', [
                Carbon::parse($start)->startOfDay(),
                Carbon::parse($end)->endOfDay()
            ]);
        }

        if (is_numeric($sales_id)) {
            $query->where('users.id', $sales_id);
        } else {
            $sales_id = null;
        }

        if ($type && in_array($type, ['call', 'email', 'kunjungan'])) {
            $query->where('activities.type', $type);
            $statusLabel = ucfirst($type);
        } else {
            $statusLabel = null;
        }

        $data = $query->get();

        $salesName = $sales_id
            ? DB::table('users')->where('id', $sales_id)->value('name')
            : 'Semua Sales';

        $jenisAktivitas = $type ?? 'Semua Jenis';
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $periode = ($start && $end)
            ? Carbon::parse($start)->format('d-m-Y') . ' s/d ' . Carbon::parse($end)->format('d-m-Y')
            : 'Semua Periode';
        $adminName = auth()->user()->name;

        $pdf = Pdf::loadView('laporan.aktifitasPdf', compact(
            'data',
            'salesName',
            'jenisAktivitas',
            'periode',
            'tanggalCetak',
            'adminName'
        ))->setPaper('A4', 'landscape');

        return $pdf->download('laporan-aktivitas.pdf');
    }
}
