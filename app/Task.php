<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   public function user(){
    return$this->belongsTo('App\User');
    }

    /**
     * 追加 お気に入りの件数
     */
    public function favorite_users()
    {
            return $this->belongsToMany(User::class,'favorites','task_id','user_id')->withTimestamps();
    }

}
