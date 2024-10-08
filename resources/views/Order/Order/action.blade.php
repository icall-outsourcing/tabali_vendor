<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  @php /*
<!--<script src="{{asset('packages/jquery/jquery.min.js')}}" crossorigin="anonymous"></script>-->
<!--<script src="{{asset('packages/validate/jquery.validate.js')}}"></script>-->
<!--<script src="{{asset('packages/confirm/jquery-confirm.min.js')}}"></script>-->
<!--<script src="{{asset('packages/datetimepicker/moment-with-locales.js')}}"></script>-->
<!--<script src="{{asset('packages/datetimepicker/bootstrap-datetimepicker.js')}}"></script>-->
*/ @endphp


<form enctype ='multipart/form-data' id='myForm' data-toggle='validator' role="form" method="post" action="{{url(route('Order.statuspost',$id))}}">
	<div class="box box-primary">
    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="box-body">
			<div class="form-group">
				<label for="status">Chnage Status from <span class="label label-danger">{{$order->status}}</span> to</label>
				<select class="form-control" id="status" name="status">
					@if($order->status == 'viewed')
	                	<option>processing</option>
						@if (Auth::user()->is('admin|tabaliadmin|teamleader')) 
	                  		<option>canceled</option>
						@endif
                  	@elseif($order->status == 'processing')
	                  	<option>ondelivery</option>
	                  	@if (Auth::user()->is('admin|tabaliadmin|teamleader')) 
	                  		<option>canceled</option>
						@endif
                  	@elseif($order->status == 'ondelivery')
	                  	<option>closed</option>
	                  	@if (Auth::user()->is('admin|tabaliadmin|teamleader')) 
	                  		<option>canceled</option>
						@endif
					@endif
                </select>
            </div>
			@if($order->status == 'ondelivery')
				<div class="form-group">
                    <label for="delivered_at" class="control-label">{{ trans('form.delivered_at') }} </label>
                        <div class='check_delivered_at input-group' id='delivered_at'>
                            {!! Form::text('delivered_at', null , ['class' => 'form-control','id' => 'date-delivered_at']) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <script type="text/javascript">$(function () {$('#delivered_at').datetimepicker({format: 'YYYY-MM-DD HH:m:ss',toolbarPlacement: 'top',defaultDate: ' {{date("Y-m-d h:t:s")}}'});});</script>			        
				<div class="form-group">
                	<label for="branch_comment" class="control-label">{{ trans('form.branch_comment') }} </label>
                       {!! Form::textarea('branch_comment', null , ['class' => 'form-control','id' => 'branch_comment','size' => '30x5']) !!}
                    
                    </div>
                </div>
			@endif
			@if($order->status == 'processing')
	            <div class="form-group">
	            	<label for="driver_id">Driver</label>
	            	<select class="form-control" id="driver_id" name="driver_id">
	                	@if(!empty($order->driver->name))
	                		<option value="{{$order->driver->id}}"> {{$order->driver->name}} </option>
	                	@else
	                		<option></option>
	                	@endif
	                	@foreach (\App\Driver::where('status','Y')->where('branch_id',$order->branch_id)->get() as $value)
	                  		<option value="{{$value->id}}">{{$value->name}}</option>
	                  	@endforeach
	                	
	                </select>
				</div>
			@endif
			<div class="box-footer">
				<button type="submit" class="btn btn-success">Chnage it :)</button>
			</div>
			<br/>
		</div>
	</div>
</form>
<!--if($Complaint > 0 )-->
<script type="text/javascript">/*$.alert({columnClass: 'col-md-4 col-md-push-4 col-sm-6',title: 'الشكاوى',content: '<div class="alert alert-danger">يرجى اغلاق الشكاوى المفتوحة</div>', }); */</script>
<!--endif-->
<script type="text/javascript">
	$('#myForm button[type=submit]').click(function(e){
        e.preventDefault();
        var form = jQuery(this).parents("form:first");
        var dataString = form.serialize();
        var formAction = form.attr('action');
        var btnroute   = "{{URL::route('Order.status',$id)}}";
        $.ajax({
            type: "POST",
            url : formAction,
            data : dataString,
            success : function(data){
            	//$("#"+data.id).parent().remove();
            	$('.jconfirm').remove();
            	var status 	= $("#"+data.id).parent().find('.col-status');
	        	var action 	= $("#"+data.id).parent().find('.col-actions');
            	status.text(data.status);
				if(data.status == 'processing'){
					action.html('<button type="button" data-route="'+btnroute+'" data-name="ondelivery" id="ChangeAction" class="btn btn-block btn-warning btn-xs">ondelivery</button>');
            	}else if(data.status == 'ondelivery'){
					action.html('<button type="button" data-route="'+btnroute+'" data-name="closed" id="ChangeAction" class="btn btn-block btn-success btn-xs">closed</button>');
            	}else if(data.status == 'closed'){
            		$("#"+data.id).parent().remove();
            	}
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
</script>
@if($order->status == 'processing')
	<script type="text/javascript">function driverPrint(){
	      pageid();
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
	  	};</script>
@else
	<script type="text/javascript">function driverPrint(){pageid();return false;};</script>
@endif