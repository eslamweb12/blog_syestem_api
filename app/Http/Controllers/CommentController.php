<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\comment;
use App\Models\post;
use App\service\message;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   public function StoreComment(CommentRequest $request,string $id){
       $post=post::query()->find($id);
       if(!$post){
           return message::error('post not found',401);

       }
       $data=$request->validated();
       $data['post_id']=$id;
       $data['user_id']=auth()->user()->id;
       $comment=comment::create($data);
       return message::success('comment created successfully',201);


   }
}
