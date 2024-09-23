<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOpdRequest;
use App\Http\Requests\UpdateOpdRequest;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $opd = Opd::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('narahubung', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.opd.index', compact('opd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.opd.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOpdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOpdRequest $request)
    {
        $opd = Opd::create($request->toArray());

        return redirect()->route('opd.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $opd = Opd::find($id);
        return view('pages.dashboard.master-data.opd.show', compact('opd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function edit(Opd $opd)
    {
        return view('pages.dashboard.master-data.opd.edit', compact('opd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOpdRequest  $request
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOpdRequest $request, Opd $opd)
    {
        $opd->update($request->toArray());

        return redirect()->route('opd.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opd  $opd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opd $opd)
    {
        $opd->delete();
        return redirect()->route('opd.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}