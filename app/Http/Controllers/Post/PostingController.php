<?php

namespace App\Http\Controllers\Post;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostingRequest;

class PostingController extends Controller
{

    public function showPost()
    {
        $post = Post::with('user')->latest()->get();

        // dd($post);
       
        return response([
            'posts'=>$post
        ],200);

    }

    public function insert(PostingRequest $req)
    {
        $req->validated();

        // auth()->user()->posts()->create([
        //     'content'=>$req->content
        // ]);

        $post = [
            'content' => $req->content,
            'user_id' => auth()->user()->id
        ];

        Post::create($post);

        return response([
            'message' => 'success'
        ], 201);
    }

    public function likePost($postId)
    {
        //1. check whether the post is exist
        $post = Post::whereId($postId)->first();
        if (!$post) {
            return response([
                'message' => '404 Not Found'
            ], 500);
        }
        //2. Like & Unlike Function
        $user_id = auth()->user()->id;

        //unlike
        if (Like::where('user_id', $user_id)->where('post_id', $post->id)->exists() == true) {
            Like::where('user_id', $user_id)->where('post_id', $post->id)->delete();

            return response([
                'message' => 'Unliked'
            ], 201);
        } else {
            Like::create([
                'post_id' => $post->id,
                'user_id' => $user_id,
            ]);

            return response([
                'message' => 'Liked'
            ], 201);
        }
    }

    public function commentPost(Request $req , $post_id)
    {
        $req->validate([
            'comment'=>'required|string'
        ]);

        $post= Post::where('id',$post_id)->first();

        if(!$post)
        {
            return response([
                'message' => '404 Not Found'
            ], 500);
        }

        $comm = Comment::create([
            'user_id'=>auth()->user()->id,
            'post_id'=> $post->id,
            'comment'=>$req->comment
        ]);

        return response([
            'message'=>'Commented !'
        ],200);
    }

    public function getComment($post_id)
    {
        $comm = Comment::with('post')->with('user')->where('post_id', $post_id)->latest()->get();
        
        return response([
            'comment'=>$comm
        ],200);
    }
}
