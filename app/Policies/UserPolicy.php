<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     * 这里是用户授权策略类
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 更新策略，操作用户必须与当前用户相同
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }

    /**
     * 删除策略，必须是管理员且操作用户，且当前操作用户与呗操作用户不同
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function destroy(User $currentUser,User $user){
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
