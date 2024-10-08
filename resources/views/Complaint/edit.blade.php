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


    @if($EditData->order_id)
    <div class="Append order_id col-md-4">
      
        <div class="form-group">
            
            <label for="order_id" class="control-label"> رقم الطلب </label>
            {!! Form::text('order_id',$EditData->order_id,['class' => 'form-control','id' => 'order_id','disabled'])!!}

            <a href="#" id="showorder" data-route="{{url(route('Order.show',$EditData->order_id))}}" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
        </div>
      
    </div>
    @endif


    <div class="well Append col-md-4">
        
    <div class="  status col-md-12">
        <div class="form-group">
            @php $status = array ('opened'=>'opened','processing'=>'processing','closed'=>'closed');@endphp
            <label for="status" class="control-label"> حالة الشكوى </label>
            {!! Form::select('status',$status,$EditData->status,['class' => 'form-control','id' => 'status'])!!}
        </div>
    </div>
    <div class="  close_complain_comment col-md-12">
        <div class="form-group">
            <label for="close_complain_comment" class="control-label"> حل الشكوى  </label>
            <div class="check_close_complain_comment">
                <textarea class="form-control" id="close_complain_comment" name="close_complain_comment" cols="30" rows="5">{{$EditData->close_complain_comment}}</textarea>
                </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $('.NewAppend').append($('.Append'));

        document.getElementById("Priority").disabled = true;
        document.getElementById("branch_id").disabled = true;
        document.getElementById("follow_up_phone").disabled = true;
        document.getElementById("complaint_type").disabled = true;
        document.getElementById("complain_comment").disabled = true;


	$(document).on('click','#showorder',function(e){ 
	   e.preventDefault();
	   var route   = $(this).data('route');
	   $.confirm({
		            title           : 'Show Order',
		            columnClass     : 'col-md-12',
		            closeIcon       :  true,
		            content         : 'url:'+route,
		            //animation     : 'top',
		            //closeAnimation: 'bottom',
		            animation       : 'zoom',
		            cancelButton: false, // hides the cancel button.
					confirmButton: false, // hides the confirm button.
	        	});
	        });


    </script>
@endsection
