<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use App\Models\Label;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
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
    public function create(Item $item)
    {
        if (Gate::denies('create-comment')) {
            abort(403);
        }

        return view('items.show', [
            'item' => $item,
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
        if (Gate::denies('create-comment')) {
            abort(403);
        }

        $validated = $request->validate(
            [
                'text' => 'required|max:255',
                'itemId' => 'required|exists:items,id'
            ]
        );

        $comment = Comment::factory()->create([
            'text' => $validated['text'],
            'user_id' => Auth::id(),
            'item_id' => $validated['itemId'],
        ]);

        Session::flash('comment_created', 'Comment successfully created!');

        return redirect()->route('items.show', $validated['itemId']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        if (Gate::denies('edit-comment', $comment)) {
            abort(403);
        }


        $validated = $request->validate(
            [
                'comment-'.$comment->id => 'required|max:255',
                'itemId' => 'required|exists:items,id'
            ]
        );

        $comment->text = $validated['comment-'.$comment->id];
        $comment->item_id = $validated['itemId'];
        $comment->save();

        Session::flash('comment', 'Comment successfully updated!');

        return redirect()->route('items.show', Item::find($validated['itemId']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if(Gate::denies('delete-comment', $comment)) {
            abort(403);
        }

        $itemId = $comment->item_id;

        $comment->delete();

        Session::flash('comment', 'Comment successfully deleted!');

        return redirect()->route('items.show', $itemId);
    }
}
