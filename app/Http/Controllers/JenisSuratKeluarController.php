<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJenisSuratKeluarRequest;
use App\Http\Requests\UpdateJenisSuratKeluarRequest;
use App\Models\JenisSuratKeluar;
use Illuminate\Http\Request;

class JenisSuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $jenisSuratKeluar = JenisSuratKeluar::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.jenis_surat_keluar.index', compact('jenisSuratKeluar'));
    }

    /**
     * Show the form for creating a new resource.
     *Keluar
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.jenis_surat_keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJenisSuratKeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisSuratKeluarRequest $request)
    {
        $jenisSuratKeluar = JenisSuratKeluar::create($request->toArray());

        return redirect()->route('jenis_surat_keluar.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisSuratKeluar  $jenisSuratKeluar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenisSuratKeluar = JenisSuratKeluar::find($id);
        return view('pages.dashboard.master-data.jenis_surat_keluar.show', compact('jenisSuratKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisSuratKeluar  $jenisSuratKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisSuratKeluar $jenisSuratKeluar)
    {
        return view('pages.dashboard.master-data.jenis_surat_keluar.edit', compact('jenisSuratKeluar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisSuratKeluarRequest  $request
     * @param  \App\Models\JenisSuratKeluar  $jenisSuratKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisSuratKeluarRequest $request, JenisSuratKeluar $jenisSuratKeluar)
    {
        $jenisSuratKeluar->update($request->toArray());

        return redirect()->route('jenis_surat_keluar.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisSuratKeluar  $jenisSuratKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisSuratKeluar $jenisSuratKeluar)
    {
        $jenisSuratKeluar->delete();
        return redirect()->route('jenis_surat_keluar.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
