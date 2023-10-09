<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required'
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->id,
            'comments_content' => $request->comments_content
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Komentar Berhasil Ditambahkan!',
            'data' => new CommentResource($comment->loadMissing(['commentator:id,username']))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'comments_content' => 'required'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->only('comments_content'));

        return response()->json([
            'status' => true,
            'message' => 'Komentar Berhasil Ditambahkan!',
            'data' => new CommentResource($comment->loadMissing(['commentator:id,username']))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Komentar Berhasil dihapus!'
        ]);
    }
}
