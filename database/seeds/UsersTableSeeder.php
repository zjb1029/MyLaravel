<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 运行用户工厂类并传入用户类得到一个用户类的关联数组
     * 生成50个随机用户填充到数据库中（makeVisible方法:临时显示加密的字段）
     * 并修改第一个ID为1的用户的名称邮箱密码和管理员字段
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
        $user = User::find(1);
        $user->name = 'Aufree';
        $user->email = 'aufree@yousails.com';
        $user->password = bcrypt('password');
        $user->is_admin = 1;
        $user->activated = true;
        $user->save();
    }
}
