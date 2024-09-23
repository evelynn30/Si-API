<?php

namespace App\Http\Controllers;

use App\Models\Insiden;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInsidenRequest;
use App\Http\Requests\UpdateInsidenRequest;

class InsidenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $insiden = Insiden::when($search, function ($query) use ($search) {
            return $query->where('nama', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('pages.dashboard.master-data.insiden.index', compact('insiden'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.master-data.insiden.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInsidenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInsidenRequest $request)
    {
        $insiden = Insiden::create($request->toArray());

        return redirect()->route('insiden.index')->with(['status' => 'success', 'message' => 'Data berhasil ditambahkan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insiden  $insiden
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insiden = Insiden::find($id);
        return view('pages.dashboard.master-data.insiden.show', compact('insiden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Insiden  $insiden
     * @return \Illuminate\Http\Response
     */
    public function edit(Insiden $insiden)
    {
        return view('pages.dashboard.master-data.insiden.edit', compact('insiden'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInsidenRequest  $request
     * @param  \App\Models\Insiden  $insiden
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInsidenRequest $request, Insiden $insiden)
    {
        $insiden->update($request->toArray());

        return redirect()->route('insiden.index')->with(['status' => 'success', 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Insiden  $insiden
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insiden $insiden)
    {
        $insiden->delete();
        return redirect()->route('insiden.index')->with(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }
}
