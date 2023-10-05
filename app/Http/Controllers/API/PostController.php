<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditemukan!',
            'data' => PostDetailResource::collection($post)
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
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => Auth::user()->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditambahkan!',
            'data' => new PostDetailResource($post)
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
        // Ketika menggunakan eiger loader, maka fungsi relationship akan berfungsi
        // $post = Post::with('writer:id,username')->findOrFail($id);

        // Ketika menggunakan eiger loader, maka fungsi relationship tidak akan muncul
        $post = Post::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditemukan!',
            'data' => new PostDetailResource($post)
        ]);
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
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => Auth::user()->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Diubah!',
            'data' => new PostDetailResource($post)
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
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil dihapus!'
        ]);
    }
}
