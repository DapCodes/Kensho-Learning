<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

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
            'nama_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain'
        ]);

        try {
            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori "' . $request->nama_kategori . '" berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan kategori. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::with('quiz')->findOrFail($id);
        return view('backend.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('backend.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain'
        ]);

        try {
            $oldName = $kategori->nama_kategori;
            
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori "' . $oldName . '" berhasil diperbarui menjadi "' . $request->nama_kategori . '"');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $namaKategori = $kategori->nama_kategori;

            // Check if kategori has related quiz
            if ($kategori->quiz()->count() > 0) {
                return redirect()->route('kategori.index')
                    ->with('error', 'Kategori "' . $namaKategori . '" tidak dapat dihapus karena masih memiliki quiz terkait.');
            }

            $kategori->delete();

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori. Silakan coba lagi.');
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
        
        $categories = Kategori::where('nama_kategori', 'LIKE', '%' . $query . '%')
            ->orderBy('nama_kategori', 'asc')
            ->limit(10)
            ->get();
            
        return response()->json($categories);
    }
}