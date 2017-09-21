<?php

use think\Route;
Route::group("admin",function(){    
    Route::get("register","Userinfo/register");
    Route::get("login","Userinfo/login");
    Route::get("existname","Userinfo/existname");
    Route::get("update","Userinfo/update");
    Route::get("phone","Userinfo/phone");
    Route::get("password","Userinfo/password");
    Route::miss("Admin/miss");
});