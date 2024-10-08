<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif


   
@extends('layouts.app')
@php $gift_id  = \App\Gift::all()->lists('name','id')->toArray(); @endphp
@section('content')
<div class="container-fluid ">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="Voucher">
	<input type="hidden" id="groupby" 	 value="id">
	<input type="hidden" id="path" 	 	 value="Setting">
	<input type="hidden" id="conditions" value='{}' name="conditions">
 	@include('layouts.index')
 	
	<!--End Index-->
</div>
<script type="text/javascript">
	$('.col-int').remove();
	$('.Show').remove();
	$('.destroy').remove();
</script>
@endsection
