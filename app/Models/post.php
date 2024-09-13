<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected  $fillable=['title','content','author_id','category'];
    public function author(){
        return $this->belongsTo(User::class);

    }
}
