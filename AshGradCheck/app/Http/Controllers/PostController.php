<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        
        // $posts = Post::get();
        //Pagination

        $posts = Post::paginate(3);


        return view('posts.index', [
            'posts'=> $posts
        ]);
    }
    public function store(Request $Request){
        $this->validate($Request, [
            'body' => 'required'
        ]);
        // Post::create{[
        //     // passing in the user id to ascertain which user made the post
        //     'user_id' => auth()->id(),
        //     'body'=> $Request->body
        // ]};
        
        //Making a post
        $Request->user()->posts()->create([
            'body' => $Request->body
        ]);
        return back();
    
    }

}
