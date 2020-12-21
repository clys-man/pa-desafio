<?php

namespace App\Http\Controllers\Api;

use App\Api\Format;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    private $user;
    private $paginate = 30;

    public function __construct(User $user){
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->user->paginate($this->paginate));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->user->find($id)->with('posts')->first();

        if(!$user) return response()->json(['data' =>['msg' => 'Usuario não encontrado']], 404);

        $data = Format::userArr($user);

        return response()->json($data);
    }

}
