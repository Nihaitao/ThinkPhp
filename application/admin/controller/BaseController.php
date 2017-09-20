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
}
