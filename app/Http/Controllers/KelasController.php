<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::latest()->get();

        return view('backend.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
            'jurusan' => 'required|string|max:255',
        ], [
            'nama_kelas.required' => 'Nama kelas harus diisi',
            'nama_kelas.unique' => 'Nama kelas sudah ada',
            'nama_kelas.max' => 'Nama kelas maksimal 255 karakter',
            'jurusan.required' => 'Jurusan harus diisi',
            'jurusan.max' => 'Jurusan maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'jurusan' => $request->jurusan,
            ]);

            return redirect()->route('kelas.index')
                ->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan kelas: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,'.$id,
            'jurusan' => 'required|string|max:255',
        ], [
            'nama_kelas.required' => 'Nama kelas harus diisi',
            'nama_kelas.unique' => 'Nama kelas sudah ada',
            'nama_kelas.max' => 'Nama kelas maksimal 255 karakter',
            'jurusan.required' => 'Jurusan harus diisi',
            'jurusan.max' => 'Jurusan maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'jurusan' => $request->jurusan,
            ]);

            return redirect()->route('kelas.index')
                ->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kelas: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);

            // Check if kelas has related users
            if ($kelas->user()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa terkait!');
            }

            $kelas->delete();

            return redirect()->route('kelas.index')
                ->with('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus kelas: '.$e->getMessage());
        }
    }
}
