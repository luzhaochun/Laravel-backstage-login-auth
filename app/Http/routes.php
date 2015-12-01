<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('login');
});
//登陆验证相关路由
Route::get('login', 'Backstage\LoginController@getLogin');
Route::post('login', 'Backstage\LoginController@postLogin');
Route::get('logout', 'Backstage\LoginController@getLogout'); 

/*
 * layout
 */
Route::get('main', ['middleware'=>'auth','uses'=>'Backstage\IndexController@main']);
//首页content
Route::get('index/index', ['middleware'=>'auth','uses'=>'Backstage\IndexController@index']);
//头部
Route::get('index/top', ['middleware'=>'auth','uses'=>'Backstage\IndexController@top']);
//左侧导航
Route::get('index/left',['middleware'=>'auth','uses'=>'Backstage\IndexController@left']);
//底部信息
Route::get('index/footer',['middleware'=>'auth','uses'=>'Backstage\IndexController@footer']);
/*
 *error|unauthorized
 */
Route::get('error', ['middleware'=>'auth','uses'=>'Backstage\ErrorController@errorPage']);
Route::get('unauthorize', ['middleware'=>'auth','uses'=>'Backstage\ErrorController@unauthorizPage']);

//提现申请
Route::match(['get','post'],'Apply/index', ['middleware'=>'auth','uses'=>'Backstage\Withdrawal\ApplyController@index']);
Route::get('Apply/show', ['middleware'=>'auth','uses'=>'Backstage\Withdrawal\ApplyController@show']);
Route::post('Apply/del', ['middleware'=>'auth','uses'=>'Backstage\Withdrawal\ApplyController@del']);
Route::post('Apply/cancel', ['middleware'=>'auth','uses'=>'Backstage\Withdrawal\ApplyController@cancel']);
Route::match(['get','post'],'Apply/completed', ['middleware'=>'auth','uses'=>'Backstage\Withdrawal\ApplyController@completed']);

//药店管理
Route::match(['get','post'],'Map/index', ['middleware'=>'auth','uses'=>'Backstage\Drugstore\MapController@index']);


/***************** 管理员管理模块 *****************/
Route::any('Admin/index', ['middleware'=>'auth','uses'=>'Backstage\Admin\AdminController@index']); // 管理员列表
Route::any('Admin/add', ['middleware'=>'auth','uses'=>'Backstage\Admin\AdminController@add']); 	   // 新增管理员
Route::any('Admin/edit', ['middleware'=>'auth','uses'=>'Backstage\Admin\AdminController@edit']);   // 编辑管理员
Route::post('Admin/delete', ['middleware'=>'auth','uses'=>'Backstage\Admin\AdminController@delete']);   // 删除管理员
Route::post('Admin/checkNameUnique', 'Backstage\Admin\AdminController@checkNameUnique');


/***************答题管理 start *********************/
Route::any('PaperRoll/index', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@index']); // 题卷列表
Route::any('PaperRoll/add', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@add']); // 新增题卷
Route::any('PaperRoll/edit', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@edit']); // 编辑题卷
Route::any('PaperRoll/check_paper', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@check_paper']); // 选择题库
Route::any('PaperRoll/del', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@del']); // 删除题卷
Route::any('PaperRoll/saveData', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@saveData']); // 保存固定题库题卷
Route::any('PaperRoll/searchCompany', ['middleware'=>'auth','uses'=>'Backstage\Question\PaperController@searchCompany']); // 搜索企业
/***************答题管理 end *******************/

/***************题库管理 start *******************/
Route::any('QuestionBank/index', ['middleware'=>'auth','uses'=>'Backstage\Question\QuestionController@index']); // 题库列表
Route::any('QuestionBank/add', ['middleware'=>'auth','uses'=>'Backstage\Question\QuestionController@add']); // 新增题库
Route::any('QuestionBank/edit', ['middleware'=>'auth','uses'=>'Backstage\Question\QuestionController@edit']); // 编辑题库
Route::any('QuestionBank/getMaterialList', ['middleware'=>'auth','uses'=>'Backstage\Question\QuestionController@getMaterialList']); // 获取文章列表
Route::any('QuestionBank/del', ['middleware'=>'auth','uses'=>'Backstage\Question\QuestionController@del']); // 删除题库
Route::any('QuestionBank/recovery', ['middleware'=>'auth','uses'=>'Backstage\Question\QuestionController@recovery']); // 恢复题库
/***************题库管理 end *******************/


/*
 * 系统管理模块
 */
Route::get('AuthGroup/menulist',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menulist']);//菜单列表
Route::any('AuthGroup/menuAdd',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menuAdd']);//新增菜单
Route::any('AuthGroup/menuEdit',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menuEdit']);//编辑信息
Route::any('AuthGroup/changemenustatus',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@changemenustatus']);//显示菜单状态
Route::get('AuthGroup/getmenuinfo',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@getmenuinfo']);//获取菜单信息
Route::any('AuthGroup/updatemenusort',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@updatemenusort']);//更改菜单排序
Route::any('AuthGroup/checkMenuModuleUnique',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@checkMenuModuleUnique']);//验证名称选项唯一性
Route::get('AuthGroup/menudel',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menudel']);//删除菜单

/*
 * 
 * 库存管理模块
 */
Route::get('StockManage/index',['middleware'=>'auth','uses'=>'Backstage\Stock\AdminController@index']);//成员列表
/***************答题管理 end *******************/



/***************** 获取token start ***************/
Route::any('Token/getQiniuToken', 'Backstage\TokenController@getQiniuToken'); // 编辑题卷
Route::any('Token/getQiniuImageName', 'Backstage\TokenController@getQiniuImageName'); // 编辑题卷
/***************** 获取token end ***************//***************答题管理 end *******************/

/*
 * 系统管理模块
 */
Route::get('AuthGroup/menulist',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menulist']);//菜单列表
Route::any('AuthGroup/menuAdd',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menuAdd']);//新增菜单
Route::any('AuthGroup/menuEdit',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menuEdit']);//编辑信息
Route::any('AuthGroup/changemenustatus',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@changemenustatus']);//显示菜单状态
Route::get('AuthGroup/getmenuinfo',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@getmenuinfo']);//获取菜单信息
Route::any('AuthGroup/updatemenusort',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@updatemenusort']);//更改菜单排序
Route::any('AuthGroup/checkMenuModuleUnique',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@checkMenuModuleUnique']);//验证名称选项唯一性
Route::any('AuthGroup/menuDel',['middleware'=>'auth','uses'=>'Backstage\Auth\AuthController@menuDel']);//删除菜单

/*
 * 地区管理模块
 */
Route::get('Area/index',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@index']);//地区列表
Route::any('Area/add',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@add']);//新增地区
Route::any('Area/edit',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@edit']);//编辑地区
Route::get('Area/del',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@del']);//删除地区
Route::get('Area/checkZoneNumberUnique',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@checkZoneNumberUnique']);//验证电话区号唯一
Route::get('Area/checkCodeUnique',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@checkCodeUnique']);//验证地区码唯一
Route::get('Area/checkNameUnique',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@checkNameUnique']);//验证地区名唯一
Route::get('Area/getAreaInfo',['middleware'=>'auth','uses'=>'Backstage\Auth\AreaController@getAreaInfo']);//获取地区信息

/*
 * 角色管理模块
 */
Route::get('AuthGroup/index',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@index']);//角色列表
Route::any('AuthGroup/edit',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@edit']);//编辑角色 
Route::any('AuthGroup/memberlist',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@memberlist']);//成员列表
Route::any('AuthGroup/rulelist',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@rulelist']);//权限列表
Route::any('AuthGroup/changestatus',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@changeStatus']);//更新角色状态 
Route::any('AuthGroup/checkRoleNameUnique',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@checkRoleNameUnique']);//验证角色唯一性
Route::any('AuthGroup/delete',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@delete']);//删除角色
Route::any('AuthGroup/add',['middleware'=>'auth','uses'=>'Backstage\Auth\RoleController@add']);//新增角色



/*
 * 系统管理 登录日志操作日志
 */
Route::any('SystemLogs/loginList', ['middleware'=>'auth','uses'=>'Backstage\SystemLog\SystemLogsController@loginList']);   // 登录日志
Route::any('SystemLogs/operateList', ['middleware'=>'auth','uses'=>'Backstage\SystemLog\SystemLogsController@operateList']); // 操作日志
/*
 * 
 *
 * 库存管理模块
 * 人员管理
 */
Route::get('StockManage/index',['middleware'=>'auth','uses'=>'Backstage\Stock\AdminController@index']);//成员列表
Route::any('StockManage/addAdmin',['middleware'=>'auth','uses'=>'Backstage\Stock\AdminController@add']);//新增成员
Route::any('StockManage/editAdmin',['middleware'=>'auth','uses'=>'Backstage\Stock\AdminController@edit']);//编辑成员
Route::any('StockManage/checkAdminExist',['middleware'=>'auth','uses'=>'Backstage\Stock\AdminController@checkAdminExist']);//检查库存用户唯一性
Route::any('StockManage/delAdmin',['middleware'=>'auth','uses'=>'Backstage\Stock\AdminController@delAdmin']);//删除成员

 /*
 *报损管理 
 */
Route::get('StockManage/damageIndex',['middleware'=>'auth','uses'=>'Backstage\Stock\DamageController@damageIndex']);//报损列表
Route::any('StockManage/damageAdd',['middleware'=>'auth','uses'=>'Backstage\Stock\DamageController@damageAdd']);//新增报损
Route::any('StockManage/damageDel',['middleware'=>'auth','uses'=>'Backstage\Stock\DamageController@damageDel']);//删除报损
Route::any('StockManage/damageEdit',['middleware'=>'auth','uses'=>'Backstage\Stock\DamageController@damageEdit']);//编辑报损

/*
 * 货位管理
 */
Route::get('StockManage/shelfIndex',['middleware'=>'auth','uses'=>'Backstage\Stock\ShelfController@shelfIndex']);//货位管理
Route::any('StockManage/shelfAdd',['middleware'=>'auth','uses'=>'Backstage\Stock\ShelfController@shelfAdd']);//新增货位
Route::any('StockManage/checkShelfNoExist',['middleware'=>'auth','uses'=>'Backstage\Stock\ShelfController@checkShelfNoExist']);//货位编码是否存在
Route::any('StockManage/shelfEdit',['middleware'=>'auth','uses'=>'Backstage\Stock\ShelfController@shelfEdit']);//编辑货位
Route::any('StockManage/shelfDel',['middleware'=>'auth','uses'=>'Backstage\Stock\ShelfController@shelfDel']);//删除货位

/*
 * 出库管理
 */
Route::get('StockShipment/index',['middleware'=>'auth','uses'=>'Backstage\Stock\ShipmentManageController@index']);//列表
Route::get('StockShipment/show',['middleware'=>'auth','uses'=>'Backstage\Stock\ShipmentManageController@show']);//列表内容详细
Route::get('StockShipment/product_list',['middleware'=>'auth','uses'=>'Backstage\Stock\ShipmentManageController@productList']);//出库产品列表
Route::any('StockShipment/remark',['middleware'=>'auth','uses'=>'Backstage\Stock\ShipmentManageController@remark']);//备注
Route::get('StockShipment/search',['middleware'=>'auth','uses'=>'Backstage\Stock\ShipmentManageController@search']);//查询

/*
 * 产品管理
 */
Route::get('Product/index',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@index']); // 产品列表
Route::any('Product/add',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@add']);     // 新增产品
Route::get('Product/view',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@view']);   // 查看产品
Route::any('Product/edit',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@edit']);   // 编辑产品
Route::post('Product/del',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@delete']); // 删除产品
Route::post('Product/checkNameUnique',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@checkNameUnique']); // 检查产品名称唯一性

Route::any('Product/uploadImg',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@uploadImg']); // 上传图片
Route::any('Product/delImg',['middleware'=>'auth','uses'=>'Backstage\Product\ProductController@delImg']);       // 删除图片

/*
 * 地推端模块
 */
Route::get('Pushuser/index',['middleware'=>'auth','uses'=>'Backstage\Push\UserController@index']);//用户列表
Route::any('Pushuser/add',['middleware'=>'auth','uses'=>'Backstage\Push\UserController@add']);//新增用户
Route::any('Pushuser/ajax_check',['middleware'=>'auth','uses'=>'Backstage\Push\UserController@checkUser']);//检测登陆ID 唯一
Route::any('Pushuser/del',['middleware'=>'auth','uses'=>'Backstage\Push\UserController@delete']);//删除用户
Route::any('Pushuser/edit',['middleware'=>'auth','uses'=>'Backstage\Push\UserController@edit']);//修改用户信息
Route::get('Task/index',['middleware'=>'auth','uses'=>'Backstage\Push\TaskController@index']);//任务列表
Route::get('Pharmacy/index',['middleware'=>'auth','uses'=>'Backstage\Push\PharmacyController@index']);//药房列表
