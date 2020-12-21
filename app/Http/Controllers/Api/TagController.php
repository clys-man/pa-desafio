<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiError;
use App\Api\Format;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Tag;

class TagController extends Controller
{
    private $tag;
    private $paginate = 30;

    public function __construct(Tag $tag){
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tags = $this->tag->paginate($this->paginate);

        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagRequest $request)
    {
        try {
            $tagData = $request->all();
            $this->tag->create($tagData);

            $return = ['data' => ['msg' => 'Tag adicionado com sucesso!']];

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
    public function show($id)
    {
        $tag = $this->tag->with('posts')->find($id);
        if(!$tag) return response()->json(['data' =>['msg' => 'Tag não encontrada']], 404);

        $data = Format::tagArr($tag);
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TagRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TagRequest $request, $id)
    {
        try {
            $tagData = $request->all();
            $tag = $this->tag->find($id);
            $tag->update($tagData);

            $return = ['data' => ['msg' => 'Tag atualizada com sucesso!']];

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
        $tag = $this->tag->find($id);

        if(!$tag) return response()->json(['data' =>['msg' => 'Produto não encontrado']], 404);

        try {
            $tag->delete();
            return response()->json(['data' => ['msg' => 'Tag '. $tag->title . ' deletada com sucesso']], 200);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1030), 500);
            }
            return response()->json(ApiError::errorMessage("Houve um erro na operação de remover", 1030));
        }
    }
}
