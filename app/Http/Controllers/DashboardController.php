<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrangTua;
use App\Models\Instansi;
use App\Models\TamuUmum;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total per kategori
        $totalOrangtua = OrangTua::count();
        $totalInstansi = Instansi::count();
        $totalUmum = TamuUmum::count();

        $totalTamu = $totalOrangtua + $totalInstansi + $totalUmum;
        $totalKunjungan = $totalTamu; // Bisa disesuaikan jika ada logika berbeda

        // --- Hitung jumlah per bulan untuk grafik ---
        $dataPerBulan = [];
        $labelsPerBulan = [];

        // Ambil 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subMonths($i);
            $bulan = $tanggal->format('M Y');
            $labelsPerBulan[] = $tanggal->format('M');

            $countOrtu = OrangTua::whereMonth('tanggal', $tanggal->month)
                ->whereYear('tanggal', $tanggal->year)
                ->count();

            $countInstansi = Instansi::whereMonth('tanggal_kunjungan', $tanggal->month)
                ->whereYear('tanggal_kunjungan', $tanggal->year)
                ->count();

            $countUmum = TamuUmum::whereMonth('tanggal_kunjungan', $tanggal->month)
                ->whereYear('tanggal_kunjungan', $tanggal->year)
                ->count();

            $dataPerBulan[] = $countOrtu + $countInstansi + $countUmum;
        }

        // --- Data untuk pie chart distribusi tipe tamu ---
        $chartData = [
            'labels' => ['Orang Tua', 'Instansi', 'Umum'],
            'data' => [$totalOrangtua, $totalInstansi, $totalUmum],
            'colors' => ['#10b981', '#3b82f6', '#f59e0b']
        ];

        // --- Daftar tamu terbaru ---
        $latestOrangTua = OrangTua::select([
            'nama_orangtua as nama',
            'tanggal',
            'keperluan',
            \DB::raw("'Orang Tua' as tipe")
        ]);

        $latestInstansi = Instansi::select([
            'nama',
            'tanggal_kunjungan as tanggal',
            'keperluan',
            \DB::raw("'Instansi' as tipe")
        ]);

        $latestUmum = TamuUmum::select([
            'nama',
            'tanggal_kunjungan as tanggal',
            'keperluan',
            \DB::raw("'Umum' as tipe")
        ]);

        $latestGuests = $latestOrangTua
            ->unionAll($latestInstansi)
            ->unionAll($latestUmum);

        $latestGuests = \DB::table(\DB::raw("({$latestGuests->toSql()}) as combined"))
            ->mergeBindings($latestOrangTua->getQuery())
            ->orderBy('tanggal', 'desc')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'totalTamu',
            'totalKunjungan',
            'totalOrangtua',
            'totalInstansi',
            'totalUmum',
            'latestGuests',
            'dataPerBulan',
            'labelsPerBulan',
            'chartData'
        ));
    }

    public function latestMeta(Request $request)
    {
        $latestOrtu = OrangTua::select('id', 'created_at')->orderByDesc('id')->first();
        $latestInstansi = Instansi::select('id', 'created_at')->orderByDesc('id')->first();
        $latestUmum = TamuUmum::select('id', 'created_at')->orderByDesc('id')->first();

        $candidates = [];
        if ($latestOrtu) $candidates[] = ['type' => 'orangtua', 'id' => $latestOrtu->id, 'created_at' => $latestOrtu->created_at?->timestamp ?? 0];
        if ($latestInstansi) $candidates[] = ['type' => 'instansi', 'id' => $latestInstansi->id, 'created_at' => $latestInstansi->created_at?->timestamp ?? 0];
        if ($latestUmum) $candidates[] = ['type' => 'umum', 'id' => $latestUmum->id, 'created_at' => $latestUmum->created_at?->timestamp ?? 0];

        usort($candidates, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        $latest = $candidates[0] ?? ['type' => null, 'id' => 0, 'created_at' => 0];

        return response()->json([
            'latest_type' => $latest['type'],
            'latest_id' => (int) $latest['id'],
            'latest_created_at' => (int) $latest['created_at'],
            'counts' => [
                'orangtua' => (int) OrangTua::count(),
                'instansi' => (int) Instansi::count(),
                'umum' => (int) TamuUmum::count(),
                'total' => (int) (OrangTua::count() + Instansi::count() + TamuUmum::count()),
            ],
        ]);
    }

    public function stream(Request $request)
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $headers = [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, must-revalidate',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ];

        return response()->stream(function () use ($request) {
            $lastSent = 0;
            if (isset($_SERVER['HTTP_LAST_EVENT_ID'])) {
                $lastSent = (int) $_SERVER['HTTP_LAST_EVENT_ID'];
            }

            $sendEvent = function (array $payload) use (&$lastSent) {
                $id = $payload['latest_created_at'] ?? time();
                $lastSent = $id;
                echo 'id: ' . $id . "\n";
                echo 'event: guest' . "\n";
                echo 'data: ' . json_encode($payload) . "\n\n";
                @ob_flush();
                @flush();
            };

            $getLatest = function () {
                $latestOrtu = OrangTua::select('id', 'created_at')->orderByDesc('id')->first();
                $latestInstansi = Instansi::select('id', 'created_at')->orderByDesc('id')->first();
                $latestUmum = TamuUmum::select('id', 'created_at')->orderByDesc('id')->first();

                $candidates = [];
                if ($latestOrtu) $candidates[] = ['type' => 'Orang Tua', 'id' => $latestOrtu->id, 'created_at' => $latestOrtu->created_at?->timestamp ?? 0];
                if ($latestInstansi) $candidates[] = ['type' => 'Instansi', 'id' => $latestInstansi->id, 'created_at' => $latestInstansi->created_at?->timestamp ?? 0];
                if ($latestUmum) $candidates[] = ['type' => 'Umum', 'id' => $latestUmum->id, 'created_at' => $latestUmum->created_at?->timestamp ?? 0];

                usort($candidates, function ($a, $b) {
                    return $b['created_at'] <=> $a['created_at'];
                });

                $latest = $candidates[0] ?? ['type' => null, 'id' => 0, 'created_at' => 0];

                return [
                    'latest_type' => $latest['type'],
                    'latest_id' => (int) $latest['id'],
                    'latest_created_at' => (int) $latest['created_at'],
                ];
            };

            // Initial state
            $meta = $getLatest();
            $lastSent = $meta['latest_created_at'] ?? 0;
            $sendEvent($meta);

            // Stream loop
            while (!connection_aborted()) {
                $current = $getLatest();
                if (($current['latest_created_at'] ?? 0) > $lastSent) {
                    $sendEvent($current);
                }
                sleep(3);
            }
        }, 200, $headers);
    }
}