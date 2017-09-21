<?php

namespace app\admin\controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\admin\model\User;

class UserInfo extends BaseController {

    /**
     * 用户注册
     * @rest post
     * @access public
     * @return {"result":true|false,"message":string,"data":[]}
     */
    public function register() {
        $data = $this->request->post();
        $User = new User();
        $User->user_id = $this->guid();
        $result = $User->validate([
                    'user_name' => 'require|max:18',
                    'password' => 'require|min:6|max:32',
                        ], [
                    'user_name.require' => '名称不能为空',
                    'user_name.max' => '名称最多不能超过18个字符',
                    'password.require' => '密码不能低于6个字符',
                    'password.min' => '密码不能低于6个字符',
                    'password.max' => '密码不能超过32个字符',
                ])->save($data);
        if (false === $result) {
            return json(["result" => false, "message" => $User->getError(), "data" => null]);
        } else {
            return json(["result" => true, "message" => "注册成功", "data" => null]);
        }
    }

    /**
     * 用户登陆
     * @rest post
     * @access public
     * @return {"result":true|false,"message":string,"data":[]}
     */
    public function login() {
        $data = $this->request->post();
        $result = $this->validate($data, [
            'user_name' => 'require',
            'password' => 'require',
                ], [
            'user_name.require' => '名称不能为空',
            'password.require' => '密码不能为空',
        ]);
        if (true !== $result) {
            return json(["result" => false, "message" => $result, "data" => null]);
        } else {
            $User = User::get($data);
            if (is_null($User)) {
                return json(["result" => false, "message" => "用户名或密码错误", "data" => null]);
            } else {
                return json(["result" => true, "message" => "登陆成功", "data" => $User->toJson()]);
            }
        }
    }

    /**
     * 用户名是否存在
     * @rest get
     * @access public
     * @return {"result":true|false,"message":string,"data":[]}
     */
    public function existname() {
        $data = $this->request->get();
        $result = $this->validate($data, [
            'user_name' => 'require|max:18',
                ], [
            'user_name.require' => '名称不能为空',
            'user_name.max' => '名称最多不能超过18个字符',
        ]);
        if (true !== $result) {
            return json(["result" => false, "message" => $result, "data" => null]);
        } else {
            $User = User::get($data);
            if (is_null($User)) {
                return json(["result" => true, "message" => "可以使用", "data" => null]);
            } else {
                return json(["result" => false, "message" => "用户名已存在", "data" => null]);
            }
        }
    }

    /**
     * 更改用户信息（头像，年龄，星座，昵称，个性签名）
     * @rest post
     * @access public
     * @return {"result":true|false,"message":string,"data":[]}
     */
    public function update() {
        $data = $this->request->post();
        $User = new User();
        $result = $User->allowField(['headimg', 'age', 'constellation', 'nickname', 'autograph'])->save($data, ['user_id' => $data["user_id"]]);
        if (false === $result) {
            return json(["result" => false, "message" => $User->getError(), "data" => null]);
        } else {
            return json(["result" => true, "message" => "修改成功", "data" => null]);
        }
    }

    /**
     * 绑定/解绑手机
     * @rest post
     * @access public
     * @return {"result":true|false,"message":string,"data":[]}
     */
    public function phone() {
        //TODO...
    }

    /**
     * 修改密码
     * @rest post
     * @access public
     * @return {"result":true|false,"message":string,"data":[]}
     */
    public function password() {
        $data = $this->request->post();
        $result = $this->validate($data, ['newpwd' => 'require|min:6|max:32',], ['newpwd.require' => '新密码不能低于6个字符', 'newpwd.min' => '新密码不能低于6个字符', 'newpwd.max' => '新密码不能超过32个字符',]);
        if (true !== $result) {
            return json(["result" => false, "message" => $result, "data" => null]);
        } else {
            $User = User::get(['user_id' => $data["user_id"]]);
            if ($User->password !== $data["password"]) {
                return json(["result" => false, "message" => "原密码错误", "data" => null]);
            } else {
                $User->password = $data["newpwd"];
                $res = $User->save();
                if (false === $res) {
                    return json(["result" => false, "message" => $User->getError(), "data" => null]);
                } else {
                    return json(["result" => true, "message" => "修改成功", "data" => null]);
                }
            }
        }
    }

}
