<?php

namespace App\Http\Controllers;

use App\Models\TamuUmum;
use Carbon\Carbon;
use App\Exports\TamuUmumExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TamuUmumController extends Controller
{
   public function index(Request $request)
{
    $search = $request->get('search');
    $bulan = $request->get('bulan');
    $sort = $request->get('sort', 'newest');

    $query = TamuUmum::query();

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('identitas', 'like', "%{$search}%")
              ->orWhere('keperluan', 'like', "%{$search}%")
              ->orWhere('guru_dituju', 'like', "%{$search}%");
        });
    }

    if (!empty($bulan)) {
        $query->whereMonth('tanggal_kunjungan', $bulan);
    }

    if ($sort === 'oldest') {
        $query->orderBy('tanggal_kunjungan', 'asc');
    } else {
        $query->orderBy('tanggal_kunjungan', 'desc');
    }

    // ✅ perbaikan: pake $tamu_umum
    $tamu_umum = $query->paginate(15);

    return view('tamu_umum.index', compact('tamu_umum', 'search', 'bulan', 'sort'));
}

    public function export(Request $request)
    {
        $bulan = $request->get('bulan');
        $search = $request->get('search');
        $sort = $request->get('sort', 'newest');

        $filename = 'tamu_umum'.'.xlsx';

        return Excel::download(new TamuUmumExport($bulan, $search, $sort), $filename);
    }

    public function create()
    {
        return view('tamu_umum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'identitas' => 'required|string',
            'keperluan' => 'required|string|max:255',
            'guru_dituju' => 'required|string|max:255',
            'kontak' => [
                'required',
                'regex:/^(\+62|62|0)[0-9]{9,13}$/'
            ],
            'waktu_kunjungan' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'kontak.regex' => 'Nomor telepon harus berupa angka dan sesuai format Indonesia (contoh: 081234567890).'
        ]);

         $identitas = $request->identitas == 'Lainnya' 
            ? $request->identitas_lainnya 
            : $request->identitas;

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('tamu_umum', 'public');
        }

        TamuUmum::create([
            'nama' => $request->nama,
            'identitas' => $identitas,
            'keperluan' => $request->keperluan,
            'guru_dituju' => $request->guru_dituju,
            'kontak' => $request->kontak,
            'waktu_kunjungan' => $request->waktu_kunjungan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('tamu_umum.index')->with('success', 'Data tamu umum berhasil disimpan!');
    }
public function storeUmum(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'identitas' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'guru' => 'nullable|string|max:255',
            'waktu' => 'required',
            'tanggal' => 'required|date',
            'foto_data' => 'nullable|string',
        ]);

        // Simpan ke database
        $tamu = new Tamu();
        $tamu->nama = $validated['nama'];
        $tamu->identitas = $validated['identitas'];
        $tamu->keperluan = $validated['keperluan'];
        $tamu->kontak = $validated['kontak'] ?? null;
        $tamu->guru = $validated['guru'] ?? null;
        $tamu->waktu = $validated['waktu'];
        $tamu->tanggal = $validated['tanggal'];

        // Simpan foto base64 kalau ada
        if (!empty($validated['foto_data'])) {
            $image = str_replace('data:image/png;base64,', '', $validated['foto_data']);
            $image = str_replace(' ', '+', $image);
            $imageName = 'foto_'.time().'.png';
            \File::put(public_path('uploads/foto/'.$imageName), base64_decode($image));
            $tamu->foto = $imageName;
        }

        $tamu->save();

        return response()->json(['message' => 'Data tamu berhasil disimpan!']);
    }
    
    public function edit(TamuUmum $tamu_umum)
    {
        return view('tamu_umum.edit', compact('tamu_umum'));
    }

    public function update(Request $request, TamuUmum $tamu_umum)
{
    $data = $request->validate([
        'nama' => 'required|string|max:255',
        'identitas' => 'required|string',
        'identitas_lainnya' => 'nullable|string|max:255',
        'keperluan' => 'required|string|max:255',
        'guru_dituju' => 'required|string|max:255',
        'kontak' => [
            'required',
            'regex:/^(\+62|62|0)[0-9]{9,13}$/'
        ],
        'waktu_kunjungan' => 'required',
        'tanggal_kunjungan' => 'required|date',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($data['identitas'] === 'Lainnya' && !empty($data['identitas_lainnya'])) {
        $data['identitas'] = $data['identitas_lainnya'];
    }
    unset($data['identitas_lainnya']);

    if ($request->hasFile('foto')) {
        if ($tamu_umum->foto) {
            Storage::disk('public')->delete($tamu_umum->foto);
        }
        $data['foto'] = $request->file('foto')->store('tamu_umum', 'public');
    }

    $tamu_umum->update($data);

    return redirect()->route('tamu_umum.index')->with('success', 'Data tamu umum berhasil diperbarui!');
}


    public function destroy(TamuUmum $tamu_umum)
    {
        if ($tamu_umum->foto) {
            Storage::disk('public')->delete($tamu_umum->foto);
        }

        $tamu_umum->delete();

        return redirect()->route('tamu_umum.index')->with('success', 'Data orang tua siswa berhasil dihapus!');
    }
}
