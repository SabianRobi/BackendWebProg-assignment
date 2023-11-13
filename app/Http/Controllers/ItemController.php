<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Label;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome', [
            'items' => DB::table('items')->orderByDesc('obtained')->paginate(12)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create-item', Auth::user())) {
            abort(403);
        }

        return view('items.create', [
            'labels' => Label::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('create-item', Auth::user())) {
            abort(403);
        }

        $validated = $request->validate(
            [
                'name' => 'required|min:3|unique:items,name',
                'description' => 'required|max:1000',
                'obtained' => 'required|date',
                'labels' => 'nullable|array',
                'labels.*' => 'numeric|integer|exists:labels,id',
                'image' => 'nullable|file|image|max:4096',
            ]
        );

        $image_path = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $image_path = $validated['name'] . '_' .date('Y-m-d_H-i-s') .'.'. $file->getClientOriginalExtension();
            
            Storage::disk('public')->put(
                $image_path,
                $file->get()
            );
        }

        $item = Item::factory()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'obtained' => date('Y-m-d H:i:s', strtotime($validated['obtained'])),
            'image' => $image_path,
        ]);

        if (isset($validated["labels"])) {
            $item->labels()->sync($validated["labels"]);
        }

        Session::flash('item_created', $validated['name']);

        return redirect()->route('items.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if(Gate::denies('delete-item', Auth::user())) {
            abort(403);
        }

        Storage::disk('public')->delete($item->image);

        $item->delete();
        Session::flash('item_deleted', 'Item successfully deleted!');
        return redirect(RouteServiceProvider::HOME);
    }
}
