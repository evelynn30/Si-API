<?php

namespace App\Http\Controllers;

use App\Models\Penemu;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenemuRequest;
use App\Http\Requests\UpdatePenemuRequest;

class PenemuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $penemu = Penemu::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.penemu.index', compact('penemu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.penemu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenemuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenemuRequest $request)
    {
        $penemu = Penemu::create($request->toArray());

        return redirect()->route('penemu.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penemu  $penemu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penemu = Penemu::find($id);
        return view('pages.dashboard.master-data.penemu.show', compact('penemu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penemu  $penemu
     * @return \Illuminate\Http\Response
     */
    public function edit(Penemu $penemu)
    {
        return view('pages.dashboard.master-data.penemu.edit', compact('penemu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenemuRequest  $request
     * @param  \App\Models\Penemu  $penemu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenemuRequest $request, Penemu $penemu)
    {
        $penemu->update($request->toArray());

        return redirect()->route('penemu.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penemu  $penemu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penemu $penemu)
    {
        $penemu->delete();
        return redirect()->route('penemu.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
