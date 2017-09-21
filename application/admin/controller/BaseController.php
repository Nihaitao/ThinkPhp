<?php
namespace app\admin\controller;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use think\Controller;
use think\Log;
class BaseController extends Controller
{
    public function _initialize() {
        Log::key($this->request->controller()."/".$this->request->action());
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
