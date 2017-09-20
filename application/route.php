<?php

use think\Route;
Route::group("admin",function(){    
    Route::get("log","mylog");
    Route::get("config","getconfig");
    Route::get("str","str");
    Route::get("add","add");
    //Route::miss("Admin/miss");
});