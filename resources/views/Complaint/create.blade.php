<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  
@php $branch_id  = \App\Branch::all()->lists('name','id')->toArray(); @endphp
  
@extends('layouts.app')
@section('content')
  @include('layouts.form')
    @if(Input::get('order'))
    <input class="Append" type="hidden" id="order_id" name="order_id" value="{{Input::get('order')}}">
    @endif
    <script type="text/javascript">
    	jQuery(document).ready(function($) {
	    	$('#account_id').val("{{$account->id}}");
	    	$('#contact_id').val("{{$contact->id}}");
	    	$('#branch_id').val("{{$branch->id}}");
	    	$('.NewAppend').append($('.Append'));
	    });
    </script>
@endsection
