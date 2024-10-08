<!-- language -->
@if(session()->has('lang'))
  {{App::setLocale(session()->get('lang'))}}
@else
  {{App::setLocale('ar')}}
@endif
<script src="{{asset('packages/jquery/jquery.min.js')}}" crossorigin="anonymous"></script>
<script src="{{asset('packages/validate/jquery.validate.js')}}"></script>
<script src="{{asset('packages/confirm/jquery-confirm.min.js')}}"></script>
<script src="{{asset('packages/datetimepicker/moment-with-locales.js')}}"></script>
<script src="{{asset('packages/datetimepicker/bootstrap-datetimepicker.js')}}"></script>
<form enctype ='multipart/form-data' id='myForm' data-toggle='validator' role="form" method="post" action="{{url(route('Order.driverpost',$id))}}">
	<div class="box box-primary">
  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="box-body">
      <div class="form-group">
      	<label for="driver_id">Driver</label>
      	<select class="form-control" id="driver_id" name="driver_id">
          	@if(!empty($order->driver->name))
          		<option value="{{$order->driver->id}}"> {{$order->driver->name}} </option>
          	@else
          		<option></option>
          	@endif
              <!--foreach (\App\Driver::where('id', '!=' , $order->driver_id)->get() as $value) -->
          	  @foreach (\App\Driver::where('status','Y')->where('branch_id',$order->branch_id)->get() as $value)
            		<option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
        </select>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-success">Chnage it :)</button>
      </div>
      <br/>
    </div>
	</div>
</form>
<script type="text/javascript">
  $('#myForm button[type=submit]').click(function(e){
    e.preventDefault();
    var form = jQuery(this).parents("form:first");
    var dataString = form.serialize();
    var formAction = form.attr('action');
    var btnroute   = "{{URL::route('Order.driver',$id)}}";
    $.ajax({
        type: "POST",
        url : formAction,
        data : dataString,
        success : function(data){
        	$('.jconfirm').remove();
        	var status 	= $("#"+data.id).parent().find('.col-status');
          var action  = $("#"+data.id).parent().find('.col-actions');
      	  var driver 	= $('.col-driver_id'+data.id);
		      driver.html('<button type="button" data-route="'+btnroute+'" data-name="driver" id="ChangeAction" class="btn btn-block btn-success btn-xs">'+data.name+'</button>');
          driverPrint();
        },
        error : function(data){
        	$.alert({
		        icon: 'fa fa-spinner fa-spin',
		        title: 'Opps',
		        content: "{{trans('form.missingfields')}}"
		      });
        }
  	},"json");
  });


  function driverPrint(){
      //GO TO Controller and Print
      $.ajax({
          url     :"{{url('Order/autoPrint')}}?order_id={{$order->id}}",
          data    :{},
          dataType:'html',
          type    :'get',
          success : function(data){
              $("#autoPrint").html("");
              $("#autoPrint").html(data);
              WebBrowser1.ExecWB(6, 2) //use 6, 1 to prompt the print dialog or 6, 6 to omit it;
              WebBrowser1.outerHTML = "";
          }
      });
      // return false;
  };
</script>