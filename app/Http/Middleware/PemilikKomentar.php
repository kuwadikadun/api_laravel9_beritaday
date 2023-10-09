<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilikKomentar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user()->id;

        $comment = Comment::findOrFail($request->id);

        if($comment->user_id != $user){
            return response()->json([
                'status' => false,
                'message' => 'Anda Bukan Pemilik Komentar!'
            ]);
        }

        return $next($request);
    }
}
