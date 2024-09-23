<?php

namespace App\Http\Controllers;

use App\Models\JenisSuratMasuk;
use App\Http\Requests\StoreJenisSuratMasukRequest;
use App\Http\Requests\UpdateJenisSuratMasukRequest;
use Illuminate\Http\Request;

class JenisSuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $jenisSuratMasuk = JenisSuratMasuk::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.jenis_surat_masuk.index', compact('jenisSuratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.jenis_surat_masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJenisSuratMasukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisSuratMasukRequest $request)
    {
        $jenisSuratMasuk = JenisSuratMasuk::create($request->toArray());

        return redirect()->route('jenis_surat_masuk.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisSuratMasuk  $jenisSuratMasuk
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenisSuratMasuk = JenisSuratMasuk::find($id);
        return view('pages.dashboard.master-data.jenis_surat_masuk.show', compact('jenisSuratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisSuratMasuk  $jenisSuratMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisSuratMasuk $jenisSuratMasuk)
    {
        return view('pages.dashboard.master-data.jenis_surat_masuk.edit', compact('jenisSuratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisSuratMasukRequest  $request
     * @param  \App\Models\JenisSuratMasuk  $jenisSuratMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisSuratMasukRequest $request, JenisSuratMasuk $jenisSuratMasuk)
    {
        $jenisSuratMasuk->update($request->toArray());

        return redirect()->route('jenis_surat_masuk.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisSuratMasuk  $jenisSuratMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisSuratMasuk $jenisSuratMasuk)
    {
        $jenisSuratMasuk->delete();
        return redirect()->route('jenis_surat_masuk.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
