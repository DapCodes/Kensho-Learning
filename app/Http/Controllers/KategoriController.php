<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain',
        ]);

        try {
            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori "'.$request->nama_kategori.'" berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan kategori. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            abort(404);
        }

        $kategori = Kategori::with('quiz')->findOrFail($id);
        return view('backend.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            abort(404, 'ID kategori tidak valid');
        }

        try {
            $kategori = Kategori::findOrFail($id);
            return view('backend.kategori.edit', compact('kategori'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Kategori dengan ID ' . $id . ' tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            return redirect()->route('kategori.index')
                ->with('error', 'ID kategori tidak valid');
        }

        try {
            $kategori = Kategori::findOrFail($id);

            $request->validate([
                'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,'.$id,
            ], [
                'nama_kategori.required' => 'Nama kategori wajib diisi',
                'nama_kategori.max' => 'Nama kategori maksimal 255 karakter',
                'nama_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain',
            ]);

            $oldName = $kategori->nama_kategori;

            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori "'.$oldName.'" berhasil diperbarui menjadi "'.$request->nama_kategori.'"');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori dengan ID ' . $id . ' tidak ditemukan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Validasi ID
            if (!is_numeric($id)) {
                return redirect()->route('kategori.index')
                    ->with('error', 'ID kategori tidak valid');
            }

            $kategori = Kategori::findOrFail($id);
            $namaKategori = $kategori->nama_kategori;

            // Check if kategori has related quiz
            if ($kategori->quiz()->count() > 0) {
                return redirect()->route('kategori.index')
                    ->with('error', 'Kategori "'.$namaKategori.'" tidak dapat dihapus karena masih memiliki quiz terkait.');
            }

            $kategori->delete();

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori "'.$namaKategori.'" berhasil dihapus');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }

    /**
     * Get all categories for dropdown/select options
     */
    public function getCategories()
    {
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();
        return response()->json($categories);
    }

    /**
     * Search categories by name
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $categories = Kategori::where('nama_kategori', 'LIKE', '%'.$query.'%')
            ->orderBy('nama_kategori', 'asc')
            ->limit(10)
            ->get();

        return response()->json($categories);
    }
}