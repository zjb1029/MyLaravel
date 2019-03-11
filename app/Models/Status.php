<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    /**
     * The attributes that are mass assignable.
     * 只有在这个数组内的字段才会被更新
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    /**
     * 定义逆一对一或多关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

}
