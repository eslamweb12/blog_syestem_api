<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\post;
use App\service\message;
use Illuminate\Http\Request;

class PostControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        // Fetch paginated posts with 2 posts per page
        $posts = post::query()->orderBy('id', 'asc')->paginate(2);
        // Return paginated posts wrapped in PostResource and include pagination metadata
        return response()->json([
            'data' => PostResource::collection($posts),  // Transform posts using PostResource
            'links' => [
                'first' => $posts->url(1),
                'last' => $posts->url($posts->lastPage()),
                'prev' => $posts->previousPageUrl(),
                'next' => $posts->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $posts->currentPage(),
                'from' => $posts->firstItem(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'to' => $posts->lastItem(),
                'total' => $posts->total(),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['author_id'] = auth()->user()->id;
        $newPost = post::query()->create($data);
        return message::success(PostResource::make($newPost), '', 'post created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $post = post::query()->with('author')->find($id);
        if (!$post) {
            return message::error('post not found', 403);

        }
        return message::success(PostResource::make($post), '', 'post details');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {


        $post = post::query()->find($id);

        if (!$post) {
            return message::error('Post not found', 403);
        }

        if (auth()->user()->id !== $post->author_id) {
            return message::error('You are not authorized to update this post', 403);
        }

        $dataValidated = $request->validated();
        $post->update($dataValidated);

        return message::success(PostResource::make($post), '', 'Post updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = post::query()->find($id);
        if (!$post) {
            return message::error('Post not found', 403);


        }
        if (auth()->user()->id !== $post->author_id) {
            return message::error('You are not authorized to delete this post', 403);


        }
        $post->delete();
        return message::success('', '', 'Post deleted successfully');

    }

    public function search(Request $request)
    {
        $post = post::query();


        if ($request->filled('title')) {
            $post->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->filled('category')) {
            $post->where('category', 'like', '%' . $request->input('category') . '%');
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $post->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }
        $posts = $post->get();

        return message::success(PostResource::make($posts), '', 'Posts retrieved successfully');
    }



}
