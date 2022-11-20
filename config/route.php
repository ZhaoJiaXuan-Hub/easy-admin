<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

Route::group('/system', function () {
    Route::any("/editConfigs",[app\system\controller\SystemController::class,'editConfigs']);
    Route::any("/getConfigs",[app\system\controller\SystemController::class,'getConfigs']);
    Route::group('/account', function () {
        Route::any("/getAccount",[app\system\controller\AccountController::class,'getAccount']);
        Route::any("/editPass",[app\system\controller\AccountController::class,'editPass']);
        Route::any("/page",[app\system\controller\AccountController::class,'page']);
        Route::any("/add",[app\system\controller\AccountController::class,'add']);
        Route::any("/batch",[app\system\controller\AccountController::class,'batch']);
        Route::any("/edit",[app\system\controller\AccountController::class,'edit']);
        Route::any("/existence",[app\system\controller\AccountController::class,'existence']);
        Route::any("/password",[app\system\controller\AccountController::class,'password']);
        Route::any("/del",[app\system\controller\AccountController::class,'del']);
        Route::any("/status",[app\system\controller\AccountController::class,'status']);
    });
    Route::group('/account/auth', function () {
        Route::any("/login",[app\system\controller\AccountAuthController::class,'login']);
        Route::any("/captcha",[app\system\controller\AccountAuthController::class,'captcha']);
    });
    Route::group('/role', function () {
        Route::any("/pageRoles",[app\system\controller\RoleController::class,'pageRoles']);
        Route::any("/add",[app\system\controller\RoleController::class,'add']);
        Route::any("/edit",[app\system\controller\RoleController::class,'edit']);
        Route::any("/del",[app\system\controller\RoleController::class,'del']);
        Route::any("/batch",[app\system\controller\RoleController::class,'batch']);
        Route::any("/getList",[app\system\controller\RoleController::class,'getList']);
    });
    Route::group('/router', function () {
        Route::any("/add",[app\system\controller\RouterController::class,'add']);
        Route::any("/edit",[app\system\controller\RouterController::class,'edit']);
        Route::any("/del",[app\system\controller\RouterController::class,'del']);
        Route::any("/menuList",[app\system\controller\RouterController::class,'menuList']);
    });
    Route::group('/roleRouters', function () {
        Route::any("/listRouters",[app\system\controller\RoleRoutersController::class,'listRouters']);
        Route::any("/updateRoleMenus",[app\system\controller\RoleRoutersController::class,'updateRoleMenus']);
    });
    Route::group('/loginLog', function () {
        Route::any("/page",[app\system\controller\LoginLogController::class,'page']);
        Route::any("/getList",[app\system\controller\LoginLogController::class,'getList']);
    });
    Route::group('/order', function () {
        Route::any("/page",[app\system\controller\OrderController::class,'page']);
        Route::any("/edit",[app\system\controller\OrderController::class,'edit']);
        Route::any("/del",[app\system\controller\OrderController::class,'del']);
        Route::any("/batch",[app\system\controller\OrderController::class,'batch']);
    });
    Route::group('/plugins', function () {
        Route::any("/list",[app\system\controller\PluginsController::class,'getList']);
        Route::any("/status",[app\system\controller\PluginsController::class,'status']);
        Route::any("/getInputList",[app\system\controller\PluginsController::class,'getInputList']);
        Route::any("/editData",[app\system\controller\PluginsController::class,'editData']);
    });
});
Route::group('/api', function () {
    Route::group('/v1', function () {
        Route::any("/create",[app\api\controller\v1\IndexController::class,'create']);
        Route::any("/getPayTypes",[app\api\controller\v1\IndexController::class,'getPayTypes']);
        Route::any("/pay",[app\api\controller\v1\IndexController::class,'pay']);
        Route::any("/notify",[app\api\controller\v1\IndexController::class,'notify']);
    });
});

Route::disableDefaultRoute();
