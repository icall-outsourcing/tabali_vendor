<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
class SettingController extends Controller
{
    //
    public static function lang()
    {
    	if (session()->has('lang')) {
    		if (session()->get('lang') == 'ar') 
    		{
    			App::setlocale('ar');
    			$lang = 'ar';
    		}
    		else{
    			App::setlocale('en');
    			$lang = 'en';
    		}
    	}else{
    		App::setlocale('ar');
    		$lang = 'ar';
    	}
    	return $lang;
    }
}
