<?php

namespace App\Http\Controllers;

use App\Models\PerihalSurat;
use App\Http\Requests\StorePerihalSuratRequest;
use App\Http\Requests\UpdatePerihalSuratRequest;
use Illuminate\Http\Request;

class PerihalSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $perihalSurat = PerihalSurat::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.perihal_surat.index', compact('perihalSurat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.perihal_surat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePerihalSuratRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerihalSuratRequest $request)
    {
        $perihalSurat = PerihalSurat::create($request->toArray());

        return redirect()->route('perihal_surat.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerihalSurat  $perihalSurat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perihalSurat = PerihalSurat::find($id);
        return view('pages.dashboard.master-data.perihal_surat.show', compact('perihalSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerihalSurat  $perihalSurat
     * @return \Illuminate\Http\Response
     */
    public function edit(PerihalSurat $perihalSurat)
    {
        return view('pages.dashboard.master-data.perihal_surat.edit', compact('perihalSurat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerihalSuratRequest  $request
     * @param  \App\Models\PerihalSurat  $perihalSurat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerihalSuratRequest $request, PerihalSurat $perihalSurat)
    {
        $perihalSurat->update($request->toArray());

        return redirect()->route('perihal_surat.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerihalSurat  $perihalSurat
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerihalSurat $perihalSurat)
    {
        $perihalSurat->delete();
        return redirect()->route('perihal_surat.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
