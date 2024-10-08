<!-- language -->
    @if(session()->has('lang'))
        {{App::setLocale(session()->get('lang'))}}
    @else
        {{App::setLocale('ar')}}
    @endif
@extends('layouts.app')

@section('content')

    <div class="container-fluid">
      <div class="row">
      <div class="col-md-8 col-md-push-2">
        <div class="box box-Success">
              <div class="box-header with-border"><h3 class="box-title text-green">{{trans('form.account')}}</h3></div>
              <div class="box-body" style="display: block;">
                  @include('layouts.form')
                  <input class="Append" type="hidden" name="phone_number" value="{{Input::get('phone_number')}}">
              </div>
          </div>
      </div>
        </div>      
    </div>
    <script type="text/javascript">
      $('.NewAppend').append($('.Append'));
      
    </script>
@endsection