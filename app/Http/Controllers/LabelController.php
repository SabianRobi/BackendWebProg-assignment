<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-label', Auth::user())) {
            abort(403);
        }
        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('create-label', Auth::user())) {
            abort(403);
        }

        $validated = $request->validate(
            [
                'name' => 'required|min:3|unique:labels,name',
                'color' => 'required|regex:/^[a-zA-Z0-9]{6}$/',
                'display.*' => 'nullable|boolean',
            ],
            [
                'color' => 'Not valid hexadecimal color.'
            ]
        );
        $validated['color'] = '#'.$validated['color'];

        Label::factory()->create($validated);

        Session::flash('label_created', $validated['name']);

        return redirect()->route('labels.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return view('labels.show', [
            'label' => $label,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        if (Gate::denies('edit-label', Auth::user())) {
            abort(403);
        }
        return view('labels.edit', [
            'label' => $label,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        if (Gate::denies('edit-label', Auth::user())) {
            abort(403);
        }

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'min:3',
                    'unique:labels,name,'.$label->id,
                ],
                'color' => 'required|regex:/^[a-zA-Z0-9]{6}$/',
                'display' => [
                    'required',
                    Rule::in(["display-yes", "display-no"])
                ],
            ],
            [
                'color' => 'Not valid hexadecimal color.'
            ]
        );

        $label->name = $validated['name'];
        $label->color = '#'.$validated['color'];
        if($validated['display'] == 'display-yes') {
            $label->display = true;
        } else {
            $label->display = false;
        }
        
        $label->save();

        Session::flash('label', 'Label updated successfully!');

        return Redirect::route('labels.show', $label);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if(Gate::denies('delete-label', Auth::user())) {
            abort(403);
        }

        $label->delete();
        Session::flash('label_deleted', 'Label successfully deleted!');
        return redirect(RouteServiceProvider::HOME);
    }
}
