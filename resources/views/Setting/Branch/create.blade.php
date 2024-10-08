<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif

@extends('layouts.app')
@section('content')
    @include('layouts.form')


    <script type="text/javascript">
	    $(function () {
	        $('#close_on').datetimepicker({
	        	format: 'HH:mm',
	        	defaultDate: ' {{date("HH:mm", time())}}'
	        });	       	       
	    });
  	</script>
@endsection
