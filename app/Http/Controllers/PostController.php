<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPost(Request $request) {
        $PostObj = Post::create([
            'post' => $request->input("post"),
            'user' => $request->input("user"),
        ]);
        return $this->getPost($PostObj->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createComment(Request $request) {
        return Post::create([
            'post' => $request->input("post"),
            'parent' => $request->input("parent"),
            'user' => $request->input("user"),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getPost($PostId) {
        return DB::table('posts')
            ->join('users', 'posts.user', '=', 'users.id')
            ->where("posts.id", "=", $PostId)
            ->select('posts.*', 'users.first_name', 'users.last_name')
            ->orderBy("posts.created_at", "DESC")
            ->get()
            ->first();
    }

    public function getPosts(): \Illuminate\Support\Collection {
        return DB::table('posts')
            ->join('users', 'posts.user', '=', 'users.id')
            ->whereNull("posts.parent")
            ->select('posts.*', 'users.first_name', 'users.last_name')
            ->orderBy("posts.created_at", "DESC")
            ->get();
    }

    public function getComments(): \Illuminate\Support\Collection {
        return DB::table('posts')
            ->join('users', 'posts.user', '=', 'users.id')
            ->whereNotNull("posts.parent")
            ->select('posts.*', 'users.first_name', 'users.last_name')
            ->get();
    }

    public function getPostComments(Request $request, $post_id): \Illuminate\Support\Collection {
        return DB::table('posts')
            ->join('users', 'posts.user', '=', 'users.id')
            ->where("posts.parent" ,"=", $post_id)
            ->select('posts.*', 'users.first_name', 'users.last_name')
            ->get();
    }
}
