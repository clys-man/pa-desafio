<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessage;
use App\Api\Format;
use App\Api\Validate;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $post;
    private $paginate = 30;

    public function __construct(Post $post){
        $this->post = $post;

        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
        $this->middleware('client');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if($request->tag){
            $tag = Tag::where('title', $request->tag)->with('posts')->first();
            if(!$tag){
                return response()->json(ApiMessage::display("404 Not Found", 404), 404);
            }
            $data = collect($tag->posts)->map(function($post) {
                return Format::postArr($post);
            });

            return response()->json($data);
        }
        $post = $this->post->with('author', 'tags')->paginate($this->paginate);

        $data = collect($post->all())->map(function($post) {return Format::postArr($post);});
        return response()->json(Format::responseArr($post, $data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        try {
            $postData = $request->all();

            $post = $this->post->create([
                "user_id" => $request->user()->id,
                "title" => $postData["title"],
                "content" => $postData["content"],
                "tag" => $postData["tags"],
            ]);
            $post->tags()->sync($request->tags);

            return response()->json(ApiMessage::display("Objeto criado com sucesso", 201), 201);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 1010), 500);
            }
            return response()->json(ApiMessage::display("Houve um erro ao efetuar a ação", 1020));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $post = $this->post->with('author', 'tags')->find($id);

        if(!$post) return response()->json(ApiMessage::display("404 Not Found", 404), 404);

        return response()->json(Format::postArr($post));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PostRequest $request, int $id): JsonResponse
    {
        try {
            $postData = $request->all();
            $post = $this->post->with('author')->find($id);

            if(!$post) return response()->json(ApiMessage::display("404 Not Found", 404), 404);

            if(!Validate::equals($request->user()->id, $post->author->id)) {
                return response()->json(ApiMessage::display("403 Forbidden", 403), 403);
            }

            $postData->user_id = $request->user()->id;
            $post->update($postData);
            $post->tags()->sync($request->tags);

            return response()->json(ApiMessage::display("Objeto atualizado com sucesso", 200), 200);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 1020), 500);
            }
            return response()->json(ApiMessage::display("Houve um erro ao efetuar a ação de atualizar", 1020));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $post = $this->post->find($id);

        if(!$post) return response()->json(ApiMessage::display("404 Not Found", 404), 404);

        if(!Validate::equals($request->user()->id, $post->author->id)) {
            return response()->json(ApiMessage::display("403 Forbidden", 403), 403);
        }

        try {
            $post->delete();
            return response()->json(ApiMessage::display("204 No Content", 204), 204);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 500), 500);
            }
            return response()->json(ApiMessage::display("Houve um erro ao efetuar a ação", 500));

        }
    }
}
