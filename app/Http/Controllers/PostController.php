<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
  public function post_list(Request $request): JsonResponse
  {
      $post = Post::get([
        'id',
        'title',
        'description',
        'image',
      ]);
      return response()->json([
        'data' => $post,
        'status' => 200,
        'message' => 'Post show successful.',
      ]);
  }
  public function post_store(PostStoreRequest $request)
  {
    $validation = $request->validated();

      $file = $validation['image'];
      $fileName = time() . '.' . $file->getClientOriginalExtension();
      $file->move('post-images/', $fileName);
      $image = $fileName;

      $post = Post::create([
        'title' => $validation['title'],
        'description' => $validation['description'],
        'image' => $image,
      ]);
      return response()->json([
        'data' => $post,
        'status' => 200,
        'message' => 'Post store successful.',
      ]);
  }
}
