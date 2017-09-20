<?php

namespace app\admin\controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use think\Config;
use think\Log;
use app\admin\model\UserInfo;

class Admin extends BaseController {

    public function add() {
        $user = new UserInfo();
        $user->user_id = $this->guid();
        $user->save($this->request->post());
    }

    public function get(){        
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
