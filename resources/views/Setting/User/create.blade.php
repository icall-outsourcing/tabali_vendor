<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  <style>
button#submit {
    margin: -11px 20px 62px 0;
}
</style>
<!-- language -->
@inject('roles', 'Bican\Roles\Models\Role')
@inject('permissions', 'Bican\Roles\Models\Permission')
@inject('printers', 'App\Printer')
<!-- listing roles array for select element -->
@php 
  if(Auth::user()->is('admin')){
    $roles        = $roles->pluck('name','id')->toArray();
  }else{
    $roles        = $roles->where('slug','agent')->pluck('name','id')->toArray();
  }
	$permissions  = $permissions->pluck('name','id')->toArray(); 
	$printers     = $printers->all();       
@endphp
@extends('layouts.app')
@section('content')
 	@include('layouts.form')
    <div class="Append roles_list col-md-4">
        <div class="form-group">
          <label for="Roles">{{ trans('form.roles') }}</label>
          {!! Form::select("roles_list[]",$roles ,null,["class" => "form-control select2","id" => "role","required" =>"required",'multiple'=>'multiple',"style"=>"width:100%"])!!}
        </div>
    </div>
    <div class="Append permissions_list col-md-4">
        <div class="form-group">
          <label for="Permissions">{{ trans('form.permissions') }}</label>
          {!! Form::select("permissions_list[]",$permissions ,null,["class" => "form-control select2","id" => "permissions","required" =>"required",'multiple'=>'multiple',"style"=>"width:100%"])!!}
        </div>
    </div>

    @if(Auth::user()->is('admin|helpdesk'))
    <div class="Append col-md-12">
      <div class="panel panel-default clearfix">
        <div class="panel-heading" style="height:50px !important">
          <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#feature-2"> <i class="glyphicon glyphicon-resize-vertical"></i>Toggle Feature Set</button> -->
          <div class="col-xs-5 panel-title"> Printer Name</div>
          <div class="col-xs-5 text-center"> Branch Name </div>
          <!-- <div class="col-xs-4 text-center"> ID </div> -->
          <div class="col-xs-2 text-center"> check </div>
        </div>      
        <div id="feature-2" class="collapse in">
            @foreach($printers as $print)
              <div class="panel-body">
                <div class="row">                  
                  <div class="col-xs-5">{{$print->printer_name}} </div>
                  <div class="col-xs-5 text-center">{{$print->printer_key}}</div>
                  <div class="col-xs-2 text-center"> <input type="checkbox" name="printers[]" value="{{$print->id}}"></div>
                </div>
              </div> 
            @endforeach               
        </div>
      </div>
    </div>
    @endif
    <script type="text/javascript"> $('.NewAppend').append($('.Append')); </script>




@endsection
       
