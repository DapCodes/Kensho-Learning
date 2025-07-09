<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mataPelajaran = MataPelajaran::latest()->get();
        return view('backend.matapelajaran.index', compact('mataPelajaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambahkan mata pelajaran. Silakan periksa input Anda.');
        }

        try {
            MataPelajaran::create([
                'nama_mapel' => $request->nama_mapel,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('matapelajaran.index')
                ->with('success', 'Mata pelajaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan mata pelajaran.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajarans,nama_mapel,' . $id,
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate mata pelajaran. Silakan periksa input Anda.');
        }

        try {
            $mataPelajaran->update([
                'nama_mapel' => $request->nama_mapel,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('matapelajaran.index')
                ->with('success', 'Mata pelajaran berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate mata pelajaran.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $mataPelajaran = MataPelajaran::findOrFail($id);
            
            // Check if mata pelajaran has related quiz
            if ($mataPelajaran->quiz()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki quiz terkait.');
            }

            $mataPelajaran->delete();

            return redirect()->route('matapelajaran.index')
                ->with('success', 'Mata pelajaran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus mata pelajaran.');
        }
    }
}