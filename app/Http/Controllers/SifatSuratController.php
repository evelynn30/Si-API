<?php

namespace App\Http\Controllers;

use App\Models\SifatSurat;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSifatSuratRequest;
use App\Http\Requests\UpdateSifatSuratRequest;

class SifatSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $sifatSurat = SifatSurat::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.sifat_surat.index', compact('sifatSurat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.sifat_surat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSifatSuratRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSifatSuratRequest $request)
    {
        $sifatSurat = SifatSurat::create($request->toArray());

        return redirect()->route('sifat_surat.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SifatSurat  $sifatSurat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sifatSurat = SifatSurat::find($id);
        return view('pages.dashboard.master-data.sifat_surat.show', compact('sifatSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SifatSurat  $sifatSurat
     * @return \Illuminate\Http\Response
     */
    public function edit(SifatSurat $sifatSurat)
    {
        return view('pages.dashboard.master-data.sifat_surat.edit', compact('sifatSurat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSifatSuratRequest  $request
     * @param  \App\Models\SifatSurat  $sifatSurat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSifatSuratRequest $request, SifatSurat $sifatSurat)
    {
        $sifatSurat->update($request->toArray());

        return redirect()->route('sifat_surat.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SifatSurat  $sifatSurat
     * @return \Illuminate\Http\Response
     */
    public function destroy(SifatSurat $sifatSurat)
    {
        $sifatSurat->delete();
        return redirect()->route('sifat_surat.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
