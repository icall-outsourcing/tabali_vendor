<!-- language -->
    @if(session()->has('lang'))
        {{App::setLocale(session()->get('lang'))}}
    @else
        {{App::setLocale('ar')}}
    @endif
@extends('layouts.app')
	@php
        $branch_id  = \App\Branch::all()->lists('name','id')->toArray();
        $governorate= \App\Governorate::all()->lists('name','id')->toArray();
        $district   = array();
        $subdistrict= array();
        $area       = array();
        if (Input::get('ani') > 0){
            $caller = 'ani';
            $phone_number = Input::get('ani');
            $required = 'true';
        }elseif (Input::get('add') > 0){
            $caller = 'addaccount';
            $phone_number = '';
            $required = 'false';
        }elseif (Input::get('search') > 0)
        {
            $caller = 'search';
            $phone_number = Input::get('search');
            $required = 'true';
        }else{
            $caller = 0;
            $phone_number = '';
            $required = 'true';
        }
    @endphp
@section('content')
<style type="text/css">
  .twitter-typeahead{
    width: 100% !important;
  }
  .tt-menu{
    width: 100% !important;
  }
  .remotearea .tt-menu {
   max-height: 150px;
   overflow-y: auto;
   border-left: 1px solid;
   border-right: 1px solid;
   border-bottom: 1px solid;
 }
</style>
    <div class="container-fluid">
    	<div class="row">
			<div class="col-md-8 col-md-push-2">
				<div class="box box-Success">
			        <div class="box-header with-border"><h3 class="box-title text-green">{{trans('form.account')}}</h3></div>
			        <div class="box-body" style="display: block;">
			          	@include('layouts.form')
			        </div>
			  	</div>
			</div>
      	</div>      
    </div>
    <script type="text/javascript">
	    $('.NewAppend').append($('.Append'));
        $(".governorate").remove();
        $(".district").remove();
        $(".subdistrict").remove();
        $(".area").remove();
        $(".address").remove();
        $(".landmark").remove();
        $(".building_number").remove();
        $(".branch_id").remove();
        $(".apartment").remove();
        $(".floor").remove();
        $('#caller').val('{{old("caller") ? old("caller") : $caller }}');
    </script>

@endsection