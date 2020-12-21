<?php

namespace App\Api;

use App\Post;

class Format{
    public static function postArr($post){
        return [
            "id" => $post->id,
            "title" => $post->title,
            "author" => $post->author->name,
            "content" => $post->content,
            "tag" => collect($post->tags)->map(function($item) {
                return $item->title;
            }),
            "created_at" => $post->created_at,
            "updated_at" => $post->updated_at
        ];
    }
    public static function responseArr($paginate, $data){
        return [
            "current_page" => $paginate->currentPage(),
            "data" => $data,
            "last_page" => $paginate->lastPage(),
            "path" => $paginate->path(),
            "total" => $paginate->total(),
            "per_page" => $paginate->perPage(),
            "prev_page_url" => $paginate->previousPageUrl(),
            "next_page_url" => $paginate->nextPageUrl()
        ];
    }
    public static function tagArr($tag){
        return [
            "id" => $tag->id,
            "title" => $tag->title,
            "description" => $tag->description,
            "created_at" => $tag->created_at,
            "updated_at" => $tag->updated_at,
            "posts" => collect($tag->posts)->map(function($post) {
                return Format::postArr(Post::where('id', $post->id)->first());
            })
        ];
    }
    public static function userArr($user){
        return [
            "id" => $user->id,
            "title" => $user->title,
            "email" => $user->email,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at,
            "posts" => collect($user->posts)->map(function($post) {
                return Format::postArr($post);
            })
        ];
    }
}
