<?php
ini_set('xdebug.max_nesting_level', 160);

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

App::singleton('lang',function(){
	return App\http\controller\Setting\Setting::lang();
});

Route::get('lang/{lang}', function ($lang){
	if($lang == 'ar')
	{
		session()->put('lang','ar');
	}else{
		session()->put('lang','en');
	}
	return back();
});
//View::share('lang','ar');
//return session()->get('lang');

//dd(session()->get('lang'));
/*
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
*/


	Route::get('/', function () {return redirect('home');});
	
	Route::get('/needtoprint/{brnachID}', array('as'=>'Order.print.needToPrintByBranch','uses'	=>'Order\PrintController@needToPrintByBranch'));
	Route::get('/getprinters/{brnachID}', array('as'=>'Order.print.getPrinterByBranch','uses'	=>'Order\PrintController@getPrinterByBranch'));
	Route::get('/print/{driver}/{printerIp}/{Order}', array('as'=>'Order.print.print','uses'	=>'Order\PrintController@printPython'));
	Route::get('/confirmPrint/{printerIp}/{Order}', array('as'=>'Order.print.Confirm','uses'	=>'Order\PrintController@confirmPrint'));


	Route::get('/PrinterOrder/{id}'	, array('as'=>'Order.print.show','uses'	=>'Order\PrintController@show'));
	Route::get('/autoprint/{id}/{driver}/{printerId}.pdf'	, array('as'=>'Print.index','uses'	=>'Order\PrintController@index'));




	// Route::group(['middleware' => ['web']], function () {
		//




		Route::auth();
		Route::any('/home'	, array('as'	=>'home','uses'	=>'HomeController@index'));
		Route::get('/authrole', 'HomeController@authrole');

		//Ajax for all Users
			Route::post('resetmypassword' , array('as'=>'postpassword'  ,'uses'=>'Setting\UserController@postpassword'));
			Route::any('Search'			 	, array('as'	=>'Search','uses'	=>'AjaxController@Search'));
			Route::get('Ajaxrelationlist'	, array('as'=>'Ajaxrelationlist','uses'=>'AjaxController@Ajaxrelationlist'));
			Route::get('Ajaxdropdown'    	, array('as'=>'Ajaxdropdown','uses'=>'AjaxController@Ajaxdropdown'));
			Route::get('Ajaxrow'   		 	, array('as'=>'Ajaxrow','uses'=>'AjaxController@Ajaxrow'));
			Route::get('find' 				,'Order\OrderController@find');
			Route::get('Ajaxtable'			, array('as'=>'Ajaxtable','uses'=>'AjaxController@Ajaxtable'));
			Route::get('/Order/autoPrint'	, array('as'=>'Order.print','uses'	=>'Order\OrderController@autoPrint'));
			Route::get('/Complaint'	, array('as'=>'Complaint.index','uses'	=>'ComplaintController@index'));
			Route::get('/Complaint/{id}/edit'	, array('as'=>'Complaint.edit','uses'	=>'ComplaintController@edit'));
			Route::resource('Voucher'	,'Setting\VoucherController');
		//Agent & teamleader
			Route::group(['middleware' => 'role:admin||agent||teamleader||tabaliadmin'], function () {
				Route::any('/Account/link'				, array('as'=>'Account.link','uses'	=>'Account\AccountController@linkaccount'));
				Route::any('/Contact/link'				, array('as'=>'Contact.link','uses'	=>'Account\ContactController@linkcontact'));
				Route::any('/Address/find/{id}'  		, array('as'=>'Address.find','uses'	=>'Account\AddressController@find'));
				Route::any('/Complaint/sendmail/{id}'	, array('as'=>'Complaint.sendmail','uses'=>'ComplaintController@sendmail'));
				Route::any('/Complaint/create'			, array('as'=>'Complaint.create','uses'	=>'ComplaintController@create'));
				Route::post('/Complaint/store'			, array('as'=>'Complaint.store','uses'	=>'ComplaintController@store'));
				Route::any('/Inquiry/create'			, array('as'=>'Inquiry.create','uses'	=>'InquiryController@create'));
				Route::post('/Inquiry/store'			, array('as'=>'Inquiry.store','uses'	=>'InquiryController@store'));
				Route::resource('Account'	    		,'Account\AccountController');
				Route::resource('Contact'	    		,'Account\ContactController');
				Route::resource('Address'	    		,'Account\AddressController');
			});
			



		//supervisor, branch & teamleader
			Route::group(['middleware' => 'role:admin||branch||supervisor||teamleader||tabaliadmin'], function () {
				Route::get('/Order/status/{id}'	, array('as'=>'Order.status','uses'	=>'Order\OrderController@statusget'));
				Route::post('/Order/status/{id}', array('as'=>'Order.statuspost','uses'	=>'Order\OrderController@statuspost'));
				Route::get('/Order/driver/{id}'	, array('as'=>'Order.driver','uses'	=>'Order\OrderController@driverget'));
				Route::post('/Order/driver/{id}', array('as'=>'Order.driverpost','uses'	=>'Order\OrderController@driverpost'));
				
				Route::put('/Complaint/{id}'	, array('as'=>'Complaint.update','uses'	=>'ComplaintController@update'));
				Route::post('/Complaint/{id}/destroy'	, array('as'=>'Complaint.destroy','uses'	=>'ComplaintController@destroy'));
			});
			//supervisor & teamleader
				Route::group(['middleware' => 'role:admin||supervisor||teamleader||tabaliadmin||branch'], function () {								
					Route::resource('Driver'	        ,'Setting\DriverController');					
					Route::resource('Product'			,'Setting\ProductController');
					
				});
			//supervisor & teamleader & Account
			Route::group(['middleware' => 'role:admin||supervisor||teamleader||tabaliadmin||branch||account'], function () {												
				Route::resource('Report'			,'ReportController');			
			});

			


		//supervisor & teamleader
			Route::group(['middleware' => 'role:admin||supervisor||teamleader||tabaliadmin'], function () {												
				Route::resource('Product'			,'Setting\ProductController');
				Route::get('Product/{id}/editProduct','Setting\ProductController@editall');
		            	Route::put('Product/{id}/updateall','Setting\ProductController@updateall');
				
			});
		//admin & teamleader
			Route::group(['middleware' => 'role:admin||teamleader||helpdesk'], function () {
				Route::resource('User'		,'Setting\UserController');				
			});
		//helpdesk
			Route::group(['middleware' => 'role:admin||helpdesk||tabaliadmin'], function () {								
				Route::resource('Printer'	        ,'Setting\PrinterController');				
			});
		// admin & tabaliadmin
			Route::group(['middleware' => 'role:admin||tabaliadmin'], function () {												
				Route::resource('Branch'	,'Setting\BranchController');				
							
				Route::get('/Inquiry'	, array('as'=>'Inquiry.index','uses'	=>'InquiryController@index'));
				Route::get('/Inquiry/{id}'	, array('as'=>'Inquiry.show','uses'	=>'InquiryController@show'));
				Route::get('/Inquiry/{id}/edit'	, array('as'=>'Inquiry.edit','uses'	=>'InquiryController@edit'));
				Route::put('/Inquiry/{id}'	, array('as'=>'Inquiry.update','uses'	=>'InquiryController@update'));
				Route::post('/Inquiry/{id}/destroy'	, array('as'=>'Inquiry.destroy','uses'	=>'InquiryController@destroy'));
			});
		// admin
			Route::group(['middleware' => 'role:admin'], function () {												
				Route::resource('Gift'		,'Setting\GiftController');
				
			});

		// 
			Route::get('/Complaint/{id}'	        , array('as'=>'Complaint.show','uses'	=>'ComplaintController@show'));
			Route::post('/Order/printerUpdate/{id}' , array('as'=>'Order.printerUpdate','uses'	=>'Order\OrderController@printerUpdate'));
			Route::post('/Order/transfer/{id}'      , array('as'=>'Order.transfer','uses'	=>'Order\OrderController@transfer'));
			Route::get('/Order/extraItems'         	, array('as'=>'Order.extraItems','uses'	=>'Order\OrderController@extraItems'));    
			Route::get('/Order/canceled'	        , array('as'=>'Order.canceled','uses'	=>'Order\OrderController@canceled'));
			Route::get('/Order/closed'	            , array('as'=>'Order.closed','uses'	=>'Order\OrderController@closed'));
			Route::resource('/Order'		,'Order\OrderController');
	// });
