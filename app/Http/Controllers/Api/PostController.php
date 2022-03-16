<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\PutRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::paginate(10));
    }

    public function all()
    {
        return response()->json(Post::get());
    }

    public function slug(Post $post)//$slug
    {
        //$post = Post::with("category")->where("slug", $slug)->firstOrFail();
        $post->category;
        return response()->json($post);
    }

    public function store(StoreRequest $request)
    {
        return response()->json(Post::create($request->validated()));
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(PutRequest $request, Post $post)
    {
        $post->update($request->validated());
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json("ok");
    }
}
