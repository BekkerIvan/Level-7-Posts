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
    public function createPost(Request $request, $user_id) {
        $NewPost = Post::create([
            'post' => $request->input("post"),
            'user' => $user_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createComment(Request $request, $post_id, $user_id) {
        $NewPost = Post::create([
            'post' => $request->input("post"),
            'parent' => $post_id,
            'user' => $user_id,
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

    public function getDashboardPosts(Request $request, $user_id): \Illuminate\Support\Collection {
        $PostStdObjArr = DB::table('posts')
            ->join('users', 'posts.user', '=', 'users.id')
            ->whereNull("posts.parent")
            ->select('posts.*', 'users.first_name', 'users.last_name')
            ->orderBy("posts.created_at", "DESC")
            ->get();
        foreach ($PostStdObjArr as $PostStdObj) {
            $this->getPosts($PostStdObj);
        }
        return $PostStdObjArr;
    }

    protected function getPosts(\stdClass &$PostStdObj) {
        $PostStdObj->comments = DB::table('posts')
            ->join('users', 'posts.user', '=', 'users.id')
            ->where("posts.parent", "=", $PostStdObj->id)
            ->select('posts.*', 'users.first_name', 'users.last_name')
            ->get();
    }
}
