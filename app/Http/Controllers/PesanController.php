<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;

class PesanController extends Controller
{
    public function index()
    {
        $pesans = Pesan::latest()->get();
        return view('welcome', compact('pesans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'email_pengirim' => 'required|email|max:255',
            'pesan' => 'required',
        ]);

        Pesan::create($request->all());

        return redirect('/')->with('success', 'Pesan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

}
