<?php

namespace app\admin\controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use think\Config;
use think\Log;
use app\admin\model\User;

class Admin extends BaseController {

    public function add() {
        $data = $this->request->post();
        $User = new User();
        $result = $User->allowField(['headimg', 'age', 'constellation', 'nickname', 'autograph'])->save($data, ['user_id' => $data["user_id"]]);
        if (false === $result) {
            return json(["result" => $result, "message" => $User->getError(), "data" => null]);
        } else {
            return json(["result" => $result > 0, "message" => "修改成功", "data" => null]);
        }
        
        
        
//        $data = $this->request->post();
//        $User = new User();
//        $User->user_id = $this->guid();
//        $result = $User->validate([
//                    'user_name' => 'require|max:18',
//                    'password' => 'require|min:6|max:32',
//                        ], [
//                    'user_name.require' => '名称不能为空',
//                    'user_name.max' => '名称最多不能超过18个字符',
//                    'password.require' => '密码不能低于6个字符',
//                    'password.min' => '密码不能低于6个字符',
//                    'password.max' => '密码不能超过32个字符',
//                ])->save($data);
//        if (false === $result) {
//            // 验证失败 输出错误信息
//            return json(["result" => $result, "message" => $User->getError(), "data" => null]);
//        } else {
//            return json(["result" => $result > 0, "message" => "操作成功", "data" => null]);
//        }
    }

    public function get() {
        $data = $this->request->get();
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
                return json(["result" => false, "message" => "用户不存在", "data" => null]);
            } else {
                return json(["result" => true, "message" => "登陆成功", "data" => $User->toJson()]);
            }
        }
//        // 查询单个数据
//        $data = $user->where('user_name', 'nihaitao')
//                ->find();        
//        $user2 = UserInfo::get(['user_name' => 'nihaitao']);
//        
//       dump($data->nickname);
//       dump($user2->toJson());
    }

    public function GetConfig() {

        $my_database = Config::get('database');
        return json(['database' => $my_database]);
    }

    public function MyGet() {
        $name = $_GET['name'];
        $name1 = $this->request->get('name1');
        dump($name);
        dump($name1);
    }

    public function MyPost() {
        $name = $this->request->post('name');
        return json(['name' => $name]);
    }

    public function MyPostAndGet() {
        $name = $this->request->post("name");
        $name1 = $this->request->get("name");
        return json(['post_name' => $name,
            'get_name' => $name1]);
    }

    public function DoFile() {
        //dump($_FILES);    
        $file = $this->request->file("myFile");
        $new_file = $file->move("./static/upload");
        dump($file);
        dump($new_file);
        return json(["file" => $file,
            'new_file' => $new_file]);
    }

    public function MyLog() {
        Log::info("这是自定义信息");
        Log::error("这是错误信息");
    }

    public function miss() {
        $response = new \think\Response();
        return $response->code(404)->data("没有找到页面");
    }

    public function str() {

        echo mb_strlen("中文字符", 'utf-8'), "<br>", strlen("中文字符");
    }

    function guid() {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
        return $uuid;
    }

}
