<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Exports\InstansiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $sort = $request->get('sort', 'newest');

        $query = Instansi::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('instansi_asal', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhere('guru_dituju', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%");
            });
        }

        if ($bulan) {
            $query->whereMonth('tanggal_kunjungan', $bulan);
        }

        if ($sort === 'oldest') {
            $query->orderBy('tanggal_kunjungan', 'asc');
        } else {
            $query->orderBy('tanggal_kunjungan', 'desc');
        }

        $instansi = $query->paginate(15);

        return view('instansi.index', compact('instansi', 'search', 'bulan', 'sort'));
    }

    public function export(Request $request)
    {
        $bulan = $request->get('bulan');
        $search = $request->get('search');
        $sort = $request->get('sort', 'newest');

        $filename = 'instansi'.'.xlsx';

        return Excel::download(new InstansiExport($bulan, $search, $sort), $filename);
    }

    public function create()
    {
        return view('instansi.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'nama'           => 'required|string|max:255',
        'instansi_asal'  => 'required|string|max:255',
        'keperluan'      => 'required|string',
        'kontak'         => 'nullable|string|max:20',
        'guru_dituju'    => 'required|string|max:255',
        'jumlah_peserta' => 'required|integer|min:1',
        'foto'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    // ⏰ Auto isi tanggal & waktu kunjungan dari sistem
    $data['tanggal_kunjungan'] = now()->toDateString();   // contoh: 2025-09-08
    $data['waktu_kunjungan']   = now()->toTimeString();   // contoh: 16:15:42

    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('instansi', 'public');
        $data['foto'] = $fotoPath;
    }

    Instansi::create($data);

    return redirect()->route('instansi.index')->with('success', 'Data instansi berhasil ditambahkan!');
}


    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi_asal' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'guru_dituju' => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer|min:1',
            'waktu_kunjungan' => 'required|date_format:H:i',
            'tanggal_kunjungan' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($instansi->foto) {
                Storage::disk('public')->delete($instansi->foto);
            }
            $fotoPath = $request->file('foto')->store('instansi', 'public');
            $data['foto'] = $fotoPath;
        }

        $instansi->update($data);

        return redirect()->route('instansi.index')->with('success', 'Data instansi berhasil diperbarui!');
    }

    public function destroy(Instansi $instansi)
    {
        if ($instansi->foto) {
            Storage::disk('public')->delete($instansi->foto);
        }

        $instansi->delete();

        return redirect()->route('instansi.index')->with('success', 'Data instansi berhasil dihapus!');
    }
}