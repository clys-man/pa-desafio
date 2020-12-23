<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessage;
use App\Api\Format;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private $user;
    private $paginate = 30;

    public function __construct(User $user){
        $this->user = $user;

        $this->middleware('client');
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->user->paginate($this->paginate));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->user->with('posts')->find($id);
        if(!$user) return response()->json(ApiMessage::display("404 Not Found", 404), 404);

        return response()->json(Format::userArr($user->first()));
    }
}
