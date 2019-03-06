<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request){
    	$this->validate($request, [
    		'title' => 'required',
    		'body'  => 'required',
    	]);

    	$post = $request->user()->posts()->create([
    		'title' => $request->json('title'),
    		'slug'  => str_slug($request->json('title')),
    		'body'  => $request->json('body'),
    	]);

    	return $post;
    }

    public function index(){
    	return Post::all();
    }
    
    public function show($id){
    	$post = Post::find($id);
    	if (!$post) {
    		return response()->json(['error' => 'id post tidak ditemukan'], 404);
    	}
    	return $post;
    }
    
    public function update(Request $request, $id){
    	$this->validate($request, [
    		'title' => 'required',
    		'body'  => 'required',
    	]);
    	
    	$post = Post::find($id);
    	if ($post->user_id != $request->user()->id) {
    		return response()->json(['error' => 'Tidak di ijinkan mengedit post ini !'], 403);
    	}
    	$post->title = $request->json('title');
    	$post->title = str_slug($request->json('title'));
    	$post->body  = $request->json('body');
    	$post->save();
    	return $post;
    }

    public function destroy(Request $request, $id){
    	$post = Post::find($id);
    	if ($post->user_id != $request->user()->id) {
    		return response()->json(['error' => 'Tidak di ijinkan menghapus post ini !'], 403);
    	}
    	$post->delete();
    	return response()->json([
    		'success' => true, 
    		'message' => 'Post berhasil di hapus'], 200);
    }
    
    
}
