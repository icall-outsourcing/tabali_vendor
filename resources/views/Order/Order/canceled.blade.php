<!-- language -->
@if(session()->has('lang'))
	{{App::setLocale(session()->get('lang'))}}
@else
	{{App::setLocale('ar')}}
@endif
@extends('layouts.app')
@php use Carbon\Carbon; @endphp
@inject ('Carbon',Carbon\Carbon)
@php
	$contact_id   = array();
	$address_id   = array();
	$account_id   = array();
	$branch_id    = Auth::User()->getPermissions()->lists('name','id')->toArray();
	$driver_id 	  = \App\Driver::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->lists('name','id')->toArray();
@endphp
@section('content')
 	<div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li><a href="{{ url(route('Order.index')) }}" >Activity</a></li>
              	<li class="active"><a href="{{ url(route('Order.canceled')) }}">canceled</a></li>
              	<li><a href="{{ url(route('Order.closed')) }}">closed</a></li>
            </ul>
            <div class="tab-content">
				<div class="active tab-pane" id="canceled" style="width: 100%;height: 100%;overflow: auto;">
					<table id="canceledOrder" class="display" style="width:100%">
				        <thead>
				            <tr>
								@foreach($model->getCasts() as $key => $value)
									@if ($value == 'int' || $value === 'action') 
									@elseif (strpos($key, '_relation') !== false) 
										<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}</div></th>
									@else
										<th class="text-center">{{ trans('form.'.$value) }}</th>
									@endif
								@endforeach
									<th>سبب الالغاء</th>
                                    <th></th>
							</tr>
				        </thead>
				        <tbody>
			    			@foreach($datatable as $row )
								<tr style="cursor:pointer" class="tr clickable-row" data-id="{{URL::route($model->model_name.'.show',   $row->id)}}" data-href="{{URL::route($model->model_name.'.show',$row->id)}}">
									@foreach($model->getCasts() as $key => $column)
										@if ($column == 'int' || $column === 'action')

										@elseif ($column === 'id')
											<td class="col-{{$column}}" id="{{$row->$column}}"><a href="#">{{$row->$column}}</a></td>
										
										@elseif (strpos($column, '_id') !== false) 
											@php $COLUMN	=str_replace('_id','',$column); @endphp
											<td class="col-{{$column}}">
												@if(!empty($row->$COLUMN->name))
													{{$row->$COLUMN->name}}
												@else
													@if (!empty($row->$COLUMN))
														@if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;')))
															{{eval('return $row->$COLUMN->'. $COLUMN.'_name;')}}
														@endif
													@endif

												@endif
											</td>
										@elseif (strpos($column, '_by') !== false) 
											@php $COLUMN	=str_replace('_by','_name',$column); @endphp
											<td class="col-{{$column}}">
												@if(!empty($row->$COLUMN->name)){{$row->$COLUMN->name}}@endif
											</td>
										@elseif (strpos($key   , '_relation') !== false) 

											@php $COLUMN	= str_replace('_relation','',$key); @endphp
											<td class="col-{{$COLUMN}}">
												@if(!empty($row->$column))
													@foreach ($row->$column as $key => $value)
														<span class="label label-default">{{$value->$COLUMN}}</span>,
													@endforeach
												@endif
											</td>
										@else
											<!--  -->
											<td class="col-{{$column}}">{{$row->$column}}</td>
										@endif
									@endforeach
									<td class="col-cancel_note">{{$row->cancel_note}}</td>
									<td class="text-center col-action col-md-1">
										<a 			  href="#" id="showorder" data-route="{{URL::route($model->model_name.'.show',   $row->id)}}" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
									</td>
								</tr>
							@endforeach
				        </tbody>
				        <tfoot>
				            	<tr>
								@foreach($model->getCasts() as $key => $value)
									@if ($value == 'int' || $value === 'action') 
									@elseif (strpos($key, '_relation') !== false) 
										<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}</div></th>
									@else
										<th class="text-center">{{ trans('form.'.$value) }}</th>
									@endif
								@endforeach
									<th>سبب الالغاء</th>
									<th></th>
							</tr>
				        </tfoot>
				    </table>
				</div>
				
            </div>
        </div>
	</div>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" crossorigin="anonymous">
	<style type="text/css"></style>
	<script type="text/javascript">
	    $(document).ready(function() {
		    // Setup - add a text input to each footer cell
		    $('#canceledOrder tfoot th').each( function () {
		        var title = $(this).text();
		        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		    } );
		 
		    // DataTable
		    var table = $('#canceledOrder').DataTable();
		 
		    // Apply the search
		    table.columns().every( function () {
		        var that = this;
		        $( 'input', this.footer() ).on( 'keyup change', function () {
		            if ( that.search() !== this.value ) {
		                that
		                    .search( this.value )
		                    .draw();
		            }
		        } );
		    } );
		} );



		$(document).on('click','#showorder',function(e){ 
			e.preventDefault();
			var user 	= '{{Auth::user()->is("branch")}}';
			
	        var route   = $(this).data('route');
	        var status 	= $(this).parent().parent().find('.col-status');
	        var action 	= $(this).parent().parent().find('.col-actions');
	        var id 		= $(this).parent().parent().find('.col-id').attr('id');
	        var btnroute   = "{{URL::route('Order.status','')}}"+"/"+id;
			$.confirm({
	            title           : 'Show Order',
	            columnClass     : 'col-md-12',
	            closeIcon       :  true,
	            content         : 'url:'+route,
	            animation       : 'zoom',
	            cancelButton: false, // hides the cancel button.
				confirmButton: false, // hides the confirm button.
				contentLoaded : function(){
            		if(user > 0 && status.text() == 'opened' ){
            			status.text('viewed');
            			action.html('<button type="button" data-route="'+btnroute+'" data-name="processing" id="ChangeAction" class="btn btn-block btn-primary btn-xs">processing</button>');
            		}
                },
	    	});
	    });

	    



	     
                
           
	    
	</script>
@endsection