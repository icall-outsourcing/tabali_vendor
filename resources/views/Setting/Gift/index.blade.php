<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
@extends('layouts.app')
@section('content')
<div class="container-fluid ">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="Gift">
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
