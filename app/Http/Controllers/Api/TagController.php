<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessage;
use App\Api\Format;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    private $tag;
    private $paginate = 30;

    public function __construct(Tag $tag){
        $this->tag = $tag;

        $this->middleware('client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tags = $this->tag->paginate($this->paginate);

        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function store(TagRequest $request): JsonResponse
    {
        try {
            $tagData = $request->all();
            $this->tag->create([
                'title'=> $tagData['title'],
                'description'=> $tagData['description']
            ]);

            return response()->json(ApiMessage::display("Objeto criado com sucesso", 201), 201);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 1010), 500);
            }
            return response()->json(ApiMessage::display("500 Internal Server Error", 500));
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
        $tag = $this->tag->with('posts')->find($id);
        if(!$tag) return response()->json(ApiMessage::display("404 Not Found", 404), 404);

        $data = Format::tagArr($tag);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(TagRequest $request, $id): JsonResponse
    {
        try {
            $tagData = $request->all();
            $tag = $this->tag->find($id);
            $tag->update([
                'title'=> $tagData['title'],
                'description'=> $tagData['description']
            ]);

            return response()->json(ApiMessage::display("Objeto atualizado com sucesso", 200), 200);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 1020), 500);
            }
            return response()->json(ApiMessage::display("Houve um erro ao efetuar a ação", 1020));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $tag = $this->tag->find($id);

        if(!$tag) return response()->json(ApiMessage::display("404 Not Found", 404), 404);

        try {
            $tag->delete();
            return response()->json(ApiMessage::display("204 No Content", 204), 204);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiMessage::display($e->getMessage(), 1030), 500);
            }
            return response()->json(ApiMessage::display("Houve um erro ao efetuar a ação", 1030));
        }
    }
}
