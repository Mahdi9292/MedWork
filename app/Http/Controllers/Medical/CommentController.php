<?php

namespace App\Http\Controllers\Medical;

use App\Enums\Medical\CommentType;
use App\Http\Requests\CommentRequest;
use App\Models\Medical\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends BaseMedicalController
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Comment::class);
        return view('templates.medical.comment.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Comment::class);

        $data['commentTypeOptions']      = CommentType::options();
        return view('templates.medical.comment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $this->authorize('create', Comment::class);

        Comment::create($request->validated());
        return redirect()->route('medical.comments.index')->with('success', 'Responsible Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);
        return view('templates.medical.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        $data['commentTypeOptions']      = CommentType::options();

        return view('templates.medical.comment.edit', compact('comment'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());
        return redirect()->route('medical.comments.index')->with('success', __('Speichern erfolgreich'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->route('medical.comments.index')->with('info', __('Erfolgreich gelöscht'));
    }

}
