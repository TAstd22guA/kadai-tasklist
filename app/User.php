<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks(){
    return $this -> hasMany('App\Task');
    }
    
    
       /**
     * このユーザに関係するモデルの件数をロードする。
     * 'favorites'を追加する。
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount(['tasks', 'followings', 'followers','favorites']);
    }
    
    
    /**
     * favoritesのリレーションを設定する。
     */
     public function favorites()
    {
        return $this->belongsToMany(Task::class, 'favorites', 'user_id', 'task_id')->withTimestamps();
    }

    public function favorite($taskId)
    {
        $exist = $this->is_favorite($taskId);

        if($exist){
            return false;
        }else{
            $this->favorites()->attach($taskId);
            return true;
        }
    }

    public function unfavorite($taskId)
    {
        $exist = $this->is_favorite($taskId);

        if($exist){
            $this->favorites()->detach($taskId);
            return true;
        }else{
            return false;
        }
    }

    public function is_favorite($taskId)
    {
        return $this->favorites()->where('task_id',$taskId)->exists();
    }
    
}
