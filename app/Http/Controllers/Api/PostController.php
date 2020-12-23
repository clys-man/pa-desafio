<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiError;
use App\Api\Format;
use App\Api\Validate;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if($request->tag){
            $tag = Tag::where('title', $request->tag)->with('posts')->first();
            if(!$tag){
                return response()->json(["data" =>["msg" => "Tag não encontrada"]]);
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
     * @param  App\Http\Requests\PostStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        try {
            $postData = $request->all();
            $postData->user_id = $request->user()->id;

            $post = $this->post->create($postData);
            $post->tags()->sync($request->tags);

            $return = ['data' => ['msg' => 'Post criado com sucesso!']];

            return response()->json($return, 201);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010), 500);
            }
            return response()->json(ApiError::errorMessage("Houve um erro na operação de adicionar", 1010));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($request,$id)
    {
        $post = $this->post->with('author', 'tags')->find($id);

        if(!$post) return response()->json(['data' =>['msg' => 'Post não encontrado']], 404);

        return response()->json(Format::postArr($post));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, $id)
    {
        try {
            $postData = $request->all();
            $post = $this->post->find($id);

            if(!$post) return response()->json(['data' =>['msg' => 'Post não encontrado']], 404);

            $post->update($postData);
            $post->tags()->sync($request->tags);

            $return = ['data' => ['msg' => 'Post atualizado com sucesso!']];

            return response()->json($return, 201);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1020), 500);
            }
            return response()->json(ApiError::errorMessage("Houve um erro na operação de atualizar", 1020));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $post = $this->post->find($id);

        if(!$post) return response()->json(['data' =>['msg' => 'Post não encontrado']], 404);

        try {
            $post->delete();
            return response()->json(['data' => ['msg' => 'Post '. $post->title . ' deletado com sucesso']], 200);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1030), 500);
            }
            return response()->json(ApiError::errorMessage("Houve um erro na operação de remover", 1030));

        }
    }
}
