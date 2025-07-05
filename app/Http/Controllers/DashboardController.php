<?php

namespace App\Http\Controllers;

use App\Models\Models\MnLead;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Models\MnActivity;
use App\Models\Models\MnStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        $data = [
            'total_customers' => $isAdmin ? MnStore::count() : MnStore::where('created_by', $user->id)->count(),
            'total_leads'     => $isAdmin ? MnLead::count() : MnLead::where('created_by', $user->id)->count(),
            'total_activities' => $isAdmin ? MnActivity::count() : MnActivity::where('lead_id', $user->id)->count(),
            'total_closing'   => $isAdmin
                ? MnLead::where('status', 'Closing')->count()
                : MnLead::where('created_by', $user->id)->where('status', 'Closing')->count(),


        ];

        return view('Dashboard', [
            'data' => $data,
        ]);
    }
    public function grafikSemua($tahun)
    {
        $perSalesToko = DB::table('users')
            ->leftJoin('stores', function ($j) use ($tahun) {
                $j->on('users.id', '=', 'stores.created_by')
                    ->whereYear('stores.created_at', $tahun);
            })
            ->where('users.role', 'sales')
            ->select('users.name as sales', DB::raw('COUNT(stores.id) as jumlah'))
            ->groupBy('users.name')
            ->get();

        $perBulanToko = DB::table('stores')
            ->whereYear('created_at', $tahun)
            ->select(
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as bulan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('bulan')->orderBy('bulan')->get();

        $perSalesProspek = DB::table('users')
            ->leftJoin('leads', function ($j) use ($tahun) {
                $j->on('users.id', '=', 'leads.created_by')
                    ->whereYear('leads.created_at', $tahun);
            })
            ->where('users.role', 'sales')
            ->select('users.name as sales', DB::raw('COUNT(leads.id) as jumlah'))
            ->groupBy('users.name')
            ->get();

        $perBulanProspek = DB::table('leads')
            ->whereYear('created_at', $tahun)
            ->select(
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as bulan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('bulan')->orderBy('bulan')->get();

        $perSalesAktivitas = DB::table('users')
            ->leftJoin('leads', 'users.id', '=', 'leads.created_by')
            ->leftJoin('activities', function ($j) use ($tahun) {
                $j->on('leads.id', '=', 'activities.lead_id')
                    ->whereYear('activities.date', $tahun);
            })
            ->where('users.role', 'sales')
            ->select('users.name as sales', DB::raw('COUNT(activities.id) as jumlah'))
            ->groupBy('users.name')
            ->get();

        $perBulanAktivitas = DB::table('activities')
            ->whereYear('date', $tahun)
            ->select(
                DB::raw("DATE_FORMAT(date,'%Y-%m') as bulan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('bulan')->orderBy('bulan')->get();

        return response()->json([
            'toko_sales'      => $perSalesToko,
            'toko_bulan'      => $perBulanToko,
            'prospek_sales'   => $perSalesProspek,
            'prospek_bulan'   => $perBulanProspek,
            'aktiv_sales'     => $perSalesAktivitas,
            'aktiv_bulan'     => $perBulanAktivitas,
        ]);
    }

    public function pieMatrix($tahun, $bulan)
    {
        $exists = DB::table('sales_matrix')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->exists();

        if (!$exists) {
            $sales = DB::table('users')->where('role', 'sales')->get();

            foreach ($sales as $s) {
                $totalToko = DB::table('stores')
                    ->where('created_by', $s->id)
                    ->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $bulan)
                    ->count();

                DB::table('sales_matrix')->updateOrInsert(
                    ['user_id' => $s->id, 'tahun' => $tahun, 'bulan' => $bulan],
                    [
                        'jumlah_toko'       => $totalToko,
                        'jumlah_prospek'    => 0,
                        'jumlah_aktivitas'  => 0,
                        'jumlah_closing'    => 0,
                        'updated_at'        => now(),
                        'created_at'        => now(),
                    ]
                );
            }
        }

        $rows = DB::table('sales_matrix')
            ->join('users', 'users.id', '=', 'sales_matrix.user_id')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->select('users.name AS label', 'sales_matrix.jumlah_toko AS value')
            ->get();

        return response()->json($rows);
    }
}
