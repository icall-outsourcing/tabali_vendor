<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
@include('layouts.pageid')
<script type="text/javascript">
	$('.col-int').remove();
	$('.Show').remove();
	$('.destroy').remove();
</script>	