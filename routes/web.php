<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::group(['prefix' => '/', 'middleware' => 'auth'], function() {

	//tạo request:get
	Route::get('create-request',['as'=>'create.getRequest','uses'=>'TicketController@getCreate']);
	//tạo request:post
	Route::post('create-request',['as'=>'create.postRequest','uses'=>'TicketController@postCreate']);
	//menu
	Route::get('list-request/{big}/{small}', ['as' => 'listRequest', 'uses' => 'TicketController@getListRequest']);
	//xem chi tiết ticket
	Route::get('info-edit-request/{id}', ['as' => 'getInfoEditRequest', 'uses' => 'TicketThreadController@getInfoEditRequest']) -> where(['id' => '[0-9]+']);
	
	// ajax đăng comment//
	//Cmt thường
	Route::post('cmt1', ['as' => 'postCmt1', 'uses' => 'TicketThreadController@postCmt1']);
	//Ẩn cmt với các đối tượng ko đc phép
	Route::post('cmt2', ['as' => 'postCmt2', 'uses' => 'TicketThreadController@postCmt2']);
	//Bắt buộc cmt ở trạng thái feedback hoặc closed
	Route::post('cmt3', ['as' => 'postCmt3', 'uses' => 'TicketThreadController@postCmt3']);
	// ajax thay thế các nút sau khi bình luận
	Route::post('cmt4', ['as' => 'postCmt4', 'uses' => 'TicketThreadController@postCmt4']);

	//ajax thay đổi bộ phận IT//
	//Hiện ra đúng người của bộ phận
	Route::post('changeBP1', ['as' => 'postChangeBP1', 'uses' => 'TicketThreadController@postChangeBP1']);
	//Thay đổi tên bộ phận
	Route::post('changeBP2', ['as' => 'postChangeBP2', 'uses' => 'TicketThreadController@postChangeBP2']);
	//Mặc định giao việc cho leader của bộ phận
	Route::post('changeBP3', ['as' => 'postChangeBP3', 'uses' => 'TicketThreadController@postChangeBP3']);
	//Disable nút thay đổi bộ phận It đối với những đối tượng ko đc phép khi chính nó bị thay đổi
	Route::post('changeBP4', ['as' => 'postChangeBP4', 'uses' => 'TicketThreadController@postChangeBP4']);
	//Disable 3 nút tiếp theo khi thay đổi bộ phận IT vs những ng ko đc phép
	Route::post('changeBP5', ['as' => 'postChangeBP5', 'uses' => 'TicketThreadController@postChangeBP5']);
	//Disable nút thay đổi người liên quan đối với những đối tượng ko đc phép khi thay đổi bộ phận IT
	Route::post('changeBP6', ['as' => 'postChangeBP6', 'uses' => 'TicketThreadController@postChangeBP6']);
	//Disable nút thay đổi trạng thái đối với những đối tượng ko đc phép khi thay đổi bộ phận IT
	Route::post('changeBP7', ['as' => 'postChangeBP7', 'uses' => 'TicketThreadController@postChangeBP7']);

	//ajax thay đổi thứ tự ưu tiên//
	//Hiện thứ tự ưu tiên
	Route::post('changeUT1', ['as' => 'postChangeUT1', 'uses' => 'TicketThreadController@postChangeUT1']);
	//Hiện cmt khi thay đổi thứ tự ưu tiên
	Route::post('changeUT2', ['as' => 'postChangeUT2', 'uses' => 'TicketThreadController@postChangeUT2']);

	//ajax thay đổi người thực hiện//
	Route::post('changeAS', ['as' => 'postChangeAS', 'uses' => 'TicketThreadController@postChangeAS']);

	//ajax thay đổi trạng thái//
	//Hiện trạng thái
	Route::post('changeTT1', ['as' => 'postChangeTT1', 'uses' => 'TicketThreadController@postChangeTT1']);
	//Disable 5 nút khi trạng thái đã chuyển sang resolved,closed,cancelled
	Route::post('changeTT2', ['as' => 'postChangeTT2', 'uses' => 'TicketThreadController@postChangeTT2']);
	//Disable nút thay đổi trạng thái khi nó là resolved và ng đăng nhập là người đc assign
	Route::post('changeTT3', ['as' => 'postChangeTT3', 'uses' => 'TicketThreadController@postChangeTT3']);
	//Disable nút thay đổi trạng thái khi nó là closed, cancelled
	Route::post('changeTT4', ['as' => 'postChangeTT4', 'uses' => 'TicketThreadController@postChangeTT4']);
	//Hiển thị tên tạm thời của trạng thái khi đang chờ cmt của ng dùng và trạng thái đc chọn là feedback hoặc closed 
	Route::post('changeTT5', ['as' => 'postChangeTT5', 'uses' => 'TicketThreadController@postChangeTT5']);
	//Hiện thị đánh giá
	Route::post('changeTT6', ['as' => 'postChangeTT6', 'uses' => 'TicketThreadController@postChangeTT6']);

	//ajax thay đổi dealine//
	//Hiện deadline
	Route::post('changeDL1', ['as' => 'postChangeDL1', 'uses' => 'TicketThreadController@postChangeDL1']);
	//Hiện cmt khi thay đổi deadline
	Route::post('changeDL2', ['as' => 'postChangeDL2', 'uses' => 'TicketThreadController@postChangeDL2']);

	//ajax thay đổi người liên quan//
	Route::post('changeNLQ', ['as' => 'postChangeNLQ', 'uses' => 'TicketThreadController@postChangeNLQ']);

	//ajax đánh dâu tickket đã đọc//
	Route::post('mark-read', ['as' => 'postMarkread', 'uses' => 'TicketReadController@postMarkread']);

	Route::post('checkbox', ['as' => 'postMrCheckbox', 'uses' => 'TicketReadController@postMrCheckbox']);

	//sitemap
	Route::get('sitemap', ['as' => 'getSiteMap', 'uses' => 'HomeController@getSiteMap']);
});


Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
	Route::get('list', ['as' => 'admin.user.getList', 'uses' => 'UserController@getList']);
	Route::get('add', ['as' => 'admin.user.getAdd', 'uses' => 'UserController@getAdd']);
	Route::post('add', ['as' => 'admin.user.postAdd', 'uses' => 'UserController@postAdd']);
	Route::get('delete/{id}', ['as' => 'admin.user.getDelete', 'uses' => 'UserController@getDelete']);
	Route::get('edit/{id}', ['as' => 'admin.user.getEdit', 'uses' => 'UserController@getEdit']);
	Route::post('edit/{id}', ['as' => 'admin.user.postEdit', 'uses' => 'UserController@postEdit']);
});
