<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\RestPassword;
use App\Models\Status;
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     * 只有在这个数组内的字段才会被更新
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 当我们需要对用户密码或其它敏感信息在用户实例通过数组或 JSON 显示时进行隐藏
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * boot方法会在用户模型类完成初始化之后进行加载
     */
    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        /*
         * creating用于监听模型被创建之后的事件
         */
        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    /**
     * 获取微博数据，根据created_at倒叙
     */
    public function feed(){
        return $this->statuses()->orderBy('created_at', 'desc');
    }

    /**
     * 定义与status的一对多关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    /**
     * 关注
     * @param $user_ids
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注
     * @param $user_ids
     */
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    /**
     * 是否关注
     * @param $user_id
     * @return mixed
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }

    /**
     * 定义与User的多对多关系
     * 关联表:followers
     * 主键：user_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * 定义与User的多对多关系
     * 关联表：followers
     * 主键：follower_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }


}
